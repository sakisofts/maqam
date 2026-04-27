<?php

namespace app\components\behaviors;

use yii\base\Behavior;
use yii\web\Controller;
use yii\base\Action;
use yii\caching\Cache;
use yii\db\Query;
use yii\base\Module;
use Yii;

class Sec extends Behavior
{
    /**
     * @var int Cache duration in seconds
     */
    public int $cacheDuration = 3600;

    /**
     * @var string Cache key prefix
     */
    public string $cachePrefix = 'rbac_';

    /**
     * @var array Controllers that should bypass permission checking
     */
    public array $excludedControllers = ['site'];

    /**
     * @var array Actions that should be accessible to guests
     */
    public array $guestActions = ['login', 'error', 'captcha'];

    /**
     * @var bool Enable debug tracing
     */
    public bool $enableTracing = false;

    /**
     * @var array User's permissions array
     */
    private array $userPermissions = [];

    /**
     * @var array User's roles array
     */
    private array $userRoles = [];

    /**
     * @var array ABAC rules cache
     */
    private array $abacRules = [];

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);
        $this->loadUserPermissions();
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'checkAccess',
            'afterLogin' => 'refreshPermissionsCache'
        ];
    }

    /**
     * Refresh permissions cache after login
     */
    public function refreshPermissionsCache(): void
    {
        $userId = Yii::$app->user->id;
        if ($userId) {
            $cacheKey = $this->cachePrefix . 'user_' . $userId;
            $data = $this->loadPermissionsFromDb($userId);
            Yii::$app->cache->set($cacheKey, $data, $this->cacheDuration);
            $this->userRoles = $data['roles'] ?? [];
            $this->userPermissions = $data['permissions'] ?? [];
            $this->trace("Permissions cache refreshed after login for user ID: $userId");
        }
    }

    /**
     * Debug trace helper
     * @param string $message
     * @param mixed $data
     */
    private function trace(string $message, $data = null): void
    {
        if ($this->enableTracing) {
            Yii::debug("[Sec Behavior] $message", 'security');
            if ($data !== null) {
                Yii::debug($data, 'security');
            }
        }
    }

    /**
     * Load permissions from database
     * @param int $id User ID
     * @return array
     */
    private function loadPermissionsFromDb($id)
    {
        // Load user roles
        $roles = (new Query())
            ->select(['r.name', 'r.parent_role'])
            ->from(['ur' => 'auth_user_roles'])
            ->innerJoin(['r' => 'auth_roles'], 'r.id = ur.role_id')
            ->where(['ur.user_id' => $id])
            ->all();

        // Load direct permissions
        $directPermissions = (new Query())
            ->select(['p.permission', 'p.params'])
            ->from(['up' => 'auth_user_permissions'])
            ->innerJoin(['p' => 'auth_permissions'], 'p.id = up.permission_id')
            ->where(['up.user_id' => $id])
            ->all();

        // Load role permission
        $roleNames = array_column($roles, 'name');
        $rolePermissions = (new Query())
            ->select(['p.permission', 'p.params'])
            ->from(['rp' => 'auth_role_permissions'])
            ->innerJoin(['p' => 'auth_permissions'], 'p.id = rp.permission_id')
            ->innerJoin(['r' => 'auth_roles'], 'r.id = rp.role_id')
            ->where(['r.name' => $roleNames])
            ->all();

        // Merge permissions and process inheritance
        $permissions = array_merge($directPermissions, $rolePermissions);
        $processedPermissions = $this->processPermissions($permissions);

        return [
            'roles' => $this->processRoleInheritance($roles),
            'permissions' => $processedPermissions,
        ];
    }

    /**
     * Load user permissions from cache or database
     */
    private function loadUserPermissions(): void
    {
        $userId = Yii::$app->user->id;

        $this->trace("Loading permissions for user ID: $userId");

        if (!$userId) {
            $this->trace("No user ID found - setting guest permissions");
            $this->userPermissions = $this->getGuestPermissions();
            $this->userRoles = []; // Ensure roles are empty for guests
            return;
        }

        $cacheKey = $this->cachePrefix . 'user_' . $userId;
        $cache = Yii::$app->cache;

        // Always load fresh data from database if user just logged in
//        !Yii::$app->user->isGuest ||
        if (empty($cache->get($cacheKey))) {
            $this->trace("User just logged in - loading fresh permissions from database");
            $data = $this->loadPermissionsFromDb($userId);
            $cache->set($cacheKey, $data, $this->cacheDuration);
        } else {
            $data = $cache->get($cacheKey);
            if ($data === false) {
                $this->trace("Cache miss - loading from database");
                $data = $this->loadPermissionsFromDb($userId);
                $cache->set($cacheKey, $data, $this->cacheDuration);
            } else {
                $this->trace("Cache hit - using cached permissions");
            }
        }

        $this->userRoles = $data['roles'] ?? [];
        $this->userPermissions = $data['permissions'] ?? [];

        $this->trace("cache data", $data);
        $this->trace("Loaded roles", $this->userRoles);
        $this->trace("Loaded permissions", $this->userPermissions);
    }

    /**
     * Get default guest permissions
     * @return array
     */
    private function getGuestPermissions(): array
    {
        $permissions = [];
        foreach ($this->excludedControllers as $controller) {
            $permissions[] = "$controller/*";
        }
        foreach ($this->guestActions as $action) {
            $permissions[] = "site/$action";
        }
        return $permissions;
    }

    /**
     * Handling actions in modules
     * Get full permission key including module path
     * @param string $controllerId
     * @param string $actionId
     * @return string
     */
    private function getPermissionKey(string $controllerId, string $actionId): string
    {
        $module = Yii::$app->controller->module;
        $modulePath = '';

        while ($module && $module->id !== Yii::$app->id) {
            $modulePath = $module->id . '/' . $modulePath;
            $module = $module->module;
        }

        return rtrim($modulePath . $controllerId . '/' . $actionId, '/');
    }

    /**
     * Process role inheritance
     * @param array $roles
     * @return array
     */
    private function processRoleInheritance(array $roles): array
    {
        $processedRoles = [];
        foreach ($roles as $role) {
            $processedRoles[] = $role['name'];
            if (!empty($role['parent_role'])) {
                $processedRoles[] = $role['parent_role'];
            }
        }
        return array_unique($processedRoles);
    }

    /**
     * Process permissions with parameters
     * @param array $permissions
     * @return array
     */
    private function processPermissions(array $permissions): array
    {
        $processed = [];
        foreach ($permissions as $permission) {
            $key = $permission['permission'];
            $processed[] = $key;
        }
        return array_unique($processed);
    }

    /**
     * Check permission parameters
     * @param array $permissionParams
     * @param array $requestParams
     * @return bool
     */
    private function checkPermissionParams($permissionParams, array $requestParams): bool
    {
        if (empty($permissionParams)) {
            return true;
        }
        foreach ($permissionParams as $key => $value) {
            if (!isset($requestParams[$key]) || $requestParams[$key] != $value) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check access before action execution
     * @param \yii\base\ActionEvent $event
     * @return bool|null
     */
    public function checkAccess($event)
    {
        $controllerId = $this->owner->id;
        $actionId = $event->action->id;

        $this->trace("Checking access for $controllerId/$actionId");

        // Skip check for excluded controllers
        if (in_array($controllerId, $this->excludedControllers)) {
            $this->trace("Controller '$controllerId' is excluded from checks");
            return true;
        }

        // Allow guest actions
        if (
            Yii::$app->user->isGuest &&
            ($controllerId === 'site' && in_array($actionId, $this->guestActions))
        ) {
            $this->trace("Allowing guest access to $actionId");
            return true;
        }

        // checking of permissions
        if (!$this->hasPermission($controllerId, $actionId)) {
            if (Yii::$app->user->isGuest) {
                $this->trace("Access denied - user is guest, go to login");
                Yii::$app->user->loginRequired();
                return false;
            }
            $this->trace("Access denied - insufficient permissions");
            throw new \yii\web\ForbiddenHttpException('Access denied - insufficient permissions');
        }

        $this->trace("Access granted");
        return true;
    }

    /**
     * Check if user has permission for specific controller and action
     * @param string $controllerId
     * @param string $actionId
     * @param array $params
     * @return bool
     */
    public function hasPermission(string $controllerId, string $actionId, array $params = []): bool
    {
        $permissionKey = $this->getPermissionKey($controllerId, $actionId);
        $wildcardKey = $this->getPermissionKey($controllerId, '*');
        $globalKey = '*/*';

        $this->trace("Checking permission for: $permissionKey");

        // Check specific permission
        if (in_array($permissionKey, $this->userPermissions)) {
            return true;
        }

        // Check controller-wide permission
        if (in_array($wildcardKey, $this->userPermissions)) {
            return true;
        }

        // Check global permission
        if (in_array($globalKey, $this->userPermissions)) {
            return true;
        }

        return false;
    }

    /**
     * Check if user has a specific role
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role)
    {
        $userId = $userId ?? Yii::$app->user->id;
        $cacheKey = $this->cachePrefix . 'user_' . $userId;
        $cache = Yii::$app->cache;
        $data = $cache->get($cacheKey);
        return in_array($role, $data ? $data['roles']:[]);
    }

    /**
     * Invalidate user's permission cache
     * @param int|null $userId
     */
    public function invalidateCache(?int $userId = null): void
    {
        $userId = $userId ?? Yii::$app->user->id;
        if ($userId) {
            $cacheKey = $this->cachePrefix . 'user_' . $userId;
            Yii::$app->cache->delete($cacheKey);
            $this->trace("Cache invalidated for user ID: $userId");
        }
    }

    /**
     * Get all user roles
     * @return array
     */
    public function getUserRoles(): array
    {
        return $this->userRoles;
    }

    /**
     * Get all user permissions with their parameters
     * @return array
     */
    public function getUserPermissions(): array
    {
        return $this->userPermissions;
    }
}

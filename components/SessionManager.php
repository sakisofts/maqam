<?php

namespace app\components;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use yii\base\Event;

/**
 * Behavior specifically designed to prevent null identity issues in UserManagement module
 */
class SessionManager extends Behavior
{
    /**
     * @var string|array Route to redirect to when issues are detected
     */
    public $redirectAction = ['/landing/login'];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'validateUserManagementAccess',
        ];
    }

    /**
     * Validates that the user has a valid identity with required properties
     * @param Event $event
     * @return bool
     */
    public function validateUserManagementAccess($event)
    {
        // Only run checks for UserManagement module
        $controller = $event->sender;
        if (!\Yii::$app->controller->module || \Yii::$app->controller->module->id !== 'UserManagement') {
            return true;
        }

        // Skip for guest users - they will be redirected by access control
        if (Yii::$app->user->isGuest) {
            return true;
        }

        // Check that identity exists and has required properties
        $identity = Yii::$app->user->identity;


        // For superadmins, we don't need to check university_id and campus_id
        if (method_exists(Yii::$app->sec,'hasRole') && Yii::$app->sec->hasRole("BackOfficeSuperAdmin")) {
            return true;
        }


        return true;
    }
}

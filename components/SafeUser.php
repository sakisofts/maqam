<?php

namespace app\components;

use Yii;
use yii\web\User;

/**
 * SafeUser extends the standard Yii User component to provide null-safety for identity objects
 */
class SafeUser extends User
{
    /**
     * @var array Default values to use when identity is null
     */
    public $defaultIdentityValues = [
        'university_id' => null,
        'campus_id' => null,
        // Add any other properties that might be accessed
    ];

    /**
     * @var object A fallback identity object to use when real identity is null
     */
    private $_fallbackIdentity;

    /**
     * @var bool Flag to prevent recursion
     */
    private $_inGetIdentity = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // Create a fallback identity as a standard object
        $this->_fallbackIdentity = (object)$this->defaultIdentityValues;

        Yii::debug('SafeUser component initialized', 'user');
    }

    /**
     * @inheritdoc
     * Overrides getIdentity to never return null for authenticated users
     */
    public function getIdentity($autoRenew = true)
    {
        // Prevent infinite recursion
        if ($this->_inGetIdentity) {
            return parent::getIdentity(false); // Use false to prevent auto-renew recursion
        }

        $this->_inGetIdentity = true;

        try {
            // Get the identity from parent
            $identity = parent::getIdentity($autoRenew);

            // If parent returns null but user is not marked as guest,
            // return fallback identity and force logout on next request
            if ($identity === null && !$this->getIsGuest()) {
                Yii::warning('Identity is null for non-guest user, using fallback and scheduling logout', 'user');

                // Set a flash variable to trigger logout on next request
                Yii::$app->session->set('force_logout', true);

                return $this->_fallbackIdentity;
            }

            return $identity;
        } finally {
            // Always reset the recursion flag
            $this->_inGetIdentity = false;
        }
    }

    /**
     * Override getIsGuest to make sure we don't create an infinite loop
     */
    public function getIsGuest()
    {
        // Avoid calling getIdentity() which would create a loop
        return parent::getIsGuest();
    }

    /**
     * Checks for and processes forced logout if needed
     * This should be called early in request processing
     */
    public function checkForForcedLogout()
    {
        if (Yii::$app->session->get('force_logout', false)) {
            Yii::debug('Processing forced logout due to previous null identity', 'user');

            // Force logout without accessing identity again
            $this->_identity = null;
            if ($this->enableSession) {
                Yii::$app->session->remove($this->idParam);
            }

            // Clear the logout flag
            Yii::$app->session->remove('force_logout');
            Yii::$app->session->setFlash('error', 'Your session has expired. Please login again.');

            // Redirect to login page if this is not already a login page
            $currentRoute = Yii::$app->requestedRoute ?: Yii::$app->defaultRoute;
            $loginRoute = is_array($this->loginUrl) ? $this->loginUrl[0] : $this->loginUrl;
            $loginRoute = ltrim($loginRoute, '/');

            if (strpos($currentRoute, $loginRoute) === false) {
                Yii::$app->response->redirect($this->loginUrl)->send();
                Yii::$app->end();
            }
        }
    }
}

<?php

namespace app\components\behaviors;
use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use yii\base\Event;
use yii\web\Application;

class AuthRedirectBehavior extends Behavior
{
    /**
     * @var string the controller ID for redirection
     */
    public $redirectController = 'landing';

    /**
     * @var string the action ID for redirection
     */
    public $redirectAction = 'login';

    /**
     * @var array actions that should be excluded from redirection
     */
    public $excludeActions = [];

    /**
     * @var array controllers that should be excluded from redirection
     */
    public $excludeControllers = [];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    /**
     * Handles the before action event
     *
     * @param Event $event the event instance
     * @return bool whether the action should continue
     */
    public function beforeAction($event)
    {
        /* @var $controller Controller */
        $controller = $event->sender;
        $action = $event->action->id;

        if (in_array($controller->id, $this->excludeControllers) ||
            in_array($action, $this->excludeActions)) {
            return true;
        }

        if ($controller->id === $this->redirectController && $action === $this->redirectAction) {
            return true;
        }

        if (!Yii::$app->user->identity) {
            // Redirect to landing/login
            yii::$app->user->loginRequired();
            Yii::$app->controller->redirect([$this->redirectController . '/' . $this->redirectAction]);
            return false; // Stop further action processing
        }

        return true;
    }
}

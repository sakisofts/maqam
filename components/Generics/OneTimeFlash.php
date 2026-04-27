<?php

namespace app\components\Generics;
use Yii;
use yii\base\Component;

class OneTimeFlash extends Component
{
    /**
     * Supported alert types
     * info
     * success
     * error
     * warning
     */

    /**
     * Unique key prefix for flash messages
     */
    private const FLASH_PREFIX = 'oneTime_';

    /**
     * Sets a one-time flash message
     */
    public static function set($key, $value)
    {
        $uniqueKey = self::FLASH_PREFIX . $key;
        Yii::$app->session->setFlash($uniqueKey, $value);
    }

    /**
     * Gets and immediately removes a one-time flash message
     */
    public static function get($key, $defaultValue = null)
    {
        $uniqueKey = self::FLASH_PREFIX . $key;
        if (!Yii::$app->session->hasFlash($uniqueKey)) {
            return $defaultValue;
        }

        $value = Yii::$app->session->getFlash($uniqueKey, $defaultValue);
        Yii::$app->session->removeFlash($uniqueKey);

        return $value;
    }

    /**
     * Checks if a one-time flash message exists
     *  Unique identifier for the flash message
     *  Whether the flash exists
     */
    public static function has($key): bool
    {
        return Yii::$app->session->hasFlash(self::FLASH_PREFIX . $key);
    }

    /**
     * Removes a one-time flash message if it exists
     * @param string $key Unique identifier for the flash message
     * @return void
     */
    public static function remove($key)
    {
        $uniqueKey = self::FLASH_PREFIX . $key;
        if (self::has($key)) {
            Yii::$app->session->removeFlash($uniqueKey);
        }
    }
}

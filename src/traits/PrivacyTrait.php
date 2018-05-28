<?php

namespace luya\privacy\traits;

use Yii;
use yii\web\Cookie;

/**
 * Trait PrivacyTrait
 *
 * The privacy trait helps getting and setting the privacy policy state.
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.0
 */
trait PrivacyTrait
{
    public static $PRIVACY_COOKIE_NAME = '_privacyPolicy';

    /**
     * @return bool|null The privacy value
     */
    public function getPrivacyCookieValue()
    {
        return Yii::$app->response->cookies->getValue(self::$PRIVACY_COOKIE_NAME, null) !== null ?
            Yii::$app->response->cookies->getValue(self::$PRIVACY_COOKIE_NAME) :
            Yii::$app->request->cookies->getValue(self::$PRIVACY_COOKIE_NAME, null);
    }

    /**
     * Sets the privacy
     */
    public function setPrivacyCookieValue($value = null)
    {
        Yii::$app->response->cookies->add(new Cookie(['name' => self::$PRIVACY_COOKIE_NAME, 'value' => $value]));
    }

    /**
     * @return bool Checks whether the privacy is accepted or not
     */
    public function isPrivacyAccepted()
    {
        return !empty($this->getPrivacyCookieValue()) ? true : false;
    }

    /**
     * @return bool Checks whether the privacy is declined or not
     */
    public function isPrivacyDeclined()
    {
        return ($this->getPrivacyCookieValue() === false) ? true : false;
    }
}

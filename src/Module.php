<?php

namespace luya\privacy;

use Yii;

/**
 * Privacy Module
 *
 * When adding this module to your configuration the privacy block will be added to your
 * cmsadministration by running the `import` command.
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 */
class Module extends \luya\base\Module
{
    /**
     * @inheritdoc
     */
    public static function onLoad()
    {
        Yii::setAlias('@privacy', static::staticBasePath());

        self::registerTranslation('privacy*', static::staticBasePath() . '/messages', [
            'privacy' => 'privacy.php',
        ]);
    }

    /**
     * Translations
     *
     * @param string $message
     * @param array $params
     * @return string
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('privacy', $message, $params);
    }
}

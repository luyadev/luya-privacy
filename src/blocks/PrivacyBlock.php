<?php
namespace luya\privacy\blocks;

use luya\privacy\BasePrivacyBlock;
use luya\cms\frontend\blockgroups\DevelopmentGroup;
use luya\privacy\Module;

/**
 * Privacy Block
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.0
 */
class PrivacyBlock extends BasePrivacyBlock
{
    public $module = 'privacy';

    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_privacy.block_name');
    }

    /**
     * @inheritdoc
     */
    public function blockGroup()
    {
        return DevelopmentGroup::class;
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'fingerprint';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'privacyMessage', 'type' => self::TYPE_TEXT, 'label' => Module::t('block_privacy.privacy_message')],
                ['var' => 'messageLink', 'type' => self::TYPE_LINK, 'label' => Module::t('block_privacy.privacy_link')],
                ['var' => 'acceptPrivacyButtonText', 'type' => self::TYPE_TEXT, 'label' => Module::t('block_privacy.accept_privacy_button_text')],
                ['var' => 'declinePrivacyButtonText', 'type' => self::TYPE_TEXT, 'label' => Module::t('block_privacy.decline_privacy_button_text')],
            ],
            'cfgs' => [
                ['var' => 'acceptPrivacyButtonClass', 'type' => self::TYPE_TEXT, 'label' => Module::t('block_privacy.accept_privacy_button_class'),  'initvalue' => 'btn btn-primary'],
                ['var' => 'declinePrivacyButtonClass', 'type' => self::TYPE_TEXT, 'label' => Module::t('block_privacy.decline_privacy_button_class'),  'initvalue' => 'btn'],
                ['var' => 'declineButton', 'type' => self::TYPE_CHECKBOX, 'label' => Module::t('block_privacy.decline_privacy_button_text'), 'initvalue' => 1],
                ['var' => 'forceOutput', 'type' => self::TYPE_CHECKBOX, 'label' => Module::t('block_privacy.force_output'), 'initvalue' => 1],
                ['var' => 'css', 'type' => self::TYPE_TEXTAREA, 'label' => Module::t('block_privacy.custom_css'), 'initvalue' => ''],
            ]
        ];
    }

    /**
     * @return array Widget configuration
     */
    public function getWidgetConfig()
    {
        $vars = $this->getVarValues();
        $cfgs = $this->getCfgValues();
        $cfgs['declineButton'] = $cfgs['declineButton'] == 1 ? true : false;
        $cfgs['forceOutput'] = $cfgs['forceOutput'] == 1 ? true : false;
        return array_merge($vars, $cfgs);
    }

    /**
     * {@inheritdoc}
     */
    public function extraVars()
    {
        return [
            'widgetConfig' => $this->getWidgetConfig()
        ];
    }

    /**
     * @inheritdoc
     * @todo Needs adjustment to display correct
     */
    public function admin()
    {
        return '<div>Privacy Bar</div>';
    }
}

<?php
namespace luya\privacy;

use Yii;
use yii\web\Cookie;
use luya\base\Widget;
use luya\cms\helpers\Url;
use luya\helpers\Json;
use luya\privacy\Module;
use luya\privacy\assets\PrivacyWidgetAsset;
use luya\privacy\traits\PrivacyTrait;

/**
 * Privacy Widget
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.0
 */
class BasePrivacyWidget extends Widget
{
    use PrivacyTrait;

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return '@privacy/views/widgets';
    }
}
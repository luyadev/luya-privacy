<?php
/* @var $css string */
/* @var $messageDiv string */
/* @var $acceptButton string */
/* @var $declineButton string */
/* @var $this \luya\web\View */

use luya\helpers\Html;

// register css styles if available
if ($css) {
    $this->registerCss($css);
}
?>
<div class="luya-privacy-widget-container<?= (!empty($containerCssClass)) ? ' '.$containerCssClass : '' ?>">
    <?= $messageDiv; ?>
    <?= Html::beginForm(); ?>
    <?= $acceptButton; ?>
    <?= $declineButton; ?>
    <?= Html::endForm(); ?>
</div>
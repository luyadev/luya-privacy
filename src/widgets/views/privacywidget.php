<?php
/* @var $css string */
/* @var $messageDiv string */
/* @var $acceptButton string */
/* @var $declineButton string */
/* @var $this \luya\web\View */

// register css styles if available
if ($css) {
    $this->registerCss($css);
}
?>
<div class="luya-privacy-widget-container<?= ($containerCssClass) ? ' '.$containerCssClass : '' ?>">
    <?= $messageDiv; ?>
    <?= $acceptButton; ?>
    <?= $declineButton; ?>
</div>
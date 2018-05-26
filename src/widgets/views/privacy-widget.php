<form  id="_privacyPolicy" class="privacyPolicyConsent" action="" method="post">
    <div class="message">
        <?= $privacyMessage ?>
    </div>
    <div class="buttons">
        <button name="_privacyPolicy" type="submit" value="true" class="<?= $acceptPrivacyButtonClass ?>">
            <?= $acceptPrivacyButtonText ?>
        </button>
        <?php if ($declineButton): ?>
        <button name="_privacyPolicy" type="submit" value="false" class="<?= $declinePrivacyButtonClass ?>">
            <?= $declinePrivacyButtonText ?>
        </button>
        <?php endif; ?>
    </div>
</form>



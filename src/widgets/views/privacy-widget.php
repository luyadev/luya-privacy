<form  id="_privacyPolicy" class="privacyPolicyConsent" action="" method="post">
    <div class="message">
        <?= $privacyMessage ?>
    </div>
    <div class="buttons">
        <button name="_privacyPolicy" type="submit" value="false">
            Decline
        </button>
        <button name="_privacyPolicy" type="submit" value="true" class="<?= $acceptPrivacyButtonClass ?>">
            <?= $acceptPrivacyButtonText ?>
        </button>
    </div>
</form>



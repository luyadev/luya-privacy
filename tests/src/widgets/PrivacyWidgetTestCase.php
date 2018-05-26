<?php
namespace luya\privacytests\widgets;

use luya\privacy\widgets\PrivacyWidget;
use luya\privacytests\PrivacyTestCase;

class PrivacyWidgetTestCase extends PrivacyTestCase
{
    /*
    public function testWidgetOutput()
    {
        $this->assertSame('<form  id="_privacyPolicy" class="privacyPolicyConsent" action="" method="post">
            <div class="message">We use cookies to improve your experience on our website. Please read and accept our privacy policies.</div>
            <div class="buttons">
                <button name="_privacyPolicy" type="submit" value="true" class="btn btn-primary">Accept</button>
            </div></form>', PrivacyWidget::widget());
    }

    public function testDeclineButton()
    {
        $this->assertSame('<form  id="_privacyPolicy" class="privacyPolicyConsent" action="" method="post">
            <div class="message">We use cookies to improve your experience on our website. Please read and accept our privacy policies.</div>
            <div class="buttons">
                <button name="_privacyPolicy" type="submit" value="true" class="btn btn-primary">Accept</button>
                <button name="_privacyPolicy" type="submit" value="false" class="btn">Decline</button>
            </div></form>', PrivacyWidget::widget(['declineButton' => true]));
    }
    */
}
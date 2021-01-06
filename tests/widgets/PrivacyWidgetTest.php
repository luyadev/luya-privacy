<?php
namespace luya\privacy\tests\widgets;

use luya\helpers\Url;
use Yii;
use luya\privacy\tests\PrivacyTestCase;
use luya\privacy\widgets\PrivacyWidget;

class PrivacyWidgetTest extends PrivacyTestCase
{
    public function testChangedGetParam()
    {
        $w = new PrivacyWidget([
            'acceptParam' => 'foo',
        ]);

        $this->assertSame('/?foo=1', $w->buildAcceptUrl());
    }
    public function testWidgetStandardOutput()
    {
        $this->assertSameTrimmed('<div class="luya-privacy-widget-container"><div>We use cookies to improve your experience on our website. Please read and accept our privacy policies.</div><a class="btn btn-primary" href="/?acceptCookies=1" rel="nofollow">Accept</a></div>', PrivacyWidget::widget(['forceOutput' => true]));
    }

    public function testWidgetOutputWithContainerClass()
    {
        $this->assertSameTrimmed('<div class="luya-privacy-widget-container fixed-bottom"><div>We use cookies to improve your experience on our website. Please read and accept our privacy policies.</div><a class="btn btn-primary" href="/?acceptCookies=1" rel="nofollow">Accept</a></div>', PrivacyWidget::widget(['forceOutput' => true, 'containerCssClass' => 'fixed-bottom']));
    }

    public function testAppendUrl()
    {
        $w = new PrivacyWidget();

        $this->assertSame('/?bar=foo', Url::appendQuery('?bar=foo'));

        Yii::$app->request->url = 'https://luya.io?hello=word';
        $this->assertSame('https://luya.io?hello=word&bar=foo', Url::appendQuery('?bar=foo'));
        $this->assertSame('https://luya.io?hello=word&bar=foo', Url::appendQuery('bar=foo'));
        $this->assertSame('https://luya.io?hello=word&bar=foo', Url::appendQuery('&bar=foo'));
    }

    public function testSpecialAppendCase()
    {
        $w = new PrivacyWidget();
        Yii::$app->request->url = 'https://luya.io?hello=word&';
        $this->assertSame('https://luya.io?hello=word&bar=foo', Url::appendQuery('?bar=foo'));
        $this->assertSame('https://luya.io?hello=word&bar=foo', Url::appendQuery('bar=foo'));
        $this->assertSame('https://luya.io?hello=word&bar=foo', Url::appendQuery('&bar=foo'));

        $w = new PrivacyWidget();
        Yii::$app->request->url = 'https://luya.io';
        $this->assertSame('https://luya.io?bar=foo', Url::appendQuery('?bar=foo'));
        $this->assertSame('https://luya.io?bar=foo', Url::appendQuery('bar=foo'));
        $this->assertSame('https://luya.io?bar=foo', Url::appendQuery('&bar=foo'));
    }

    public function testPrivacyState()
    {
        $w = new PrivacyWidget();
        $this->assertFalse($w->isPrivacyAccepted());
        $this->assertFalse($w->isPrivacyDeclined());
        $this->assertTrue($w->isPrivacyNotDecided());
    }

    public function testWrapper()
    {
        $content = PrivacyWidget::widget([
            'wrapper' => function($content) {
                return '<around>'.$content.'</around>';
            }
        ]);

        $this->assertSameTrimmed('<around><div class="luya-privacy-widget-container">
        <div>We use cookies to improve your experience on our website. Please read and accept our privacy policies.</div>    <a class="btn btn-primary" href="/?acceptCookies=1" rel="nofollow">Accept</a>    </div></around>', $content);
    }
    /*
    public function testDeclineButtonOutput()
    {
        $this->assertSame('<form id="_privacyPolicy" class="privacyPolicyConsent" action="" method="post">
    <div class="message">
        We use cookies to improve your experience on our website. Please read and accept our privacy policies.    </div>
    <div class="buttons">
        <button name="_privacyPolicy" type="submit" value="true" class="btn btn-primary">
            Accept        </button>
                <button name="_privacyPolicy" type="submit" value="false" class="btn">
            Decline        </button>
            </div>
</form>', PrivacyWidget::widget(['declineButton' => true]));
    }
    */
}

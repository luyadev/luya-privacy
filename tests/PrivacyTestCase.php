<?php
namespace luya\privacy\tests;

use luya\testsuite\cases\WebApplicationTestCase;

class PrivacyTestCase extends WebApplicationTestCase
{
    public function getConfigArray()
    {
        return [
            'id' => 'privacyblock',
            'basePath' => __DIR__,
            'language' => 'en',
        ];
    }
}

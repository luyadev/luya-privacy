<?php
namespace luya\privacy;

use luya\cms\base\PhpBlock;

/**
 * Base Privacy Block
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.0
 */
abstract class BasePrivacyBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return dirname(__DIR__) . '/src/views/blocks';
    }
}
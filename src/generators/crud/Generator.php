<?php

namespace hd\gii\generators\crud;

/**
 * Human Device CRUD generator.
 *
 * @author Daniel Filipek <df@human-device.com>
 * @author Paweł Brzozowski <pb@human-device.com>
 * @copyright (c) 2016, Human Device sp. z o.o.
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    public $baseControllerClass = 'common\components\web\ModelController';
    public $searchModelClass = '';
    
    /**
     * Whether to wrap the `GridView` or `ListView` widget with the 
     * `yii\widgets\Pjax` widget
     * @var boolean 
     */
    public $enablePjax = true;
}

<?php

namespace hd\gii;

/**
 * Human Device Yii 2 Gii extended with modified generators.
 *
 * @author Daniel Filipek <df@human-device.com>
 * @author Paweł Brzozowski <pb@human-device.com>
 * @copyright (c) 2016, Human Device sp. z o.o.
 */
class Module extends \yii\gii\Module
{
    /**
     * Returns the list of the core code generator configurations.
     * @return array the list of the core code generator configurations.
     */
    protected function coreGenerators()
    {
        return [
            'model'      => ['class' => 'hd\gii\generators\model\Generator'],
            'crud'       => ['class' => 'hd\gii\generators\crud\Generator'],
            'controller' => ['class' => 'hd\gii\generators\controller\Generator'],
            'form'       => ['class' => 'hd\gii\generators\form\Generator'],
            'module'     => ['class' => 'hd\gii\generators\module\Generator'],
            'extension'  => ['class' => 'hd\gii\generators\extension\Generator'],
        ];
    }
}

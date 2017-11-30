<?php

/* @var $generator hd\gii\generators\crud\Generator */

use yii\helpers\StringHelper;

?>
<?= "<?php\n"; ?>

namespace <?= StringHelper::dirname(ltrim($generator->formModelClass, '\\')) ?>;

use <?= $generator->modelClass ?>;

class <?= StringHelper::basename($generator->formModelClass) ?> extends <?= StringHelper::basename($generator->modelClass) . "\n" ?>
{

    public function saveForm()
    {
        return $this->save();
    }
}


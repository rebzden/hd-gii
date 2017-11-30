<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */
?>

<div class="row">
    <div class="col-md-8">
        <?= $form->field($generator, 'modelClass'); ?>
        <?= $form->field($generator, 'searchModelClass'); ?>
        <?= $form->field($generator, 'repositoryClass'); ?>
        <?= $form->field($generator, 'formModelClass'); ?>
        <?= $form->field($generator, 'controllerClass'); ?>
        <?= $form->field($generator, 'viewPath'); ?>
        <?= $form->field($generator, 'indexWidgetType')->dropDownList([
            'grid' => 'GridView',
            'list' => 'ListView',
        ]); ?>
        <?= $form->field($generator, 'enableI18N')->checkbox(); ?>
        <?= $form->field($generator, 'enablePjax')->checkbox(); ?>
        <?= $form->field($generator, 'messageCategory'); ?>
    </div>
    <div class="col-md-4">
        <h5>Index</h5>
        <?= $form->field($generator, 'generateIndex')->checkbox(); ?>
        <?= $form->field($generator, 'ajaxIndex')->checkbox(); ?>
        <hr>
        <h5>Create</h5>
        <?= $form->field($generator, 'generateCreate')->checkbox(); ?>
        <?= $form->field($generator, 'ajaxCreate')->checkbox(); ?>
        <hr>
        <h5>Update</h5>
        <?= $form->field($generator, 'generateUpdate')->checkbox(); ?>
        <?= $form->field($generator, 'ajaxUpdate')->checkbox(); ?>
        <hr>
        <h5>View</h5>
        <?= $form->field($generator, 'generateView')->checkbox(); ?>
        <?= $form->field($generator, 'ajaxView')->checkbox(); ?>
        <hr>
        <h5>Delete</h5>
        <?= $form->field($generator, 'generateDelete')->checkbox(); ?>
        <?= $form->field($generator, 'ajaxDelete')->checkbox(); ?>
    </div>
</div>

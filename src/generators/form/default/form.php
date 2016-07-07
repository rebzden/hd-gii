<?php
/**
 * This is the template for generating an action view file.
 */

/* @var $this yii\web\View */
/* @var $generator hd\gii\generators\form\Generator */

echo "<?php\n";
?>

use common\components\helpers\Html;
use common\components\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this View */
/* @var $model <?= $generator->modelClass ?> */
/* @var $form ActiveForm */
<?= "?>" ?>
<div class="<?= str_replace('/', '-', trim($generator->viewName, '_')) ?>">
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
        <?php foreach ($generator->getModelAttributes() as $attribute): ?>
        <?= "<?= " ?>$form->field($model, '<?= $attribute ?>') ?>
        <?php endforeach; ?>
        <div class="form-group">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Submit') ?>, ['class' => 'btn btn-primary']) ?>
        </div>
    <?= "<?php " ?>ActiveForm::end(); ?>
</div>

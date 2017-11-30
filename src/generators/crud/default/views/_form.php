<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use common\components\helpers\Html;
use common\components\widgets\ActiveForm;


<?="/* @var \$model $generator->modelClass */\n"?>
<?="?>"?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Inflector::camel2words(StringHelper::basename($generator->modelClass)); ?></h3>
                </div>
                <?= "<?php " ?>$form = ActiveForm::begin(); ?>
                    <div class="box-body">

                    <?php foreach ($generator->getColumnNames() as $attribute) {
                        if (in_array($attribute, $safeAttributes)) {
                            echo "<?= " . $generator->generateActiveField($attribute) . " ?>\n";
                        }
                    } ?>
                    </div>
                    <div class="box-footer">
                        <?= "<?= " ?>Html::submitButton(Yii::t('app', 'form.save'), ['class' => 'pull-right']) ?>
                    </div>
                <?= "<?php " ?>ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
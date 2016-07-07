<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator hd\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use common\components\helpers\Html;
use common\components\widgets\DetailView;
use yii\web\View;

/* @var $this View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
                    <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
                        'class' => 'btn btn-danger',
                        'data'  => [
                            'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                            'method'  => 'post',
                        ],
                    ]) ?>
                </div>
                <div class="box-body">
                    <?= "<?= " ?>DetailView::widget([
                        'model'      => $model,
                        'attributes' => [
                        <?php
                        if (($tableSchema = $generator->getTableSchema()) === false) {
                            foreach ($generator->getColumnNames() as $name) {
                                echo "            '" . $name . "',\n";
                            }
                        } else {
                            foreach ($generator->getTableSchema()->columns as $column) {
                                $format = $generator->generateColumnFormat($column);
                                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            }
                        }
                        ?>
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

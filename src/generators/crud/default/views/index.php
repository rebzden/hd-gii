<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator hd\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use common\components\data\ActiveDataProvider;
use common\components\helpers\Html;
use common\components\grid\SerialColumn;
use common\components\grid\ActionColumn;

use <?= $generator->indexWidgetType === 'grid' ? 'common\components\grid\GridView' : 'common\components\widgets\ListView' ?>;
<?= $generator->enablePjax ? 'use common\components\widgets\Pjax;' : '' ?>
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title =  <?= "Yii::t('app','".strtolower(StringHelper::basename($generator->modelClass)).".index_title')" ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <p>
        <?= "<?= " ?>Html::a('<span class="fa fa-plus-circle"></span> ' . <?= "Yii::t('app','".strtolower(StringHelper::basename($generator->modelClass)).".create_button')" ?>, ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= $generator->enablePjax ? '<?php Pjax::begin() ?>' : '' ?>
    <?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => SerialColumn::class],
    <?php
    $count = 0;
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            if (++$count < 6) {
                echo "            '" . $name . "',\n";
            } else {
                echo "            // '" . $name . "',\n";
            }
        }
    } else {
        foreach ($tableSchema->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            if (++$count < 6) {
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            } else {
                echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        }
    }
    ?>
            ['class' => ActionColumn::class],
        ],
    ]); ?>
    <?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions'  => ['class' => 'item'],
        'itemView'     => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
    <?php endif; ?>
    <?= $generator->enablePjax ? '<?php Pjax::end() ?>' : '' ?>
</div>

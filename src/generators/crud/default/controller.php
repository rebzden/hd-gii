<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator hd\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use common\components\helpers\Html;
use common\components\helpers\Url;
use SamIT\Yii2\Traits\ActionInjectionTrait;
use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
    use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
    use yii\data\ActiveDataProvider;
<?php endif; ?>
<?php if (!empty($generator->formModelClass)): ?>
    use <?= ltrim($generator->formModelClass, '\\') ?>;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\filters\VerbFilter;

/**
* <?= $controllerClass ?>.
*
*/
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{

use ActionInjectionTrait;
<?php if($generator->generateDelete):?>
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
<?php endif;?>

<?php if($generator->generateIndex):?>
    /**
    * All <?= $modelClass ?> models.<?= empty($generator->searchModelClass) ? "\n".$generator->repositoryDocumentation():""?>
    * @return mixed
    */
    public function actionIndex(<?= empty($generator->searchModelClass) ? $generator->repositoryParam() : ""?>)
    {
    Url::remember();
    <?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this-><?= $generator->renderFunction($generator->ajaxCreate) ?>('index', [
        'searchModel'  => $searchModel,
        'dataProvider' => $dataProvider,
        ]);
    <?php else: ?>
        $dataProvider = new ActiveDataProvider([
        'query' => <?=$generator->findModel()?>,
        ]);
        return $this-><?= $generator->renderFunction($generator->ajaxCreate) ?>('index', [
        'dataProvider' => $dataProvider,
        ]);
    <?php endif; ?>
    }
<?php endif;?>
<?php if($generator->generateView):?>
    /**
    * Displaying <?= $modelClass ?> model.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?><?=$generator->repositoryDocumentation()?>
    * @return mixed
    */
    public function actionView(<?= $actionParams ?><?=$generator->repositoryParam()?>)
    {
    return $this-><?= $generator->renderFunction($generator->ajaxView) ?>('view', [
    'model' => <?=$generator->findModel($actionParams)?>,
    ]);
    }
<?php endif;?>

<?php if($generator->generateCreate):?>
    /**
    * Creating a new <?= $modelClass ?> model.
    * @return mixed
    */
    public function actionCreate()
    {
    $model = new <?= $generator->formClass() ?>;

    if ($model->load($this->post())) {
    if($model-><?= $generator->saveMethod() ?>){
    <?php if($generator->ajaxCreate):?>
        return $this->ajaxSuccess(Yii::t('flash','<?= strtolower($modelClass) ?>.create_successful'));
    <?php else:?>
        $this->success(Yii::t('flash', '<?= strtolower($modelClass) ?>.create_successful'));
        return $this->goBack();
    <?php endif;?>
    } else {
    <?php if($generator->ajaxCreate):?>
        return $this->ajaxError(Yii::t('flash','<?= strtolower($modelClass) ?>.create_error'));
    <?php else:?>
        $this->error(Yii::t('flash', '<?= strtolower($modelClass) ?>.create_error'));
        return $this->refresh();
    <?php endif;?>
    }
    }

    return $this-><?= $generator->renderFunction($generator->ajaxCreate) ?>('create', ['model' => $model]);
    }
<?php endif;?>

<?php if($generator->generateUpdate):?>
    /**
    * Updating an existing <?= $modelClass ?> model.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
    * @return mixed
    */
    public function actionUpdate(<?= $actionParams ?>)
    {
    $model = <?= $generator->formClass() ?>::findOneModel(<?= $actionParams ?>);

    if ($model->load($this->post())) {
    if($model-><?= $generator->saveMethod() ?>){
    <?php if($generator->ajaxUpdate):?>
        return $this->ajaxSuccess(Yii::t('flash','<?= strtolower($modelClass) ?>.update_successful'));
    <?php else:?>
        $this->success(Yii::t('flash', '<?= strtolower($modelClass) ?>.update_successful'));
        return $this->goBack();
    <?php endif;?>
    } else {
    <?php if($generator->ajaxUpdate):?>
        return $this->ajaxError(Yii::t('flash','<?= strtolower($modelClass) ?>.update_error'));
    <?php else:?>
        $this->error(Yii::t('flash', '<?= strtolower($modelClass) ?>.update_error'));
        return $this->refresh();
    <?php endif;?>
    }
    }


    return $this-><?= $generator->renderFunction($generator->ajaxUpdate) ?>('update', ['model' => $model]);
    }
<?php endif;?>

<?php if($generator->generateDelete):?>

    /**
    * Deleting an existing <?= $modelClass ?> model.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?><?=$generator->repositoryDocumentation()?>
    * @return mixed
    */
    public function actionDelete(<?= $actionParams ?><?=$generator->repositoryParam()?>)
    {
    $model = <?=$generator->findModel($actionParams)?>;
    if ($model->remove()) {
    <?php if($generator->ajaxDelete):?>
        return $this->ajaxSuccess(Yii::t('flash','<?= strtolower($modelClass) ?>.delete_successful'));
    <?php else:?>
        $this->success(Yii::t('flash', '<?= strtolower($modelClass) ?>.delete_successful'));
        return $this->goBack();
    <?php endif;?>
    } else {
    <?php if($generator->ajaxDelete):?>
        return $this->ajaxSuccess(Yii::t('flash','<?= strtolower($modelClass) ?>.delete_successful'));
    <?php else:?>
        $this->success(Yii::t('flash', '<?= strtolower($modelClass) ?>.delete_successful'));
        return $this->goBack();
    <?php endif;?>
    }
    }
<?php endif;?>

}

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
use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\filters\VerbFilter;

/**
 * <?= $controllerClass ?>.
 * 
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->notFoundMessage = Yii::t('app', '<?= $modelClass ?> you are looking for can not be found.');
    }
    
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

    /**
     * All <?= $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * Displaying <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', [
            'model' => <?= $modelClass ?>::findOneModel(<?= $actionParams ?>),
        ]);
    }

    /**
     * Creating a new <?= $modelClass ?> model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->ok(Yii::t('app', '<?= $modelClass ?> has been added.'));
            return $this->goBack();
        }
        
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updating an existing <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = <?= $modelClass ?>::findOneModel(<?= $actionParams ?>);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->ok(Yii::t('app', '<?= $modelClass ?> has been updated.'));
            return $this->refresh();
        }
        
        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deleting an existing <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        if (<?= $modelClass ?>::findOneModel(<?= $actionParams ?>)->delete()) {
            $this->ok(Yii::t('app', '<?= $modelClass ?> has been deleted.'));
        } else {
            $this->err(Yii::t('app', 'Error while deleting <?= $modelClass ?>!'));
        }
        return $this->goBack();
    }
}

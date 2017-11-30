<?php

namespace hd\gii\generators\crud;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\StringHelper;

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
    public $repositoryClass = '';

    /**
     * Whether to wrap the `GridView` or `ListView` widget with the
     * `yii\widgets\Pjax` widget
     * @var boolean
     */
    public $enablePjax = true;

    public $formModelClass = '';
    /**
     * Actions
     */
    public $generateIndex = true;
    public $ajaxIndex = false;
    public $generateCreate = true;
    public $ajaxCreate = true;
    public $generateUpdate = true;
    public $ajaxUpdate = true;
    public $generateView = true;
    public $ajaxView = true;
    public $generateDelete = true;
    public $ajaxDelete = true;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['repositoryClass'], 'validateNewClass'],
            [['formModelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [
                [
                    'generateIndex',
                    'ajaxIndex',
                    'generateCreate',
                    'ajaxCreate',
                    'generateUpdate',
                    'ajaxUpdate',
                    'generateView',
                    'ajaxView',
                    'generateDelete',
                    'ajaxDelete'
                ],
                'boolean'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $controllerFile = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->controllerClass, '\\')) . '.php');

        $files = [
            new CodeFile($controllerFile, $this->render('controller.php')),
        ];
        if (!empty($this->formModelClass)) {
            $formModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->formModelClass, '\\') . '.php'));
            $files[] = new CodeFile($formModel, $this->render('form.php'));
        }
        if (!empty($this->searchModelClass)) {
            $searchModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->searchModelClass, '\\') . '.php'));
            $files[] = new CodeFile($searchModel, $this->render('search.php'));
        }

        $viewPath = $this->getViewPath();
        $templatePath = $this->getTemplatePath() . '/views';
        foreach (scandir($templatePath) as $file) {
            if (empty($this->searchModelClass) && $file === '_search.php') {
                continue;
            }
            if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("views/$file"));
            }
        }

        return $files;
    }

    public function renderFunction($renderAjax)
    {
        return $renderAjax ? 'renderAjax' : 'render';
    }

    public function saveMethod()
    {
        return $this->formModelClass ? 'saveForm()' : 'save()';
    }

    public function formClass()
    {
        return $this->formModelClass ? StringHelper::basename($this->formModelClass) : StringHelper::basename($this->modelClass);
    }

    public function repoistoryVariable()
    {
        $repositoryClass = StringHelper::basename($this->repositoryClass);
        return "$" . lcfirst($repositoryClass);
    }

    public function repositoryParam($showComma = true)
    {
        $comma = $showComma ? ", " : "";
        $repositoryClass = StringHelper::basename($this->repositoryClass);
        return $this->repositoryClass ? $comma . $repositoryClass . " " . $this->repoistoryVariable() : "";
    }

    public function repositoryDocumentation()
    {
        return $this->repositoryClass ? "     * @param " . $this->repositoryParam(false) . "\n" : '';

    }

    public function findModel($params = null)
    {
        $modelClass = StringHelper::basename($this->modelClass);
        if ($params) {
            return $this->repositoryClass ? $this->repoistoryVariable() . "->findById($params)" : $modelClass . "::findOneModel($params)";
        } else {
            return $this->repositoryClass ? $this->repoistoryVariable() . "->basicFind()" : $modelClass . "::find()";
        }

    }
}

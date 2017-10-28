<?php

namespace hd\gii\generators\model;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\Inflector;

/**
 * Yii2 model generator.
 */
class Generator extends \yii\gii\generators\model\Generator
{
    public $ns = 'common\models';
    public $baseClass = 'common\components\db\ActiveRecord';
    public $useTablePrefix = true;
    public $useSchemaName = true;
    public $generateRepository = true;
    public $generateService = true;
    public $queryBaseClass = 'common\components\db\ActiveQuery';
    public $queryNs = 'common\models';
    public $serviceNs = 'common\services';
    public $repositoryNs = 'common\models';
    public $enableI18N = true;

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $relations = $this->generateRelations();
        $db = $this->getDbConnection();
        foreach ($this->getTableNames() as $tableName) {
            // base model :
            $modelClassName = $this->generateClassName($tableName);
            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($modelClassName) : false;
            $repositoryClassName = ($this->generateRepository) ? $this->generateRepositoryClassName($modelClassName) : false;
            $serviceClassName = ($this->generateService) ? $this->generateServiceClassName($modelClassName) : false;
            $tableSchema = $db->getTableSchema($tableName);
            $params = [
                'tableName'      => $tableName,
                'className'      => $modelClassName,
                'queryClassName' => $queryClassName,
                'tableSchema'    => $tableSchema,
                'labels'         => $this->generateLabels($tableSchema),
                'rules'          => $this->generateRules($tableSchema),
                'relations'      => isset($relations[$tableName]) ? $relations[$tableName] : [],
            ];
            $classNamespace = $this->ns . '\\' . strtolower(Inflector::camelize($modelClassName));
            $repositoryNamespace = $this->repositoryNs;
            if ($this->repositoryNs == $this->ns) {
                $repositoryNamespace = $classNamespace;
            }
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $classNamespace)) . '/Base' . $modelClassName . '.php',
                $this->render('base-model.php', $params)
            );

            // extended model :
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $classNamespace)) . '/' . $modelClassName . '.php',
                $this->render('model.php', $params)
            );

            // query :
            if ($queryClassName) {
                $params['className'] = $queryClassName;
                $params['modelClassName'] = $modelClassName;
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $classNamespace)) . '/' . $queryClassName . '.php',
                    $this->render('query.php', $params)
                );
            }
            // repository :
            if ($repositoryClassName) {
                $params['className'] = $repositoryClassName;
                $params['modelClassName'] = $modelClassName;
                $params['queryClassName'] = $queryClassName;
                $params['repositoryNamespace'] = $repositoryNamespace;
                $params['repositoryClassName'] = $repositoryClassName;
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $repositoryNamespace)) . '/' . $repositoryClassName . '.php',
                    $this->render('repository.php', $params)
                );
            }
            // serive :
            if ($serviceClassName) {
                $params['className'] = $serviceClassName;
                $params['modelClassName'] = $modelClassName;
                $params['serviceClassName'] = $serviceClassName;
                $params['repositoryClassName'] = $repositoryClassName;
                $params['repositoryNamespace'] = $repositoryNamespace;
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->serviceNs)) . '/' . $serviceClassName . '.php',
                    $this->render('service.php', $params)
                );
            }
        }

        return $files;
    }

    /**
     * Generates a repository class name from the specified model class name.
     * @param string $modelClassName model class name
     * @return string generated class name
     */
    protected function generateRepositoryClassName($modelClassName)
    {
        $queryClassName = $this->queryClass;
        if (empty($queryClassName) || strpos($this->tableName, '*') !== false) {
            $queryClassName = $modelClassName . 'Query';
        }
        return $queryClassName;
    }

    /**
     * Generates a service class name from the specified model class name.
     * @param string $modelClassName model class name
     * @return string generated class name
     */
    protected function generateServiceClassName($modelClassName)
    {
        $queryClassName = $this->queryClass;
        if (empty($queryClassName) || strpos($this->tableName, '*') !== false) {
            $queryClassName = $modelClassName . 'Query';
        }
        return $queryClassName;
    }

}

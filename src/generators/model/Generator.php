<?php

namespace hd\gii\generators\model;

use Yii;
use yii\gii\CodeFile;

/**
 * Human Device model generator.
 *
 * @author Daniel Filipek <df@human-device.com>
 * @author Paweł Brzozowski <pb@human-device.com>
 * @copyright (c) 2016, Human Device sp. z o.o.
 */
class Generator extends \yii\gii\generators\model\Generator
{
    public $ns = 'common\models';
    public $baseClass = 'common\components\db\ActiveRecord';
    public $useTablePrefix = true;
    public $useSchemaName = true;
    public $queryBaseClass = 'common\components\db\ActiveQuery';
    public $queryNs = 'common\models';
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
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/Base' . $modelClassName . '.php',
                $this->render('base-model.php', $params)
            );
            
            // extended model :
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $modelClassName . '.php',
                $this->render('model.php', $params)
            );

            // query :
            if ($queryClassName) {
                $params['className'] = $queryClassName;
                $params['modelClassName'] = $modelClassName;
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->queryNs)) . '/' . $queryClassName . '.php',
                    $this->render('query.php', $params)
                );
            }
        }

        return $files;
    }
}

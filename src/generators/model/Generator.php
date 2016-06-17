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
    public $ns = 'common\models\base';
    public $nsModel = 'common\models';
    public $baseClass = 'common\ext\db\ActiveRecord';
    public $useTablePrefix = true;
    public $useSchemaName = true;
    public $queryBaseClass = 'common\ext\db\ActiveQuery';
    public $enableI18N = true;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['nsModel'], 'filter', 'filter' => 'trim'],
            [['nsModel'], 'filter', 'filter' => function($value) { return trim($value, '\\'); }],
            [['nsModel'], 'match', 'pattern' => '/^[\w\\\\]+$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['nsModel'], 'validateNamespace'],
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'nsModel'  => 'Extended Model Namespace',
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'ns'      => 'This is the namespace of the ActiveRecord base class to be generated, e.g., <code>app\models\base</code>',
            'nsModel' => 'This is the namespace of the ActiveRecord extended class to be generated, e.g., <code>app\models</code>',
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['nsModel']);
    }
    
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
                'tableName' => $tableName,
                'className' => $modelClassName,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'labels' => $this->generateLabels($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => isset($relations[$tableName]) ? $relations[$tableName] : [],
            ];
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . ($this->nsModel ? 'Base' : '') . $modelClassName . '.php',
                $this->render('model.php', $params)
            );
            
            // extended model :
            if ($this->nsModel) {
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->nsModel)) . '/' . $modelClassName . '.php',
                    $this->render('extended-model.php', $params)
                );
            }

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

<?php
/**
 * This is the template for generating the base model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator rebzden\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $repositoryNamespace string repository namespace */
/* @var $repositoryClassName string repository class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use <?= $repositoryNamespace ?>;
use Yii;

/**
 * Service for class "<?= $className ?>".
 */
class <?= $className ?>Service extends Object
{
    /**
    * @return <?= $repositoryClassName ?>|object
    */
    public function getRepository()
    {
        return Yii::$container->get(<?= $repositoryClassName ?>::class);
    }

}

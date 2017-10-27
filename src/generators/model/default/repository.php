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
/* @var $repositoryClassName string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $repositoryNamespace ?>;

use Yii;
use common\components\Repository;

/**
 * Repository for model "<?= $className ?>".
 *
 */
class <?= $repositoryClassName ?> extends Repository
{

    /**
    * @return <?= $queryClassName ?>
    */
    public function basicFind()
    {
        return <?=$className?>::find();
    }
}

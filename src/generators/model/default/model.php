<?php
/**
 * This is the template for generating the extended model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator hd\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?> ?>;

/**
 * <?= $className ?> model.
 * @copyright (c) <?= date('Y') ?>, Human Device sp. z o.o.
 *
 */
class <?= $className ?> extends Base<?= $className . "\n" ?>
{

}

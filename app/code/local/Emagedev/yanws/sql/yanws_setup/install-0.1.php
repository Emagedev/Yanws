<?php
/**
 * Created by PhpStorm.
 * User: dantaeusb
 * Date: 08.05.15
 * Time: 0:47
 */

$installer = $this;
$tableNews = $installer->getTable('yanws/news');

//die($tableNews);

$installer->startSetup();

$installer->getConnection()->dropTable($tableNews);
$table = $installer->getConnection()
    ->newTable($tableNews)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned' => true,
        'nullable'  => false,
        'primary'   => true
    ))
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, '128', array(
        'nullable'  => false,
        'default' => ''
    ))
    ->addColumn('article', 'text', null, array(
        'nullable'  => false,
        'default' => ''
    ))
    ->addColumn('shorten_article', 'text', null, array(
        'nullable'  => false,
        'default' => ''
    ))
    ->addColumn('is_shorten', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable'  => false,
        'default' => 0
    ))
    ->addColumn('url', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array(
        'nullable'  => false
    ))
    ->addColumn('is_published', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable'  => false,
        'default' => 1
    ))
    ->addColumn('timestamp_created', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        'default' => ''
    ));

$installer->getConnection()->createTable($table);

$installer->getConnection()->addIndex(
    $tableNews,
    $installer->getIdxName($tableNews, array('url'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
    array('url'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE);

$installer->endSetup();

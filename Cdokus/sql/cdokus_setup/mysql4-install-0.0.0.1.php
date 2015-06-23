<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Zanbytes
 * @package     Zanbytes_Cdokus
 * @copyright   Copyright (c) 2014 Zanbytes Inc. (http://www.zanbytes.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
 * @desc    Catalog Product Documents
 * @author      Omar,Muhsin <info@zanbytes.com>
 * @version    $Id: mysql4-install-0.0.0.1.php 1104 2014-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2014 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer->startSetup();

/**
 * Create table 'zanbytes/links'
 */
if (version_compare(Mage::getVersion(), '1.5.1.0', '>') === true) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('cdokus/links'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Entity ID')
        ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_CHAR, 55, array(
            'nullable' => false,
        ), 'Sku')
        ->addColumn('filename', Varien_Db_Ddl_Table::TYPE_VARCHAR, 155, array(
            'nullable' => false,
        ), 'File Name')
        ->addColumn('label', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Label')
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'default' => 0,
        ), 'Store Id')
        ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'default' => 0,
        ), 'Position')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'default' => 1,
        ), 'Is Active')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => false,
        ), 'Created At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => false,
        ), 'Updated At')
        ->addIndex($installer->getIdxName('cdokus/links', array('filename')), array('filename'))
        ->addIndex(
            $installer->getIdxName(
                array('cdokus/links', 'decimal'), array('filename', 'store_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
            ), array('filename', 'store_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
        ->addForeignKey($installer->getFkName('cdokus/links', 'sku', 'catalog/product', 'sku'), 'sku', $installer->getTable('catalog/product'), 'sku', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName('cdokus/links', 'store_id', 'core/store', 'store_id'), 'store_id', $installer->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Cdokus Links');
    $installer->getConnection()->dropTable($installer->getTable('cdokus/links'));
    $installer->getConnection()->createTable($table);
} else {

    $installer->run("
DROP TABLE IF EXISTS `{$this->getTable('cdokus/links')}`;
CREATE TABLE `{$this->getTable('cdokus/links')}` (
  `entity_id` int NOT NULL auto_increment COMMENT 'Entity ID',
  `sku` varchar(55) NOT NULL COMMENT 'Sku',
  `filename` varchar(155) NOT NULL COMMENT 'File Name',
  `label` text NOT NULL COMMENT 'Label',
  `store_id` smallint unsigned NOT NULL default '0' COMMENT 'Store Id',
  `position` int NOT NULL default '0' COMMENT 'Position',
  `is_active` int NOT NULL default '1' COMMENT 'Is Active',
  `created_at` datetime NOT NULL COMMENT 'Created At',
  `updated_at` datetime NOT NULL COMMENT 'Updated At',
  PRIMARY KEY (`entity_id`),
  INDEX `IDX_ZANBYTES_CDOKUS_FILENAME` (`filename`),
  UNIQUE `UNQ_ZANBYTES_CDOKUS_DECIMAL_FILENAME_STORE_ID` (`filename`, `store_id`),
  CONSTRAINT `FK_ZANBYTES_CDOKUS_SKU_CATALOG_PRODUCT_ENTITY_SKU` FOREIGN KEY (`sku`) REFERENCES `catalog_product_entity` (`sku`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ZANBYTES_CDOKUS_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT='Cdokus Links' ENGINE=INNODB charset=utf8 COLLATE=utf8_general_ci
");
}
$installer->endSetup();

//create the dirs
$_dir = Mage::getBaseDir() . DS . 'media' . DS . 'catalog' . DS . 'docs' . DS;
if (!file_exists($_dir)) {
    if (!mkdir($_dir, 0777, true)) {
        throw new Exception('failed to create dir, check your permission in var');
    }
}


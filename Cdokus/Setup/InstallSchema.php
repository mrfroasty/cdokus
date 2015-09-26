<?php

namespace Zanbytes\Cdokus\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        /* @var $installer Mage_Catalog_Model_Resource_Setup */
        $installer->startSetup();

        /**
         * Create table 'zanbytes/links'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('cdokus_links'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                'sku',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                55,
                ['nullable' => false],
                'Sku'
            )
            ->addColumn('filename',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                155,
                ['nullable' => false],
                'File Name'
            )
            ->addColumn('label',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Label'
            )
            ->addColumn('store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => 0],
                'Store Id'
            )
            ->addColumn('position',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => 0],
                'Position'
                )
            ->addColumn('is_active',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false,'default' => 1],
            'Is Active'
            )
            ->addColumn('created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Created At'
            )
            ->addColumn('updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Updated At')
            ->addIndex(
                $installer->getIdxName('cdokus_links', ['filename']),
                ['filename']
            )
            ->addIndex(
                $installer->getIdxName(
                    'cdokus_links',
                    ['filename', 'store_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['filename', 'store_id'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addForeignKey(
                $installer->getFkName('cdokus_links', 'sku', 'catalog_product_entity', 'sku'),
                'sku',
                $installer->getTable('catalog_product_entity'),
                'sku',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName('cdokus_links', 'store_id', 'store_entity', 'store_id'),
                'store_id',
                $installer->getTable('store_entity'),
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Cdokus Links');
        $installer->getConnection()->dropTable($installer->getTable('cdokus_links'));
        $installer->getConnection()->createTable($table);

    }
}

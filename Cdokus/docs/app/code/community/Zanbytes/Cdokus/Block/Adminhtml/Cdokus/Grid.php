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
 * @copyright   Copyright (c) 2015 Zanbytes Inc. (http://www.zanbytes.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @desc    Catalog Product Documents
 * @author      Omar,Muhsin <info@zanbytes.com>
 * @version    $Id: Grid.php 1104 2015-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2015 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Zanbytes_Cdokus_Block_Adminhtml_Cdokus_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('cdokus_links_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        /** @var $collection Zanbytes_Cdokus_Model_Resource_Link_Collection */
        $collection = Mage::getResourceModel('cdokus/link_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('cdokus')->__('ID'),
            'sortable' => true,
            'width' => 60,
            'index' => 'entity_id'
        ));


        $this->addColumn('sku', array(
            'header' => Mage::helper('cdokus')->__('SKU'),
            'width' => 80,
            'index' => 'sku'
        ));

        $this->addColumn('filename', array(
            'header' => Mage::helper('cdokus')->__('File Name'),
            'width' => 80,
            'index' => 'filename'
        ));

        $this->addColumn('label', array(
            'header' => Mage::helper('cdokus')->__('Label'),
            'width' => 80,
            'index' => 'label'
        ));

        $this->addColumn('store_id', array(
            'header' => Mage::helper('cdokus')->__('Store'),
            'index' => 'store_id',
            'type' => 'store',
            'store_view' => false,
            'display_deleted' => false,
            'skipEmptyStoresLabel' => true,
        ));

        $this->addColumn('is_active', array(
            'header' => Mage::helper('cdokus')->__('Status'),
            'width' => '70px',
            'index' => 'is_active',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('cdokus')->__('Created On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '250px',
        ));

        $this->addColumn('updated_at', array(
            'header' => Mage::helper('cdokus')->__('Updated On'),
            'index' => 'updated_at',
            'type' => 'datetime',
            'width' => '250px',
        ));


        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('cdokus');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('catalog')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('catalog')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('catalog/product_status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('catalog')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('catalog')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('link_id' => $row->getEntityId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

}


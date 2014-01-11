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
 * @desc 	Catalog Product Documents
 * @author      Omar,Muhsin <info@zanbytes.com>
 * @version 	$Id: Grid.php 1104 2014-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright 	Copyright (c) 2014 Zanbytes Inc. (http://www.zanbytes.com)
 * @license 	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Zanbytes_Cdokus_Block_Adminhtml_Catalog_Product_Edit_Tab_Links_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Pager visibility
     *
     * @var boolean
     */
    protected $_pagerVisibility = false;

    /**
     * Filter visibility
     *
     * @var boolean
     */
    protected $_filterVisibility = false;

    /**
     * Set grid params
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('cdokus_links_product_grid');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
    }

    /**
     * Retirve currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct() {
        return Mage::registry('current_product');
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection() {
        $collection = Mage::getResourceModel('cdokus/link_collection')
                ->addFieldToFilter('sku', $this->_getProduct()->getSku());
        if ($storeId = Mage::app()->getRequest()->getParam('store', false)) {
            $collection->addFieldToFilter('store_id', $storeId);
        } else {
            $collection->addFieldToFilter('store_id', Mage_Core_Model_App::ADMIN_STORE_ID);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Checks when this block is readonly
     *
     * @return boolean
     */
    public function isReadonly() {
        return $this->_getProduct()->getRelatedReadonly();
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns() {

        $this->addColumn('in_products', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'in_products',
            'align' => 'center',
            'index' => 'entity_id'
        ));


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

        $this->addColumn('position', array(
            'header' => Mage::helper('cdokus')->__('Position'),
            'name' => 'position',
            'type' => 'number',
            'validate_class' => 'validate-number',
            'index' => 'position',
            'width' => 100,
            'editable' => true,
            'edit_only' => true
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('cdokus')->__('Activation'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('catalog')->__('Disable'),
                    'url' => array(
                        'base' => '*/cdokus_product_edit/status',
                        'params' => array(
                            'is_active' => Zanbytes_Cdokus_Model_Link::STATUS_DISABLED),
                    ),
                    'field' => 'link_id'
                ),
                array(
                    'caption' => Mage::helper('cdokus')->__('Enable'),
                    'url' => array(
                        'base' => '*/cdokus_product_edit/status',
                        'params' => array(
                            'is_active' => Zanbytes_Cdokus_Model_Link::STATUS_ENABLED),
                    ),
                    'field' => 'link_id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'entity_id',
        ));

        $this->addColumn('delete', array(
            'header' => Mage::helper('cdokus')->__('Delete'),
            'type' => 'action',
            'width' => '10px',
            'getter' => 'getId',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'cdokus/adminhtml_catalog_product_edit_tab_links_action_renderer',
            'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('*/cdokus_product_edit/tabgrid', array('_current' => true));
    }

    /**
     * Return row url for js event handlers
     *
     * @param Mage_Catalog_Model_Product|Varien_Object
     * @return string
     */
    public function getRowUrl($link) {
        return $this->getUrl('*/cdokus_document_link/edit', array('link_id' => $link->getId(), '_current' => true));
    }

    /**
     * Retrieve Available links
     *
     * @return array
     */
    public function getSelectedProducts() {
        $collection = Mage::getResourceModel('cdokus/link_collection')
                ->addFieldToFilter('sku', $this->_getProduct()->getSku());
        $products = array();
        foreach ($collection as $link) {
            $products[$link->getId()] = array('position' => $link->getPosition());
        }
        return $products;
    }

}


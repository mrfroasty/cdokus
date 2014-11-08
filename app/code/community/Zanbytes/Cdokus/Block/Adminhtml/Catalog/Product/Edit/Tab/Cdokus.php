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
 * @version    $Id: Cdokus.php 1104 2014-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2014 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Zanbytes_Cdokus_Block_Adminhtml_Catalog_Product_Edit_Tab_Cdokus extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function __construct()
    {
        parent::__construct();
        $this->setSkipGenerateContent(true);
        $this->setTemplate('cdokus/product/edit/cdokus.phtml');
    }

    public function getTabUrl()
    {
        return $this->getUrl('*/cdokus_product_edit/form', array('_current' => true));
    }

    public function getUpdateUrl()
    {
        return $this->getUrl('*/cdokus_product_edit/update', array(
            'back' => 'edit',
            'id' => Mage::app()->getRequest()->getParam('id'),
            'tab' => 'product_info_tabs_cdokus',
            'store' => Mage::app()->getRequest()->getParam('store')
        ));
    }

    public function getaddUrl()
    {
        return $this->getUrl('*/cdokus_product_edit/add', array(
            'back' => 'edit',
            'id' => Mage::app()->getRequest()->getParam('id'),
            'tab' => 'product_info_tabs_cdokus',
            'store' => Mage::app()->getRequest()->getParam('store'),
        ));
    }

    public function getTabClass()
    {
        return 'ajax';
    }

    /**
     * Prepare layout
     *
     * @return Mage_Bundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Bundle
     */
    protected function _prepareLayout()
    {
        $message = Mage::helper('catalog')->__('Are you sure?');
        $this->setChild('add_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('cdokus')->__('Add New Option'),
                    'class' => 'add',
                    'id' => 'add_new_file',
                    'onclick' => 'if( confirm(\'' . $message . '\')) {productForm.submit(\'' . $this->getAddUrl() . '\');}return false;'
                ))
        );

        $this->setChild('update_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('cdokus')->__('Update Position'),
                    'class' => 'update',
                    'id' => 'update_link_position',
                    'onclick' => 'if( confirm(\'' . $message . '\')) {productForm.submit(\'' . $this->getUpdateUrl() . '\');}return false;'
                ))
        );

        $this->setChild('links_grid', $this->getLayout()->createBlock('cdokus/adminhtml_catalog_product_edit_tab_links_grid', 'adminhtml.catalog.product.edit.tab.links.grid')
        );

        return parent::_prepareLayout();
    }

    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }

    public function getUpdateButtonHtml()
    {
        return $this->getChildHtml('update_button');
    }

    public function getAvailableGridBoxHtml()
    {
        return $this->getChildHtml('links_grid');
    }

    public function getFormHtml()
    {
        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post')
        );

        $form::setElementRenderer(
            $this->getLayout()->createBlock('adminhtml/widget_form_renderer_element')
        );
        $form::setFieldsetRenderer(
            $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset')
        );
        $form::setFieldsetElementRenderer(
            $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element')
        );

        $fieldset = $form->addFieldset('cdokus_fields', array('legend' => Mage::helper('cdokus')->__('Cdokus uploader'))
        );

        $fieldset->addField('cdokus_filename', 'file', array(
            'name' => 'cdokus_filename',
            'label' => Mage::helper('cdokus')->__('Upload file'),
            'required' => false,
            'note' => Mage::getSingleton('cdokus/link')->getConfigData('allowed_file_extension')
        ));

        $fieldset->addField('cdokus_label', 'text', array(
            'name' => 'cdokus_label',
            'label' => Mage::helper('cdokus')->__('File label'),
            'class' => 'input',
            'required' => false,
        ));

        $fieldset->addField('cdokus_is_active', 'select', array(
            'label' => Mage::helper('cdokus')->__('Status'),
            'name' => 'cdokus_is_active',
            'required' => false,
            'values' => array(
                array(
                    'value' => Zanbytes_Cdokus_Model_Link::STATUS_DISABLED,
                    'label' => Mage::helper('cdokus')->__('Inactive'),
                ),
                array(
                    'value' => Zanbytes_Cdokus_Model_Link::STATUS_ENABLED,
                    'label' => Mage::helper('cdokus')->__('Active'),
                )
            ),
            'value' => 1,
        ));
        return $form->toHtml();
    }

    public function getProduct()
    {
        return Mage::registry('product');
    }

    public function getTabLabel()
    {
        return Mage::helper('cdokus')->__('Documents');
    }

    public function getTabTitle()
    {
        return Mage::helper('cdokus')->__('Documents');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

}

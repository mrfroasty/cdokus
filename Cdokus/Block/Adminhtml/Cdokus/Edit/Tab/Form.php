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
 * @version    $Id: Form.php 1103 2014-02-18 00:30:55Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2014 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Zanbytes_Cdokus_Block_Adminhtml_Cdokus_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $this->setForm($form);
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

        $fieldset->addField('sku', 'text', array(
            'name' => 'sku',
            'label' => Mage::helper('cdokus')->__('SKU'),
            'class' => 'input',
            'required' => true,
            'readonly' => true,
            'disabled' => true,
            'note' => Mage::helper('cdokus')->__('read only')
        ));

        $fieldset->addField('filename', 'text', array(
            'name' => 'filename',
            'label' => Mage::helper('cdokus')->__('File'),
            'class' => 'input',
            'required' => true,
            'readonly' => true,
            'disabled' => true,
            'note' => Mage::helper('cdokus')->__('read only')
        ));

        $fieldset->addField('store_id', 'select', array(
            'label' => Mage::helper('cdokus')->__('Store ID'),
            'name' => 'store_id',
            'required' => true,
            'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));

        $fieldset->addField('label', 'text', array(
            'name' => 'label',
            'label' => Mage::helper('cdokus')->__('File label'),
            'class' => 'input',
            'required' => true,
        ));

        $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => Mage::helper('cdokus')->__('Position'),
            'class' => 'input',
            'required' => true,
        ));

        $fieldset->addField('is_active', 'select', array(
            'label' => Mage::helper('cdokus')->__('Status'),
            'name' => 'is_active',
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
        ));
        if ($link = Mage::getModel('cdokus/link')->load($this->getRequest()->getParam('link_id'))) {
            $form->setValues($link->getData());
        }
    }

}
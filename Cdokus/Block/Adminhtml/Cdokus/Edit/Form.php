<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Zanbytes\Cdokus\Block\Adminhtml\Cdokus\Edit;

/**
 * Cms page edit form main tab
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }


    protected function _prepareForm()
    {
        /*
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
        }*/

        /* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('cdokus_link');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Magento_Cms::save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Page Information')]);

        if ($model->getId()) {
            $fieldset->addField('page_id', 'hidden', ['name' => 'page_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Page Title'),
                'title' => __('Page Title'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'identifier',
            'text',
            [
                'name' => 'identifier',
                'label' => __('URL Key'),
                'title' => __('URL Key'),
                'class' => 'validate-identifier',
                'note' => __('Relative to Web Site Base URL'),
                'disabled' => $isElementDisabled
            ]
        );

        /**
         * Check is single store mode
         */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'stores[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true),
                    'disabled' => $isElementDisabled
                ]
            );
            $renderer = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
            $model->setStoreId($this->_storeManager->getStore(true)->getId());
        }

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Page Status'),
                'name' => 'is_active',
                'required' => true,
                'options' => $model->getAvailableStatuses(),
                'disabled' => $isElementDisabled
            ]
        );
        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $this->_eventManager->dispatch('adminhtml_cms_page_edit_tab_main_prepare_form', ['form' => $form]);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();


    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Page Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Page Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}

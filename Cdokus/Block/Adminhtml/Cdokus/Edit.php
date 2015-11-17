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
 * @version    $Id: Edit.php 1104 2015-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2015 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Zanbytes\Cdokus\Block\Adminhtml\Cdokus;

/**
 * Admin CMS page
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'Zanbytes_Cdokus';
        $this->_controller = 'adminhtml_cdokus';
        $this->buttonList->remove('reset');
        $this->buttonList->add('delete', array(
            'label' => __('Delete'),
            'class' => 'delete',
            'onclick' => 'deleteConfirm(\'' . __('Are you sure you want to do this?')
                . '\', \'' . $this->getDeleteUrl() . '\')',
        ));
    }

//    public function getHeaderText()
//    {
//        if ($link = Mage::getModel('cdokus/link')->load($this->getRequest()->getParam('link_id', false))) {
//            Mage::getSingleton('adminhtml/session')->setLinkData($link->getData());
//            return __('Link # %s | %s', $link->getEntityId(), $this->formatDate($link->getCreatedAt(), 'medium', true));
//        }
//    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('cdokus_link')->getId()) {
            return __("Edit Link '%1'", $this->escapeHtml($this->_coreRegistry->registry('cdokus_link')->getTitle()));
        } else {
            return __('New Link');
        }
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array('link_id' => $this->getRequest()->getParam('link_id')));
    }

}
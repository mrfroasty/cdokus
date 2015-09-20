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
 * @version    $Id: LinkController.php 1104 2015-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2015 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Zanbytes_Cdokus_Adminhtml_Cdokus_Document_LinkController extends Mage_Adminhtml_Controller_Action
{

    protected function _construct()
    {
        $this->setUsedModuleName('Zanbytes_Cdokus');
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_title($this->__('Catalog Links Overview'));
        $this->_setActiveMenu('catalog/cdokus');
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->loadLayout();
        $this->_title($this->__('Catalog Links Overview'));
        $this->_setActiveMenu('catalog/cdokus');
        $this->renderLayout();
    }

    public function massStatusAction()
    {
        $collection = $this->_getCollection();
        if ($collection->count() <= 0) {
            $this->_getSession()->addError($this->__('Please select link(s).'));
            $this->_redirect('*/*/');
        }
        try {
            foreach ($collection as $link) {
                $link->setIsActive($this->getRequest()->getPost('status'))
                    ->save();
            }
            $this->_getSession()->addSuccess($this->__('%s link(s) status updated.', $collection->count()));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $collection = $this->_getCollection();
        if ($collection->count() <= 0) {
            $this->_getSession()->addError($this->__('Please select link(s).'));
            $this->_redirect('*/*/');
        }
        try {
            foreach ($collection as $link) {
                $link->delete();
            }
            $this->_getSession()->addSuccess($this->__('%s link(s) status deleted.', $collection->count()));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    protected function _getCollection()
    {
        return Mage::getResourceModel('cdokus/link_collection')
            ->addFieldToFilter('entity_id', array('in' => $this->getRequest()->getPost('cdokus', array())));
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if ($data) {
            try {
                if ($linkId = $this->getRequest()->getParam('link_id', false)) {
                    if ($link = Mage::getModel('cdokus/link')->load($linkId)) {
                        $link->setStoreId($this->getRequest()->getPost('store_id'))
                            ->setLabel($this->getRequest()->getPost('label'))
                            ->setPosition($this->getRequest()->getPost('position'))
                            ->setIsActive($this->getRequest()->getPost('is_active'))
                            ->save();
                        $this->_getSession()->addSuccess($this->__('The link # %s updated.', $link->getId()));
                    }
                }
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {
            if ($linkId = $this->getRequest()->getParam('link_id', false)) {
                if ($link = Mage::getModel('cdokus/link')->load($linkId)) {
                    $link->delete();
                    $storeId = $link->getStoreId();
                    $this->_getSession()->addSuccess($this->__("The link is now removed."));
                    $this->_getSession()->addNotice($this->__("File %s is left for you to manually delete it.", $link->getData('filename')));
                }
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

}

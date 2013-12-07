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
 * @copyright   Copyright (c) 2013 Zanbytes Inc. (http://www.zanbytes.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
 * @desc 	Catalog Product Documents
 * @author      Omar,Muhsin <info@zanbytes.com>
 * @version 	$Id: EditController.php 1104 2013-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright 	Copyright (c) 2013 Zanbytes Inc. (http://www.zanbytes.com)
 * @license 	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';

/**
 * Adminhtml bundle product edit
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Zanbytes_Cdokus_Adminhtml_Cdokus_Product_EditController extends Mage_Adminhtml_Catalog_ProductController {

    protected function _construct() {
        $this->setUsedModuleName('Zanbytes_Cdokus');
    }

    public function formAction() {
        $product = $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('admin.product.cdokus.items')
                ->setProductId($product->getId());
        $this->renderLayout();
    }

    public function addAction() {
        $product = $this->_initProduct();
        $storeId = $this->getRequest()->getParam('store', Mage_Core_Model_App::ADMIN_STORE_ID);
        $redirectBack = $this->getRequest()->getParam('back', false);
        $productId = $this->getRequest()->getParam('id');
        $isEdit = (int) ($this->getRequest()->getParam('id') != null);

        $data = $this->getRequest()->getPost();
        if ($data) {
            try {
                $sku = $product->getSku();
                if (empty($sku))
                    Mage::throwException($this->__('System error, sku can not be retrieved!'));
                $link = Mage::getModel('cdokus/link');

                /**
                 * Upload handler
                 */
                $uploader = new Varien_File_Uploader('cdokus_filename');
                $uploader->setFilesDispersion((bool) $link->getConfigData('allow_file_dispersion'));
                $uploader->setAllowRenameFiles((bool) $link->getConfigData('allow_file_rename'));
                $uploader->setAllowedExtensions(explode(',', $link->getConfigData('allowed_file_extension')));
                $result = $uploader->save($link->getDirpath());
                $label = $this->getRequest()->getParam('cdokus_label', null);
                $isActive = $this->getRequest()->getParam('cdokus_is_active', true);
                $link->setSku($sku)
                        ->setFilename($result['file'])
                        ->setLabel($label)
                        ->setStoreId($storeId)
                        ->setIsActive($isActive)
                        ->setCreatedAt(now())
                        ->setUpdatedAt(now())
                        ->save();
                /**
                 * Generate event , just incase someone want to dive in here
                 */
                Mage::dispatchEvent('catalog_product_cdokus_upload_document_after', array(
                    'result' => $result,
                    'action' => $link
                ));
                $this->_getSession()->addSuccess($this->__('The link has been saved.'));
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage())
                        ->setProductData($data);
                $redirectBack = true;
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            }
        }
        if ($redirectBack) {
            $this->_redirect('*/catalog_product/edit', array(
                'id' => $productId,
                '_current' => true
            ));
        } elseif ($this->getRequest()->getParam('popup')) {
            $this->_redirect('*/catalog_product/created', array(
                '_current' => true,
                'id' => $productId,
                'edit' => $isEdit
            ));
        } else {
            $this->_redirect('*/catalog_product/', array('id' => $productId, 'store' => $storeId, '_current' => true,));
        }
    }

    public function updateAction() {
        $storeId = $this->getRequest()->getParam('store');
        $redirectBack = $this->getRequest()->getParam('back', false);
        $productId = $this->getRequest()->getParam('id');
        $isEdit = (int) ($this->getRequest()->getParam('id') != null);

        $data = $this->getRequest()->getPost();
        if ($data) {
            try {
                if ($links = $this->getRequest()->getParam('links', array())) {
                    $links = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['cdocus']);
                    foreach ($links as $linkId => $position) {
                        if ($link = Mage::getModel('cdokus/link')->load($linkId)) {
                            $link->setPosition($position['position'])->setUpdatedAt(now())->save();
                        }
                    }
                }
                $this->_getSession()->addSuccess($this->__('The link position updated.'));
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage())
                        ->setProductData($data);
                $redirectBack = true;
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            }
        }

        if ($redirectBack) {
            $this->_redirect('*/catalog_product/edit', array(
                'id' => $productId,
                '_current' => true
            ));
        } elseif ($this->getRequest()->getParam('popup')) {
            $this->_redirect('*/catalog_product/created', array(
                '_current' => true,
                'id' => $productId,
                'edit' => $isEdit
            ));
        } else {
            $this->_redirect('*/catalog_product/', array('id' => $productId, 'store' => $storeId));
        }
    }

    public function deletelinkAction() {
        $productId = $this->getRequest()->getParam('id');
        try {
            if ($linkId = $this->getRequest()->getParam('link_entity_id', false)) {
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
        $this->_redirect('*/catalog_product/edit', array(
            'id' => $productId,
            '_current' => true,
            'tab' => 'product_info_tabs_cdokus',
            'store' => $storeId
        ));
    }

    public function statusAction() {
        try {
            if ($linkId = $this->getRequest()->getParam('link_id', false)) {
                if ($link = Mage::getModel('cdokus/link')->load($linkId)) {
                    $link->setIsActive($this->getRequest()->getParam('is_active'))
                            ->setUpdatedAt(now())
                            ->save();
                    $storeId = $link->getStoreId();
                    $productId = Mage::getResourceModel('catalog/product')->getIdBySku($link->getSku());
                    $status = $link->getIsActive() == Zanbytes_Cdokus_Model_Link::STATUS_ENABLED ?
                            $this->__('enabled') : $this->__('disabled');
                    $this->_getSession()->addSuccess($this->__("The link %s status is to %s.", $link->getId(), $status));
                }
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_redirect('*/catalog_product/edit', array(
            'id' => $productId,
            '_current' => true,
            'tab' => 'product_info_tabs_cdokus',
            'store' => $storeId
        ));
    }

    public function tabgridAction() {
        $product = $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('adminhtml.catalog.product.edit.tab.links.grid')
                ->setProductId($product->getId());
        $this->renderLayout();
    }

}

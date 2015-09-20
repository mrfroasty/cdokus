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
 * @version    $Id: Download.php 1104 2014-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2014 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Zanbytes_Cdokus_Block_Download extends Mage_Core_Block_Template
{

    protected $_collection;

    protected function _beforeToHtml()
    {
        if (!$this->getProductSku()) {
            return false;
        }
        return parent::_beforeToHtml();
    }

    /**
     * The final moment of truth i.e html
     * @desc Assumptions the last entry will be set at default store
     * @see Mage_Catalog_Model_Resource_Product_Link_Product_Collection::setStoreOrder
     * @return string
     */
    public function getAllLinks()
    {
        $links = array();
        $collection = $this->_getCollection();
        if ($collection->count() <= 0)
            return false;
        $_exclArray = array();
        foreach ($collection as $link) {
            $path = $link->getFilename();
            $filename = basename($path);
            if (empty($filename) || !file_exists($path) || in_array($filename, $_exclArray)) {
                continue;
            }
            $_exclArray[] = $filename;
            $links[] = $link;
        }
        return $links;
    }

    /**
     * Create link
     * @param Zanbytes_Cdokus_Model_Link $link
     * @return type
     */
    public function getDownloadUrl(Zanbytes_Cdokus_Model_Link $link)
    {
        return $this->getUrl('cdokus/download/index', array('link_id' => $link->getId()));
    }

    protected function _getCollection()
    {
        if (!$this->_collection && $this->getProductSku()) {
            $model = Mage::getModel('cdokus/link');
            $this->_collection = $model->getResourceCollection()
                ->addSkuToSelect($this->getProductSku())
                ->addProductFilter()
                ->addStoreFilter(Mage::app()->getStore()->getId())
                ->addActiveFilter(Zanbytes_Cdokus_Model_Link::STATUS_ENABLED)
                ->setPositionOrder();
        }
        return $this->_collection;
    }

    public function getProductSku()
    {
        if ($product = Mage::registry('current_product')) {
            return $product->getSku();
        }
        return false;
    }

}
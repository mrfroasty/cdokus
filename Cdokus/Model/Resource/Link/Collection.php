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
 * @version    $Id: Collection.php 1105 2015-03-17 22:41:47Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2015 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Zanbytes_Cdokus_Model_Resource_Link_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    protected $_sku = null;

    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('cdokus/link');
    }

    public function addSkuToSelect($sku)
    {
        $this->_sku = $sku;
        return $this;
    }

    /**
     * Add filter by store
     *
     * @param array | int $storeId
     * @return Mage_Tag_Model_Resource_Tag_Collection
     */
    public function addStoreFilter($storeId)
    {
        /**
         * All links on the store view level
         */
        $this->getSelect()->where('main_table.store_id = ?', $storeId);
        $files = array();
        if ($storeLinks = $this->getConnection()->fetchAll($this->getSelect())) {
            foreach ($storeLinks as $link) {
                $files[] = $link['filename'];
            }
        }
        /**
         * All links on default level, duplicate handled here
         */
        $sql = $this->getConnection()
            ->select()
            ->from(array('s' => $this->getMainTable()), array('entity_id'))
            ->where('s.store_id IN(?)', array($storeId, Mage_Core_Model_App::ADMIN_STORE_ID))
            ->where('s.sku = ?', $this->_sku);
        if (!empty($files))
            $sql->where('s.filename NOT IN(?)', $files);
        /**
         * Getll all the links
         */
        $this->getSelect()->orWhere('main_table.entity_id IN(?)', $sql);
        return $this;
    }

    /**
     * Adds filter by status
     *
     * @param int $status
     * @return Mage_Tag_Model_Resource_Tag_Collection
     */
    public function addActiveFilter($status)
    {
        $this->getSelect()->where('main_table.is_active = ?', $status);
        return $this;
    }

    /**
     * Add filter by SKU
     *
     * @param array | int $sku
     * @return Mage_Tag_Model_Resource_Tag_Collection
     */
    public function addProductFilter()
    {
        $this->getSelect()->where('main_table.sku = ?', $this->_sku);
        return $this;
    }

    /**
     * Enable sorting links by position
     *
     * @param string $dir sort type asc|desc
     * @return Mage_Catalog_Model_Resource_Product_Link_Product_Collection
     */
    public function setPositionOrder($dir = self::SORT_ORDER_DESC)
    {
        $this->getSelect()->order('main_table.position ' . $dir);
        return $this;
    }

}

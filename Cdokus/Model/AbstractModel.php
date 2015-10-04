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
 * @desc        Catalog Product Documents
 * @author      Omar,Muhsin <info@zanbytes.com>
 * @version     $Id: Abstract.php 1104 2015-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright   Copyright (c) 2015 Zanbytes Inc. (http://www.zanbytes.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Zanbytes\Cdokus\Model;

abstract class AbstractModel extends \Magento\Framework\Model\AbstractModel
{
    protected $_dirPath = null;

    /**
     * Model initialization
     *
     * @param string $resourceModel
     * @param string $idFieldName
     * @return Mage_Core_Model_Abstract
     */
    protected function _construct($dir = null)
    {
        $this->_init('Zanbytes\Cdokus\Model\Resource\Link');
        $this->setDirpath($dir);
    }

    /**
     * @desc Get Directory Path
     * @return type string path used to store docs
     */
    public function getDirpath()
    {
        return $this->setDirpath();
    }

    public function setDirpath($dir = null)
    {
        if (null === $dir) {
            $this->_dirPath = Mage::getBaseDir() . DS . 'media' . DS . 'catalog' . DS . 'docs' . DS;            
        }
        $this->setData('dir_path', $dir);
        return $this->_dirPath;
    }

    /**
     * Retrieve information from configuration
     *
     * @param string $field
     * @param int|string|null|Mage_Core_Model_Store $storeId
     *
     * @return mixed
     */
    
    //TODO re-write these functions
    
    public function getConfigData($field, $storeId = null, $code = 'general')
    {
        if (null === $storeId) {
            $storeId = $this->getStore();
        }
        $path = 'cdokus/' . $code . '/' . $field;
        return Mage::getStoreConfig($path, $storeId);
    }

    public function getStore()
    {
        if ($storeId = $this->getData('store_id')) {
            return $storeId;
        }
        return Mage::app()->getStore()->getId();
    }

}
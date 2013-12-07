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
 * @version 	$Id: Abstract.php 1104 2013-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright 	Copyright (c) 2013 Zanbytes Inc. (http://www.zanbytes.com)
 * @license 	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class Zanbytes_Cdokus_Model_Abstract extends Mage_Core_Model_Abstract {

    protected $_dirPath = null;

    /**
     * Model initialization
     *
     * @param string $resourceModel
     * @param string $idFieldName
     * @return Mage_Core_Model_Abstract
     */
    protected function _construct() {
        $this->_init('cdokus/link');
        $this->setDirpath();
    }

    /**
     * @desc Get Directory Path
     * @return type string path used to store docs
     */
    public function getDirpath() {
        return $this->setDirpath();
    }

    public function setDirpath($dir = null) {
        if (null === $dir)
            $this->_dirPath = Mage::getBaseDir() . DS . 'media' . DS . 'catalog' . DS . 'docs' . DS;
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
    public function getConfigData($field, $storeId = null, $code = 'general') {
        if (null === $storeId) {
            $storeId = $this->getStore();
        }
        $path = 'cdokus/' . $code . '/' . $field;
        return Mage::getStoreConfig($path, $storeId);
    }

    public function getStore() {
        if ($storeId = $this->getData('store_id')) {
            return $storeId;
        }
        return Mage::app()->getStore()->getId();
    }

    public function verifyLicence($host = null) {
        if (null === $host) {
            $url = new Varien_Object(parse_url(Mage::app()->getStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK)));
            $host = $url->getHost();
        }
        $signMac = Zend_Crypt_Hmac::compute('0JCC9KvtSGJZIFwlFuwhG1Ai4Sy4nTnd', 'sha1', $host);
        $license = base64_encode(pack('H*', $signMac));
        $backendKey = trim($this->getConfigData('license'));
        if (strcmp($backendKey, $license) === 0) {
            return true;
        }
        return false;
    }

    public function execute($observer) {
        if (!Mage::getModel('cdokus/link')->verifyLicence())
            Mage::getSingleton('adminhtml/session')
                    ->addError('Your license is invalid, please consult me via <a href="mailto:info@zanbytes.com">info@zanbytes.com</a>');
        return $this;
    }

}
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
 * @version     $Id: Link.txt 1104 2015-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright   Copyright (c) 2015 Zanbytes Inc. (http://www.zanbytes.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Zanbytes\Cdokus\Model;

use Zanbytes\Cdokus\Api\Data\LinkInterface;
use Magento\Framework\Object\IdentityInterface;

/**
 * Cms Page Model
 *
 * @method \Magento\Cms\Model\Resource\Page _getResource()
 * @method \Magento\Cms\Model\Resource\Page getResource()
 * @method int[] getStores()
 */
class Link extends \Zanbytes\Cdokus\Model\AbstractModel implements LinkInterface, IdentityInterface
{
    /**
     * No route page id
     */
    const NOROUTE_PAGE_ID = 'no-route';

    /**#@+
     * Page's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;
    /**#@-*/

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'cdokus_link';

    /**
     * @var string
     */
    protected $_cacheTag = 'cdokus_link';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'cdokus_link';

   /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }
    
    /**
     * Get SKU
     *
     * @return string
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }
    
    /**
     * Re-attach the directory path to the basename
     * @return type
     */
    public function getFilename()
    {
        return $this->getDirpath() . $this->getData(self::FILENAME);
    }
    
    /**
     * Get label
     *
     * @return string
     */    
    public function getLabel()
    {
        $label = $this->getData(self::LABEL);
        if (!empty($label)) {
            return $label;            
        }
        $pathinfo = pathinfo($this->getFilename());
        return $pathinfo['filename'];
    }
    
    /**
     * Get store_id
     *
     * @return int|null
     */    
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }
    

    /**
     * Get position
     *
     * @return int|null
     */
    public function getPosition()
    {
        return (int)$this->getData(self::POSITION);
    }
        
    /**
     * Get Is Active
     *
     * @return int|null
     */    
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }
    

    /**
     * Get created at
     *
     * @return string
     */    
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }
    
    
    /**
     * Get ID
     *
     * @return int|null
     */    
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }
    
    
       /**
     * Get ID
     *
     * @return int|null
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
    
    /**
     * Get SKU
     *
     * @return string
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }
    
    /**
     * Get Filename
     *
     * @return string
     */
    public function setFilename($filename)
    {
        return $this->setData(self::FILENAME, basename($filename));
    }
    
    /**
     * Get label
     *
     * @return string
     */    
    public function setLabel($label)
    {
        return $this->setData(self::LABEL, $label);
    }
    
    /**
     * Get store_id
     *
     * @return int|null
     */    
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }
    

    /**
     * Get position
     *
     * @return int|null
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }
        
    /**
     * Get Is Active
     *
     * @return int|null
     */    
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
    

    /**
     * Get created at
     *
     * @return string
     */    
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
    
    
    /**
     * Get ID
     *
     * @return int|null
     */    
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
  
    /**
     * Load object data
     *
     * @param int|null $id
     * @param string $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRoutePage();
        }
        return parent::load($id, $field);
    }


    /**
     * Prepare page's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    
    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

}


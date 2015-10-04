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
 * @version    $Id: Link.php 1104 2015-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright    Copyright (c) 2015 Zanbytes Inc. (http://www.zanbytes.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
class Link extends Zanbytes\Cdokus\Model\AbstractModel implements LinkInterface, IdentityInterface
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
        return parent::getData(self::ENTITY_ID);
    }
    
    /**
     * Re-attach the directory path to the basename
     * @return type
     */
    public function getFilename()
    {
        return $this->getDirpath() . $this->getData(self::FILENAME);
    }

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



}


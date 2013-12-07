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
 * @version 	$Id: Renderer.php 1104 2013-02-18 00:33:21Z muhsin $ $LastChangedBy: muhsin $
 * @copyright 	Copyright (c) 2013 Zanbytes Inc. (http://www.zanbytes.com)
 * @license 	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Zanbytes_Cdokus_Block_Adminhtml_Catalog_Product_Edit_Tab_Links_Action_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Render delete action link
     * @param Varien_Object $row
     * @return type
     */
    public function render(Varien_Object $row) {
        $label = $this->__('You are attempting link delete, you sure ?');
        $out = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
            'label' => $this->__('Delete'),
            'class' => 'delete icon-btn',
            'on_click' => "if (confirm('$label')) { setLocation('" . $this->getDeleteUrl($row->getId()) . "');}"
                ));
        return $out->toHtml();
    }

    /**
     * Get Delete URL
     * @param type $id
     * @return type
     */
    public function getDeleteUrl($id) {
        return $this->getUrl('*/cdokus_product_edit/deletelink', array(
                    'back' => 'edit',
                    'id' => Mage::app()->getRequest()->getParam('id'),
                    'tab' => 'product_info_tabs_cdokus',
                    'link_entity_id' => $id,
                ));
    }

}
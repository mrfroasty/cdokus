<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Zanbytes\Cdokus\Controller\Adminhtml\Links;

use Magento\Backend\App\Action;

class Index extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
//    protected $_coreRegistry;

    /**
     * @var \Magento\Widget\Model\Widget\Config
     */
//    protected $_widgetConfig;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Widget\Model\Widget\Config $widgetConfig
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
//        \Magento\Backend\App\Action\Context $context,
//        \Magento\Widget\Model\Widget\Config $widgetConfig,
//        \Magento\Framework\Registry $coreRegistry
    ) {
        die(__METHOD__.'#'.__LINE__);
//        $this->_widgetConfig = $widgetConfig;
//        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

//    /**
//     * Wisywyg widget plugin main page
//     *
//     * @return void
//     */
//    public function execute()
//    {
//        // save extra params for widgets insertion form
//        $skipped = $this->getRequest()->getParam('skip_widgets');
//        $skipped = $this->_widgetConfig->decodeWidgetsFromQuery($skipped);
//
//        $this->_coreRegistry->register('skip_widgets', $skipped);
//
//        $this->_view->loadLayout('empty')->renderLayout();
//    }
}

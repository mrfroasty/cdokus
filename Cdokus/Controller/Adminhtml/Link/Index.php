<?php

namespace Zanbytes\Cdokus\Controller\Adminhtml\Link;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Zanbytes_Cdokus::cdokus_links';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Zanbytes_Cdokus::cdokus_links');
        $resultPage->addBreadcrumb(__('Document Links'), __('Document Links'));
        $resultPage->addBreadcrumb(__('Manage Document Links'), __('Manage Document Links'));
        $resultPage->getConfig()->getTitle()->prepend(__('Catalog Links Overview'));
        return $resultPage;
    }
}


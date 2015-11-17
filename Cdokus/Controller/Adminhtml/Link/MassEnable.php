<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Controller\Adminhtml\Page;

use Magento\Cms\Controller\Adminhtml\AbstractMassStatus;

/**
 * Class MassEnable
 */
class MassEnable extends AbstractMassStatus
{
    /**
     * Field id
     */
    const ID_FIELD = 'entity_id';

    /**
     * Resource collection
     *
     * @var string
     */
    protected $collection = 'Zanbytes\Cdokus\Model\Resource\Link\Collection';

    /**
     * Page model
     *
     * @var string
     */
    protected $model = 'Zanbytes\Cdokus\Model\Link';

    /**
     * Page enable status
     *
     * @var boolean
     */
    protected $status = true;
}

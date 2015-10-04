<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Zanbytes\Cdokus\Model\Link\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $_cdokusLink;

    /**
     * Constructor
     *
     * @param \Magento\Cms\Model\Page $cdokusLink
     */
    public function __construct(\Zanbytes\Cdokus\Model\Link $cdokusLink)
    {
        $this->_cdokusLink = $cdokusLink;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->_cdokusLink->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}

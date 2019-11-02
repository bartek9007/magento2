<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Model\Block\Source;

use Magento\Cms\Model\Block;
use Magento\Cms\Model\Block\AvailableStatusesProvider;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 * @deprecated
 * @see \Magento\Cms\Model\Block\Source\Status
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var Block
     */
    protected $cmsBlock;

    /**
     * Constructor
     *
     * @param Block $cmsBlock
     */
    public function __construct(Block $cmsBlock)
    {
        $this->cmsBlock = $cmsBlock;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }

    /**
     * Get available statuses
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        $blockAvailableStatusesProvider = new AvailableStatusesProvider();
        return $blockAvailableStatusesProvider->get();
    }
}

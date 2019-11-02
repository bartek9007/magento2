<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Model\Block\Source;

use Magento\Cms\Api\Data\BlockAvailableStatusesProviderInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 *
 * @package Magento\Cms\Model\Block\Source
 */
class Status implements OptionSourceInterface
{
    /**
     * @var BlockAvailableStatusesProviderInterface
     */
    private $blockAvailableStatusesProvider;

    /**
     * Status constructor.
     *
     * @param BlockAvailableStatusesProviderInterface $blockAvailableStatusesProvider
     */
    public function __construct(BlockAvailableStatusesProviderInterface $blockAvailableStatusesProvider)
    {
        $this->blockAvailableStatusesProvider = $blockAvailableStatusesProvider;
    }

    /**
     * Get options
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function toOptionArray(): array
    {
        $availableOptions = $this->blockAvailableStatusesProvider->get();
        $options = [];

        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }

        return $options;
    }
}

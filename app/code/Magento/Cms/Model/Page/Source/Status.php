<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Model\Page\Source;

use Magento\Cms\Api\Data\BlockAvailableStatusesProviderInterface;
use Magento\Cms\Api\Data\PageAvailableStatusesProviderInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 *
 * @package Magento\Cms\Model\Page\Source
 */
class Status implements OptionSourceInterface
{
    /**
     * @var PageAvailableStatusesProviderInterface
     */
    private $pageAvailableStatusesProvider;

    /**
     * Status constructor.
     *
     * @param PageAvailableStatusesProviderInterface $pageAvailableStatusesProvider
     */
    public function __construct(PageAvailableStatusesProviderInterface $pageAvailableStatusesProvider)
    {
        $this->pageAvailableStatusesProvider = $pageAvailableStatusesProvider;
    }

    /**
     * Get options
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function toOptionArray(): array
    {
        $availableOptions = $this->pageAvailableStatusesProvider->get();
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

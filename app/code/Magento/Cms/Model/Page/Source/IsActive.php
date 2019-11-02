<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Model\Page\Source;

use Magento\Cms\Model\Page;
use Magento\Cms\Model\Page\AvailableStatusesProvider;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 * @deprecated
 * @see \Magento\Cms\Model\Page\Source\Status
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var Page
     */
    protected $cmsPage;

    /**
     * Constructor
     *
     * @param Page $cmsPage
     */
    public function __construct(Page $cmsPage)
    {
        $this->cmsPage = $cmsPage;
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
    private function getAvailableStatuses(): array
    {
        $pageAvailableStatusesProvider = new AvailableStatusesProvider();
        return $pageAvailableStatusesProvider->get();
    }
}

<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Api\Data;

/**
 * Interface PageAvailableStatusesProviderInterface
 *
 * @package Magento\Cms\Api\Data
 */
interface PageAvailableStatusesProviderInterface
{
    /**
     * Get available statuses
     *
     * @return array
     */
    public function get(): array;
}

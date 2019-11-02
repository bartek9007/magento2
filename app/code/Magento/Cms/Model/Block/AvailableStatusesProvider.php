<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Model\Block;

use Magento\Cms\Api\Data\BlockAvailableStatusesProviderInterface;

/**
 * Class AvailableStatusesProvider
 *
 * @package Magento\Cms\Model\Block
 */
class AvailableStatusesProvider implements BlockAvailableStatusesProviderInterface
{
    /**
     * @var int
     */
    private const STATUS_ENABLED = 1;

    /**
     * @var int
     */
    private const STATUS_DISABLED = 0;

    /**
     * Get available statues
     *
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function get(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}

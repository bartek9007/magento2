<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Model\Page\Source;

/**
 * Class StatusFilter
 *
 * @package Magento\Cms\Model\Page\Source
 */
class StatusFilter extends Status
{
    /**
     * Get options
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function toOptionArray(): array
    {
        return array_merge([['label' => '', 'value' => '']], parent::toOptionArray());
    }
}

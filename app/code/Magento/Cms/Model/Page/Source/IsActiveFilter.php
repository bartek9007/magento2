<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Model\Page\Source;

/**
 * Is active filter source
 * @deprecated
 * @see \Magento\Cms\Model\Page\Source\StatusFilter
 */
class IsActiveFilter extends IsActive
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return array_merge([['label' => '', 'value' => '']], parent::toOptionArray());
    }
}

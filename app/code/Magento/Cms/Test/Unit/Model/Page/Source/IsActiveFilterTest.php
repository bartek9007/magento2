<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Test\Unit\Model\Page\Source;

use Magento\Cms\Model\Page\Source\IsActiveFilter;

/**
 * Class IsActiveFilterTest
 *
 * @package Magento\Cms\Test\Unit\Model\Page\Source
 */
class IsActiveFilterTest extends IsActiveTest
{
    /**
     * {@inheritdoc}
     */
    protected function getSourceClassName(): string
    {
        return IsActiveFilter::class;
    }

    /**
     * @return void
     */
    public function testToOptionArray(): void
    {
        $this->cmsPageMock->expects($this->never())->method('getAvailableStatuses');

        $expected =
            [
                ['label' => '', 'value' => ''],
                ['label' => __('Enabled'), 'value' => self::STATUS_ENABLED],
                ['label' => __('Disabled'), 'value' => self::STATUS_DISABLED]
            ];
        $this->assertEquals($expected, $this->object->toOptionArray());
    }
}

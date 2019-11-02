<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Test\Unit\Model\Block\Source;

use Magento\Cms\Model\Block;
use Magento\Cms\Model\Block\Source\IsActive;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class IsActiveTest
 *
 * @package Magento\Cms\Test\Unit\Model\Block\Source
 */
class IsActiveTest extends TestCase
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
     * @var Block|MockObject
     */
    protected $cmsBlockMock;

    /**
     * @var ObjectManager
     */
    protected $objectManagerHelper;

    /**
     * @var IsActive
     */
    protected $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->objectManagerHelper = new ObjectManager($this);
        $this->cmsBlockMock = $this->getMockBuilder(Block::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAvailableStatuses'])
            ->getMock();

        $this->object = $this->objectManagerHelper->getObject(
            $this->getSourceClassName(),
            ['cmsBlock' => $this->cmsBlockMock]
        );
    }

    /**
     * @return string
     */
    protected function getSourceClassName(): string
    {
        return IsActive::class;
    }

    /**
     * @return void
     */
    public function testToOptionArray(): void
    {
        $this->cmsBlockMock->expects($this->never())->method('getAvailableStatuses');

        $expected =
            [
                ['label' => __('Enabled'), 'value' => self::STATUS_ENABLED],
                ['label' => __('Disabled'), 'value' => self::STATUS_DISABLED]
            ];
        $this->assertEquals($expected, $this->object->toOptionArray());
    }
}

<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Model;

use Magento\Cms\Api\Data\BlockExtensibleExtensionInterface;
use Magento\Cms\Api\Data\BlockExtensibleInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Model\ResourceModel\Block as BlockResource;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Class BlockExtensible
 * @package Magento\Cms\Model
 *
 * TODO: Maybe this should be part of interface and we get rid of magic here
 * @method Block setStoreId(array $storeId)
 * @method array getStoreId()
 */
class BlockExtensible extends AbstractExtensibleModel implements BlockExtensibleInterface, IdentityInterface
{
    /**
     * @var string
     */
    public const CACHE_TAG = 'cms_b';

    /**
     * @var int
     */
    public const STATUS_ENABLED = 1;

    /**
     * @var int
     */
    public const STATUS_DISABLED = 0;

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'cms_block';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(BlockResource::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->getData(self::BLOCK_ID);
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return (string) $this->getData(self::IDENTIFIER);
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @return string|null
     */
    public function getCreationTime(): ?string
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * @return string|null
     */
    public function getUpdateTime(): ?string
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * @param int|mixed $id
     * @return void
     */
    public function setId($id): BlockExtensibleInterface
    {
        $this->setData(self::BLOCK_ID, (int) $id);
        return $this;
    }

    /**
     * @param string $identifier
     *
     * @return BlockInterface
     */
    public function setIdentifier($identifier): BlockExtensibleInterface
    {
        $this->setData(self::IDENTIFIER, $identifier);
        return $this;
    }

    /**
     * @param string $title
     *
     * @return BlockInterface
     */
    public function setTitle($title): BlockExtensibleInterface
    {
        $this->setData(self::TITLE, $title);
        return $this;
    }

    /**
     * @param string $content
     *
     * @return BlockInterface
     */
    public function setContent($content): BlockExtensibleInterface
    {
        $this->setData(self::CONTENT, $content);
        return $this;
    }

    /**
     * @param string $creationTime
     *
     * @return BlockInterface
     */
    public function setCreationTime($creationTime): BlockExtensibleInterface
    {
        $this->setData(self::CREATION_TIME, $creationTime);
        return $this;
    }

    /**
     * @param string $updateTime
     *
     * @return BlockInterface
     */
    public function setUpdateTime($updateTime): BlockExtensibleInterface
    {
        $this->setData(self::UPDATE_TIME, $updateTime);
        return $this;
    }

    /**
     * @param bool|int $isActive
     *
     * @return BlockInterface
     */
    public function setIsActive($isActive): BlockExtensibleInterface
    {
        $this->setData(self::IS_ACTIVE, $isActive);
        return $this;
    }

    /**
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Prevent blocks recursion
     *
     * @return BlockExtensible
     * @throws LocalizedException
     */
    public function beforeSave(): self
    {
        if ($this->hasDataChanges()) {
            $this->setUpdateTime(null);
        }

        $needle = 'block_id="' . $this->getId() . '"';

        if (strstr($this->getContent(), $needle) == false) {
            return parent::beforeSave();
        }

        throw new LocalizedException(
            __('Make sure that static block content does not reference the block itself.')
        );
    }

    /**
     * TODO: Should this be part of interface
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores(): array
    {
        $storeDataByStoresKey = $this->getData('stores');
        $storeDataByStoreIdKey = $this->getData('store_id');

        if (!empty($storeDataByStoresKey)) {
            return is_array($storeDataByStoresKey) ? $storeDataByStoresKey : [$storeDataByStoresKey];
        } elseif (!empty($storeDataByStoreIdKey)) {
            return is_array($storeDataByStoreIdKey) ? $storeDataByStoreIdKey : [$storeDataByStoreIdKey];
        }

        return [];
    }

    /**
     * TODO: Should this be part of interface
     * Prepare block's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * TODO: Unit test
     * @return \Magento\Cms\Api\Data\BlockExtensibleExtensionInterface|null
     */
    public function getExtensionAttributes(): ?BlockExtensibleExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * TODO: Unit test
     * @param BlockExtensibleExtensionInterface $extensionAttributes
     *
     * @return void
     */
    public function setExtensionAttributes(BlockExtensibleExtensionInterface $extensionAttributes): void
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}

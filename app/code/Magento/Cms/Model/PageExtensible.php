<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Cms\Model;

use Magento\Cms\Api\Data\PageExtensibleExtensionInterface;
use Magento\Cms\Api\Data\PageExtensibleInterface;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Helper\Page as PageHelper;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * TODO: Add missing unit tests
 * Class PageExtensible
 * @package Magento\Cms\Model
 */
class PageExtensible extends AbstractExtensibleModel implements PageExtensibleInterface, IdentityInterface
{
    /**
     * @var string
     */
    public const NOROUTE_PAGE_ID = 'no-route';

    /**
     * @var string
     */
    public const CACHE_TAG = 'cms_p';

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
    protected $_eventPrefix = 'cms_page';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Page::class);
    }

    /**
     * PageExtensible constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param ResourceModel\Page $resource
     * @param ResourceModel\Page\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        ScopeConfigInterface $scopeConfig,
        ResourceModel\Page $resource = null,
        ResourceModel\Page\Collection $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );

        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->getData(self::PAGE_ID);
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return (string) $this->getData(self::IDENTIFIER);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (string) $this->getData(self::TITLE);
    }

    /**
     * @return string
     */
    public function getPageLayout(): string
    {
        return (string) $this->getData(self::PAGE_LAYOUT);
    }

    /**
     * @return string
     */
    public function getMetaTitle(): string
    {
        return (string) $this->getData(self::META_TITLE);
    }

    /**
     * @return string
     */
    public function getMetaKeywords(): string
    {
        return (string) $this->getData(self::META_KEYWORDS);
    }

    /**
     * @return string
     */
    public function getMetaDescription(): string
    {
        return (string) $this->getData(self::META_DESCRIPTION);
    }

    /**
     * @return string
     */
    public function getContentHeading(): string
    {
        return (string) $this->getData(self::CONTENT_HEADING);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return (string) $this->getData(self::CONTENT);
    }

    /**
     * @return string
     */
    public function getCreationTime(): string
    {
        return (string) $this->getData(self::CREATION_TIME);
    }

    /**
     * @return string|null
     */
    public function getUpdateTime(): ?string
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * @return string
     */
    public function getSortOrder(): string
    {
        return (string) $this->getData(self::SORT_ORDER);
    }

    /**
     * @return string
     */
    public function getLayoutUpdateXml(): string
    {
        return (string) $this->getData(self::LAYOUT_UPDATE_XML);
    }

    /**
     * @return string
     */
    public function getCustomTheme(): string
    {
        return (string) $this->getData(self::CUSTOM_THEME);
    }

    /**
     * @return string
     */
    public function getCustomRootTemplate(): string
    {
        return (string) $this->getData(self::CUSTOM_ROOT_TEMPLATE);
    }

    /**
     * @return string
     */
    public function getCustomLayoutUpdateXml(): string
    {
        return (string) $this->getData(self::CUSTOM_LAYOUT_UPDATE_XML);
    }

    /**
     * @return string
     */
    public function getCustomThemeFrom(): string
    {
        return (string) $this->getData(self::CUSTOM_THEME_FROM);
    }

    /**
     * @return string
     */
    public function getCustomThemeTo(): string
    {
        return (string) $this->getData(self::CUSTOM_THEME_TO);
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
     *
     * @return PageInterface
     */
    public function setId($id): PageInterface
    {
        $this->setData(self::PAGE_ID, $id);
        return $this;
    }

    /**
     * @param string $identifier
     *
     * @return PageInterface
     */
    public function setIdentifier($identifier): PageInterface
    {
        $this->setData(self::IDENTIFIER, $identifier);
        return $this;
    }

    /**
     * @param string $title
     *
     * @return PageInterface
     */
    public function setTitle($title): PageInterface
    {
        $this->setData(self::TITLE, $title);
        return $this;
    }

    /**
     * @param string $pageLayout
     *
     * @return PageInterface
     */
    public function setPageLayout($pageLayout): PageInterface
    {
        $this->setData(self::PAGE_LAYOUT, $pageLayout);
        return $this;
    }

    /**
     * @param string $metaTitle
     *
     * @return PageInterface
     */
    public function setMetaTitle($metaTitle): PageInterface
    {
        $this->setData(self::META_TITLE, $metaTitle);
        return $this;
    }

    /**
     * @param string $metaKeywords
     *
     * @return PageInterface
     */
    public function setMetaKeywords($metaKeywords): PageInterface
    {
        $this->setData(self::META_KEYWORDS, $metaKeywords);
        return $this;
    }

    /**
     * @param string $metaDescription
     *
     * @return PageInterface
     */
    public function setMetaDescription($metaDescription): PageInterface
    {
        $this->setData(self::META_DESCRIPTION, $metaDescription);
        return $this;
    }

    /**
     * @param string $contentHeading
     *
     * @return PageInterface
     */
    public function setContentHeading($contentHeading): PageInterface
    {
        $this->setData(self::CONTENT_HEADING, $contentHeading);
        return $this;
    }

    /**
     * @param string $content
     *
     * @return PageInterface
     */
    public function setContent($content): PageInterface
    {
        $this->setData(self::CONTENT, $content);
        return $this;
    }

    /**
     * @param string $creationTime
     *
     * @return PageInterface
     */
    public function setCreationTime($creationTime): PageInterface
    {
        $this->setData(self::CREATION_TIME, $creationTime);
        return $this;
    }

    /**
     * @param string|null $updateTime
     *
     * @return PageInterface
     */
    public function setUpdateTime($updateTime): PageInterface
    {
        $this->setData(self::UPDATE_TIME, $updateTime);
        return $this;
    }

    /**
     * @param string $sortOrder
     *
     * @return PageInterface
     */
    public function setSortOrder($sortOrder): PageInterface
    {
        $this->setData(self::SORT_ORDER, $sortOrder);
        return $this;
    }

    /**
     * @param string $layoutUpdateXml
     *
     * @return PageInterface
     */
    public function setLayoutUpdateXml($layoutUpdateXml): PageInterface
    {
        $this->setData(self::LAYOUT_UPDATE_XML, $layoutUpdateXml);
        return $this;
    }

    /**
     * @param string $customTheme
     *
     * @return PageInterface
     */
    public function setCustomTheme($customTheme): PageInterface
    {
        $this->setData(self::CUSTOM_THEME, $customTheme);
        return $this;
    }

    /**
     * @param string $customRootTemplate
     *
     * @return PageInterface
     */
    public function setCustomRootTemplate($customRootTemplate): PageInterface
    {
        $this->setData(self::CUSTOM_ROOT_TEMPLATE, $customRootTemplate);
        return $this;
    }

    /**
     * @param string $customLayoutUpdateXml
     *
     * @return PageInterface
     */
    public function setCustomLayoutUpdateXml($customLayoutUpdateXml): PageInterface
    {
        $this->setData(self::CUSTOM_LAYOUT_UPDATE_XML, $customLayoutUpdateXml);
        return $this;
    }

    /**
     * @param string $customThemeFrom
     *
     * @return PageInterface
     */
    public function setCustomThemeFrom($customThemeFrom): PageInterface
    {
        $this->setData(self::CUSTOM_THEME_FROM, $customThemeFrom);
        return $this;
    }

    /**
     * @param string $customThemeTo
     *
     * @return PageInterface
     */
    public function setCustomThemeTo($customThemeTo): PageInterface
    {
        $this->setData(self::CUSTOM_THEME_TO, $customThemeTo);
        return $this;
    }

    /**
     * @param bool $isActive
     *
     * @return PageInterface
     */
    public function setIsActive($isActive): PageInterface
    {
        $this->setData(self::IS_ACTIVE, $isActive);
        return $this;
    }

    /**
     * @return \Magento\Cms\Api\Data\PageExtensibleExtensionInterface|null
     */
    public function getExtensionAttributes(): ?PageExtensibleExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @param \Magento\Cms\Api\Data\PageExtensibleExtensionInterface $extensionAttributes
     *
     * @return void
     */
    public function setExtensionAttributes(PageExtensibleExtensionInterface $extensionAttributes): void
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * @return PageExtensible
     * @throws LocalizedException
     */
    public function beforeSave(): self
    {
        $originalIdentifier = $this->getOrigData(self::IDENTIFIER);
        $currentIdentifier = $this->getIdentifier();

        if ($this->hasDataChanges()) {
            $this->setUpdateTime(null);
        }

        if (!$this->getId() || $originalIdentifier === $currentIdentifier) {
            return parent::beforeSave();
        }

        switch ($originalIdentifier) {
            case $this->scopeConfig->getValue(PageHelper::XML_PATH_NO_ROUTE_PAGE):
                throw new LocalizedException(
                    __('This identifier is reserved for "CMS No Route Page" in configuration.')
                );
            case $this->scopeConfig->getValue(PageHelper::XML_PATH_HOME_PAGE):
                throw new LocalizedException(__('This identifier is reserved for "CMS Home Page" in configuration.'));
            case $this->scopeConfig->getValue(PageHelper::XML_PATH_NO_COOKIES_PAGE):
                throw new LocalizedException(
                    __('This identifier is reserved for "CMS No Cookies Page" in configuration.')
                );
        }

        return parent::beforeSave();
    }


    /**
     * TODO: Maybe it could be depracted, if other model functions are deprecated?
     * @param int|null $id
     * @param string|null $field
     * @return PageExtensible
     */
    public function load($id, $field = null): self
    {
        if ($id === null) {
            return $this->noRoutePage();
        }

        $this->_resource->load($this, $id, $field);
        return $this;
    }

    /**
     * TODO: Should this be part of interface?
     * @return self
     */
    public function noRoutePage(): self
    {
        return $this->load(self::NOROUTE_PAGE_ID, $this->getIdFieldName());
    }

    /**
     * TODO: Should this be part of interface? Using public function not in available in interface makes us depend on
     * TODO: concrete implementation - maybe this should be marked as depracted and moved to separte service contract?
     * @param string $identifier
     * @param int $storeId
     * @return int
     * @throws LocalizedException
     */
    public function checkIdentifier(string $identifier, int $storeId): int
    {
        return (int) $this->_resource->checkIdentifier($identifier, $storeId);
    }

    /**
     * TODO: Should this be part of interface? Using public function not in available in interface makes us depend on
     * TODO: concrete implementation - maybe this should be marked as depracted and moved to separte service contract?
     * Prepare page's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}

<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\UrlRewrite\Block\Cms\Page;

use Exception;
use Magento\Cms\Api\Data\PageAvailableStatusesProviderInterface;
use Magento\Cms\Block\Adminhtml\Page\Grid as PageGrid;
use Magento\Cms\Model\Page;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;

/**
 * CMS pages grid for URL rewrites
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Grid extends PageGrid
{
    /**
     * Constructor
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setUseAjax(true);
    }

    /**
     * Disable massaction
     *
     * @return $this
     */
    protected function _prepareMassaction()
    {
        return $this;
    }

    /**
     * Prepare columns layout
     *
     * @return $this
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('title', ['header' => __('Title'), 'align' => 'left', 'index' => 'title']);

        $this->addColumn('identifier', ['header' => __('URL Key'), 'align' => 'left', 'index' => 'identifier']);

        if (!$this->_storeManager->isSingleStoreMode()) {
            $this->addColumn(
                'store_id',
                [
                    'header' => __('Store View'),
                    'index' => 'store_id',
                    'type' => 'store',
                    'store_all' => true,
                    'store_view' => true,
                    'sortable' => false,
                    'filter_condition_callback' => [$this, '_filterStoreCondition']
                ]
            );
        }

        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => $this->getAvailableStatuses()
            ]
        );

        return $this;
    }

    /**
     * Get URL for dispatching grid ajax requests
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/*/cmsPageGrid', ['_current' => true]);
    }

    /**
     * Return row url for js event handlers
     *
     * @param Page|DataObject $row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/*/edit', ['cms_page' => $row->getId()]);
    }

    /**
     * Get available statuses
     *
     * @return array
     */
    private function getAvailableStatuses(): array
    {
        $objectManager = ObjectManager::getInstance();
        $pageAvailableStatusesProvider = $objectManager->get(PageAvailableStatusesProviderInterface::class);
        /** @var $pageAvailableStatusesProvider PageAvailableStatusesProviderInterface */
        return $pageAvailableStatusesProvider->get();
    }
}

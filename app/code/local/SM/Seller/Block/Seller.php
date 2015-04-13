<?php
class SM_Seller_Block_Seller extends Mage_Core_Block_Template
{
    /**
     * get number of items display in system config.
     * @return mixed
     */
    protected function getProductsCount()
    {
        return Mage::getStoreConfig('sm_seller_options/basic_config/number_in_slide');
    }

    /**
     * get best seller product collection.
     * @return Varien_Data_Collection|void
     */
    public function getBestsellerProducts()
    {
        if (!Mage::getStoreConfig('sm_seller_options/basic_config/module_enable')) {
            return;
        }
        $storeId = (int) Mage::app()->getStore()->getId();

        // Date
        $date = new Zend_Date();
        $toDate = $date->setDay(1)->getDate()->get('Y-MM-dd');
        $fromDate = $date->subMonth(1)->getDate()->get('Y-MM-dd');

        $collection = Mage::getResourceModel('seller/product_collection')
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->addStoreFilter()
            ->addCategoryFilter(Mage::registry('current_category'))
            ->addPriceData()
            ->addTaxPercents()
            ->addUrlRewrite()
            ->setPageSize($this->getProductsCount())
            ->setCurPage(1);

        $collection->getSelect()
            ->joinLeft(
                array('aggregation' => $collection->getResource()->getTable('sales/bestsellers_aggregated_monthly')),
                "e.entity_id = aggregation.product_id AND aggregation.store_id={$storeId} AND aggregation.period BETWEEN '{$fromDate}' AND '{$toDate}'",
                array('SUM(aggregation.qty_ordered) AS sold_quantity')
            )
            ->group('e.entity_id')
            ->order(array('sold_quantity DESC', 'e.created_at'));
        return $collection;
    }
}
<?php
 class SM_Seller_Model_Resource_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection
 {
     /**
      * override function addCategoryFilter add check in case Mage::registry('current_category') empty
      * @param Mage_Catalog_Model_Category $category
      *
      * @return $this
      */
     public function addCategoryFilterModify($category)
     {
         if (!empty($category)) {
             parent::addCategoryFilter($category);
         }
         return $this;
     }
 }
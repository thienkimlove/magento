<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'is_featured', array(
    'group'    => 'General',
    'label'    => 'Featured Test 1',
    'type'     => 'int',
    'input'    => 'boolean',
    'visible'  => true,
    'required' => false,
    'position' => 21,
    'global'   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
));

$installer->endSetup();
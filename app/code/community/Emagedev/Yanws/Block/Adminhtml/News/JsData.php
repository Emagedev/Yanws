<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 11.06.15
 * Time: 22:15
 */

class Emagedev_Yanws_Block_Adminhtml_News_JsData extends Mage_Adminhtml_Block_Abstract {
    public function getJson() {
        $response = new Varien_Object();

        $response->setUrl(Mage::getBaseUrl());
        $response->setConvertTable(Mage::helper('yanws')->_getTransliterator()->getConvertTable());

        return $response->toJson();
    }
} 
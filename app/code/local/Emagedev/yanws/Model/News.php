<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 2:18
 */

class Emagedev_Yanws_Model_News extends Mage_Core_Model_Abstract {
    public function _construct()
    {
        parent::_construct();
        $this->_init('yanws/news');
    }

    public function dateBeautifier() {
        return date('m/d/Y', $this['timestamp_created']);
    }

    public function afterLoad()
    {
        $this->getResource()->afterLoad($this);
        $this->_afterLoad();
        $this["pretty_date"] = Mage::helper('yanws/prettyDateTime')->parse(new DateTime($this['timestamp_created']));
        return $this;
    }
} 
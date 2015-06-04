<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 11:58
 */

class Emagedev_Yanws_Model_Resource_News_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('yanws/news');
    }

}
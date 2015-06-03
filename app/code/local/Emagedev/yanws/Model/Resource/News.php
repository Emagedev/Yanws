<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 11:57
 */

class Emagedev_Yanws_Model_Resource_News extends Mage_Core_Model_Resource_Db_Abstract
{

    public function _construct()
    {
        $this->_init('yanws/news', 'id');
    }

}
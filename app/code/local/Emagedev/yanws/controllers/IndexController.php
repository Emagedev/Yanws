<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 2:04
 */

class Emagedev_yanws_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        $table = $resource->getTableName('emagedevyanws/news');

        $select = $read->select()
            ->from($table, array('id', 'title', 'article'));

        $news = $read->fetchAll($select);
        Mage::register('news', $news);

        $this->loadLayout();
        $this->renderLayout();
    }
} 
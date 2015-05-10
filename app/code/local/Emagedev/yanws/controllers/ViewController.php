<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 2:04
 */

class Emagedev_Yanws_ViewController extends Mage_Core_Controller_Front_Action {
    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->addItem('skin_css', 'emdev-news.css');
        $this->renderLayout();
    }

}
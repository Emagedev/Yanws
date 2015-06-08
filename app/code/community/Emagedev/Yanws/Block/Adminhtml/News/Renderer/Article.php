<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 05.06.15
 * Time: 15:23
 */
class Emagedev_Yanws_Block_Adminhtml_News_Renderer_Article extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    const MAX_WORDS = 30;
    const MAX_LETTERS = 220;

    public function render(Varien_Object $row)
    {
        $utils = Mage::helper('yanws/articleUtils');

        $value = $utils->plainTextShorter(
            $row->getData($this->getColumn()->getIndex()),
            self::MAX_LETTERS
        );

        $value = strip_tags($value);

        return $value;
    }
} 
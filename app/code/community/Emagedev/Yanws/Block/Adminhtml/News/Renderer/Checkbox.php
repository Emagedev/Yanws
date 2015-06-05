<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 05.06.15
 * Time: 16:06
 */

class Emagedev_Yanws_Block_Adminhtml_News_Renderer_Checkbox extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row)
    {
        $value = !!$row->getData($this->getColumn()->getIndex());

        if($value) {
            $checked = 'checked="checked"';
        } else {
            $checked = '';
        }

        $checkbox = '<input type="checkbox" value="' . $value . '" ' . $checked . ' class="checkbox">';

        return $checkbox;
    }
} 
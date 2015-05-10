<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 15:16
 */

class Emagedev_Yanws_Helper_ArticleUtils extends Mage_Core_Helper_Abstract {
    public function shorter($text, $chars_limit)
    {
        if (strlen($text) > $chars_limit)
        {
            $pos = strpos($text, ' ', 200);
            $new = substr($text, 0, $pos);
            return $new . "...";
        }
        // If not just return the text as is
        else
        {
            return $text;
        }
    }
} 
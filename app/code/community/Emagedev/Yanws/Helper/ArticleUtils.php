<?php


class Emagedev_Yanws_Helper_ArticleUtils extends Mage_Core_Helper_Abstract
{
    const BASE_ROUTE = 'news';
    const BASE_CONTROLLER = 'index';
    const VIEW_ROUTE = 'view';
    const URL_VIEW_PARAMETER = 'page';

    public function makeViewUrl($link)
    {
        $link = urlencode($link);
        return Mage::getUrl(self::BASE_ROUTE . DS . $link);
    }

    public function getUrl()
    {
        return Mage::getUrl(self::BASE_ROUTE . DS);
    }

    public function getShorten($entry, $words, $saveTags = true, $forceTruncate = false, $letters = 500)
    {
        $hasShorten = $entry->hasShortenForm();

        if ($hasShorten) {
            $shorten = $entry->getShortenArticle();
        } else {
            $shorten = $entry->getArticle();
        }

        if (!$saveTags) {
            $this->stripTags($shorten, '<br><br/>', true);
        }

        if ($hasShorten) {
            if ($forceTruncate) {
                $shorten = $this->truncateWords($shorten, $words);
                $shorten = $this->truncateChars($shorten, $letters);
            }
        } else {
            $shorten = $this->truncateWords($shorten, $words);

            if ($forceTruncate) {
                $shorten = $this->truncateChars($shorten, $letters);
            }
        }

        return $shorten;
    }

    public function plainTextShorter($text, $charsLimit)
    {
        if (strlen($text) > $charsLimit) {
            $pos = strpos($text, ' ', 200);
            $new = substr($text, 0, $pos);
            return $new . '...';
        } else {
            return $text;
        }
    }

    // The constants correspond to units of time in seconds
    const MINUTE = 60;
    const HOUR = 3600;
    const DAY = 86400;
    const WEEK = 604800;
    const MONTH = 2628000;
    const YEAR = 31536000;

    /**
     * A helper used by parse() to create the human readable strings. Given a
     * positive difference, corresponding to a date in the past, it appends the
     * word 'ago'. And given a negative difference, corresponding to a date in
     * the future, it prepends the word 'In'. Also makes the unit of time plural
     * if necessary.
     *
     * @param  integer $difference The difference between dates in any unit
     * @param  string $unit The unit of time
     * @return string  The date in human readable format
     */

    private static function prettyFormat($difference, $unit)
    {
        $helper = Mage::helper('yanws');
        // $prepend is added to the start of the string if the supplied
        // difference is greater than 0, and $append if less than
        $prepend = ($difference < 0) ? $helper->__('In ') : '';
        $append = ($difference > 0) ? $helper->__(' ago') : '';
        $difference = floor(abs($difference));
        // If difference is plural, add an 's' to $unit
        if ($difference > 1) {
            $unit = $unit . 's';
        }
        $unit = $helper->__($unit);
        return sprintf('%s%d %s%s', $prepend, $difference, $unit, $append);
    }

    /**
     * Returns a pretty, or human readable string corresponding to the supplied
     * $dateTime. If an optional secondary DateTime object is provided, it is
     * used as the reference - otherwise the current time and date is used.
     *
     * Examples: 'Moments ago', 'Yesterday', 'In 2 years'
     *
     * @param  DateTime $dateTime The DateTime to parse
     * @param  DateTime $reference (Optional) Defaults to the DateTime('now')
     * @return string   The date in human readable format
     */
    public static function prettyDate(\DateTime $dateTime, \DateTime $reference = null)
    {
        $helper = Mage::helper('yanws');
        // If not provided, set $reference to the current DateTime
        if (!$reference) {
            $reference = new \DateTime(NULL, new \DateTimeZone($dateTime->getTimezone()->getName()));
        }
        // Get the difference between the current date and the supplied $dateTime
        $difference = $reference->format('U') - $dateTime->format('U');
        $absDiff = abs($difference);
        // Get the date corresponding to the $dateTime
        $date = $dateTime->format('Y/m/d');
        // Throw exception if the difference is NaN
        if (is_nan($difference)) {
            throw new Exception('The difference between the DateTimes is NaN.');
        }
        // Today
        if ($reference->format('Y/m/d') == $date) {
            if (0 <= $difference && $absDiff < self::MINUTE) {
                return $helper->__('Moments ago');
            } elseif ($difference < 0 && $absDiff < self::MINUTE) {
                return $helper->__('Seconds from now');
            } elseif ($absDiff < self::HOUR) {
                return self::prettyFormat($difference / self::MINUTE, 'minute');
            } else {
                return self::prettyFormat($difference / self::HOUR, 'hour');
            }
        }
        $yesterday = clone $reference;
        $yesterday->modify('- 1 day');
        $tomorrow = clone $reference;
        $tomorrow->modify('+ 1 day');
        if ($yesterday->format('Y/m/d') == $date) {
            return $helper->__('Yesterday');
        } else if ($tomorrow->format('Y/m/d') == $date) {
            return $helper->__('Tomorrow');
        } else if ($absDiff / self::DAY <= 7) {
            return self::prettyFormat($difference / self::DAY, 'day');
        } else if ($absDiff / self::WEEK <= 5) {
            return self::prettyFormat($difference / self::WEEK, 'week');
        } else if ($absDiff / self::MONTH < 12) {
            return self::prettyFormat($difference / self::MONTH, 'month');
        }
        // Over a year ago
        return self::prettyFormat($difference / self::YEAR, 'year');
    }

    /**
     *
     * @author porneL http://pornel.net
     * @license Public Domain
     *
     */

    public static function truncateChars($html, $limit, $ellipsis = '...')
    {

        if ($limit <= 0 || $limit >= strlen(strip_tags($html)))
            return $html;

        $dom = new DOMDocument();
        $dom->loadHTML($html);

        $body = $dom->getElementsByTagName('body')->item(0);

        $it = Mage::getModel('yanws/articleUtils_DOMLettersIterator', $body);

        foreach ($it as $letter) {
            if ($it->key() >= $limit) {
                $currentText = $it->currentTextPosition();
                $currentText[0]->nodeValue = substr($currentText[0]->nodeValue, 0, $currentText[1] + 1);
                self::removeProceedingNodes($currentText[0], $body);
                self::insertEllipsis($currentText[0], $ellipsis);
                break;
            }
        }

        return preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $dom->saveHTML());
    }

    public static function truncateWords($html, $limit, $ellipsis = '...')
    {

        if ($limit <= 0 || $limit >= self::countWords(strip_tags($html)))
            return $html;

        $dom = new DOMDocument();

        // UTF-8 conversion
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

        $body = $dom->getElementsByTagName('body')->item(0);

        $it = Mage::getModel('yanws/articleUtils_DOMWordsIterator', $body);

        foreach ($it as $word) {
            if ($it->key() >= $limit) {
                $currentWordPosition = $it->currentWordPosition();
                $curNode = $currentWordPosition[0];
                $offset = $currentWordPosition[1];
                $words = $currentWordPosition[2];

                $curNode->nodeValue = substr($curNode->nodeValue, 0, $words[$offset][1] + strlen($words[$offset][0]));

                self::removeProceedingNodes($curNode, $body);
                self::insertEllipsis($curNode, $ellipsis);
                break;
            }
        }

        return preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $dom->saveHTML());
    }

    private static function removeProceedingNodes(DOMNode $domNode, DOMNode $topNode)
    {
        $nextNode = $domNode->nextSibling;

        if ($nextNode !== NULL) {
            self::removeProceedingNodes($nextNode, $topNode);
            $domNode->parentNode->removeChild($nextNode);
        } else {
            //scan upwards till we find a sibling
            $curNode = $domNode->parentNode;
            while ($curNode !== $topNode) {
                if ($curNode->nextSibling !== NULL) {
                    $curNode = $curNode->nextSibling;
                    self::removeProceedingNodes($curNode, $topNode);
                    $curNode->parentNode->removeChild($curNode);
                    break;
                }
                $curNode = $curNode->parentNode;
            }
        }
    }

    private static function insertEllipsis(DOMNode $domNode, $ellipsis)
    {
        $avoid = array('a', 'strong', 'em', 'h1', 'h2', 'h3', 'h4', 'h5'); //html tags to avoid appending the ellipsis to

        if (in_array($domNode->parentNode->nodeName, $avoid) && $domNode->parentNode->parentNode !== NULL) {
            // Append as text node to parent instead
            $textNode = new DOMText($ellipsis);

            if ($domNode->parentNode->parentNode->nextSibling)
                $domNode->parentNode->parentNode->insertBefore($textNode, $domNode->parentNode->parentNode->nextSibling);
            else
                $domNode->parentNode->parentNode->appendChild($textNode);
        } else {
            // Append to current node
            $domNode->nodeValue = rtrim($domNode->nodeValue) . $ellipsis;
        }
    }

    private static function countWords($text)
    {
        $words = preg_split("/[\n\r\t ]+/", $text, -1, PREG_SPLIT_NO_EMPTY);
        return count($words);
    }
}
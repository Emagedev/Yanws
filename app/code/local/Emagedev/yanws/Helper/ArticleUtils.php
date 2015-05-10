<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 15:16
 */


class Emagedev_Yanws_Helper_ArticleUtils extends Mage_Core_Helper_Abstract {
    private $viewUrlRoot = '';
    const BASE_ROUTE = 'news/';
    const BASE_CONTROLLER = 'index/';
    const VIEW_ROUTE = 'view/';
    const URL_VIEW_PARAMETER = 'page/';

    protected function _construct() {
        $this->viewUrlRoot = Mage::getUrl('news/index');
    }

    public function makeUrl($link) {
        $request = Mage::app()->getRequest();
        return $this->viewUrlRoot . self::BASE_ROUTE . self::BASE_CONTROLLER .
        self::VIEW_ROUTE . self::URL_VIEW_PARAMETER . $link;
    }

    public function getUrl($link) {
        return $this->viewUrlRoot . self::BASE_ROUTE . $link;
    }

    public function plainTextShorter($text, $charsLimit)
    {
        if (strlen($text) > $charsLimit)
        {
            $pos = strpos($text, ' ', 200);
            $new = substr($text, 0, $pos);
            return $new . '...';
        } else {
            return $text;
        }
    }

    // The constants correspond to units of time in seconds
    const MINUTE = 60;
    const HOUR   = 3600;
    const DAY    = 86400;
    const WEEK   = 604800;
    const MONTH  = 2628000;
    const YEAR   = 31536000;
    /**
     * A helper used by parse() to create the human readable strings. Given a
     * positive difference, corresponding to a date in the past, it appends the
     * word 'ago'. And given a negative difference, corresponding to a date in
     * the future, it prepends the word 'In'. Also makes the unit of time plural
     * if necessary.
     *
     * @param  integer $difference The difference between dates in any unit
     * @param  string  $unit       The unit of time
     * @return string  The date in human readable format
     */
    private static function prettyFormat($difference, $unit)
    {
        // $prepend is added to the start of the string if the supplied
        // difference is greater than 0, and $append if less than
        $prepend = ($difference < 0) ? 'In ' : '';
        $append = ($difference > 0) ? ' ago' : '';
        $difference = floor(abs($difference));
        // If difference is plural, add an 's' to $unit
        if ($difference > 1) {
            $unit = $unit . 's';
        }
        return sprintf('%s%d %s%s', $prepend, $difference, $unit, $append);
    }
    /**
     * Returns a pretty, or human readable string corresponding to the supplied
     * $dateTime. If an optional secondary DateTime object is provided, it is
     * used as the reference - otherwise the current time and date is used.
     *
     * Examples: 'Moments ago', 'Yesterday', 'In 2 years'
     *
     * @param  DateTime $dateTime  The DateTime to parse
     * @param  DateTime $reference (Optional) Defaults to the DateTime('now')
     * @return string   The date in human readable format
     */
    public static function prettyDate(\DateTime $dateTime, \DateTime $reference = null)
    {
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
                return 'Moments ago';
            } elseif ($difference < 0 && $absDiff < self::MINUTE) {
                return 'Seconds from now';
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
            return 'Yesterday';
        } else if ($tomorrow->format('Y/m/d') == $date) {
            return 'Tomorrow';
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

    public static function truncateChars($html, $limit, $ellipsis = '...') {

        if($limit <= 0 || $limit >= strlen(strip_tags($html)))
            return $html;

        $dom = new DOMDocument();
        $dom->loadHTML($html);

        $body = $dom->getElementsByTagName('body')->item(0);

        $it = new DOMLettersIterator($body);

        foreach($it as $letter) {
            if($it->key() >= $limit) {
                $currentText = $it->currentTextPosition();
                $currentText[0]->nodeValue = substr($currentText[0]->nodeValue, 0, $currentText[1] + 1);
                self::removeProceedingNodes($currentText[0], $body);
                self::insertEllipsis($currentText[0], $ellipsis);
                break;
            }
        }

        return preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $dom->saveHTML());
    }

    public static function truncateWords($html, $limit, $ellipsis = '...') {

        if($limit <= 0 || $limit >= self::countWords(strip_tags($html)))
            return $html;

        $dom = new DOMDocument();
        $dom->loadHTML($html);

        $body = $dom->getElementsByTagName('body')->item(0);

        $it = new DOMWordsIterator($body);

        foreach($it as $word) {
            if($it->key() >= $limit) {
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

    private static function removeProceedingNodes(DOMNode $domNode, DOMNode $topNode) {
        $nextNode = $domNode->nextSibling;

        if($nextNode !== NULL) {
            self::removeProceedingNodes($nextNode, $topNode);
            $domNode->parentNode->removeChild($nextNode);
        } else {
            //scan upwards till we find a sibling
            $curNode = $domNode->parentNode;
            while($curNode !== $topNode) {
                if($curNode->nextSibling !== NULL) {
                    $curNode = $curNode->nextSibling;
                    self::removeProceedingNodes($curNode, $topNode);
                    $curNode->parentNode->removeChild($curNode);
                    break;
                }
                $curNode = $curNode->parentNode;
            }
        }
    }

    private static function insertEllipsis(DOMNode $domNode, $ellipsis) {
        $avoid = array('a', 'strong', 'em', 'h1', 'h2', 'h3', 'h4', 'h5'); //html tags to avoid appending the ellipsis to

        if( in_array($domNode->parentNode->nodeName, $avoid) && $domNode->parentNode->parentNode !== NULL) {
            // Append as text node to parent instead
            $textNode = new DOMText($ellipsis);

            if($domNode->parentNode->parentNode->nextSibling)
                $domNode->parentNode->parentNode->insertBefore($textNode, $domNode->parentNode->parentNode->nextSibling);
            else
                $domNode->parentNode->parentNode->appendChild($textNode);
        } else {
            // Append to current node
            $domNode->nodeValue = rtrim($domNode->nodeValue).$ellipsis;
        }
    }

    private static function countWords($text) {
        $words = preg_split("/[\n\r\t ]+/", $text, -1, PREG_SPLIT_NO_EMPTY);
        return count($words);
    }
}

final class DOMWordsIterator implements Iterator {

    private $start, $current;
    private $offset, $key, $words;

    /**
     * expects DOMElement or DOMDocument (see DOMDocument::load and DOMDocument::loadHTML)
     */
    function __construct(DOMNode $el)
    {
        if ($el instanceof DOMDocument) $this->start = $el->documentElement;
        else if ($el instanceof DOMElement) $this->start = $el;
        else throw new InvalidArgumentException("Invalid arguments, expected DOMElement or DOMDocument");
    }

    /**
     * Returns position in text as DOMText node and character offset.
     * (it's NOT a byte offset, you must use mb_substr() or similar to use this offset properly).
     * node may be NULL if iterator has finished.
     *
     * @return array
     */
    function currentWordPosition()
    {
        return array($this->current, $this->offset, $this->words);
    }

    /**
     * Returns DOMElement that is currently being iterated or NULL if iterator has finished.
     *
     * @return DOMElement
     */
    function currentElement()
    {
        return $this->current ? $this->current->parentNode : NULL;
    }

    // Implementation of Iterator interface
    function key()
    {
        return $this->key;
    }

    function next()
    {
        if (!$this->current) return;

        if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE)
        {
            if ($this->offset == -1)
            {
                $this->words = preg_split("/[\n\r\t ]+/", $this->current->textContent, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_OFFSET_CAPTURE);
            }
            $this->offset++;

            if ($this->offset < count($this->words)) {
                $this->key++;
                return;
            }
            $this->offset = -1;
        }

        while($this->current->nodeType == XML_ELEMENT_NODE && $this->current->firstChild)
        {
            $this->current = $this->current->firstChild;
            if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE) return $this->next();
        }

        while(!$this->current->nextSibling && $this->current->parentNode)
        {
            $this->current = $this->current->parentNode;
            if ($this->current === $this->start) {$this->current = NULL; return;}
        }

        $this->current = $this->current->nextSibling;

        return $this->next();
    }

    function current()
    {
        if ($this->current) return $this->words[$this->offset][0];
        return NULL;
    }

    function valid()
    {
        return !!$this->current;
    }

    function rewind()
    {
        $this->offset = -1; $this->words = array();
        $this->current = $this->start;
        $this->next();
    }
}


final class DOMLettersIterator implements Iterator
{
    private $start, $current;
    private $offset, $key, $letters;

    /**
     * expects DOMElement or DOMDocument (see DOMDocument::load and DOMDocument::loadHTML)
     */
    function __construct(DOMNode $el)
    {
        if ($el instanceof DOMDocument) $this->start = $el->documentElement;
        else if ($el instanceof DOMElement) $this->start = $el;
        else throw new InvalidArgumentException("Invalid arguments, expected DOMElement or DOMDocument");
    }

    /**
     * Returns position in text as DOMText node and character offset.
     * (it's NOT a byte offset, you must use mb_substr() or similar to use this offset properly).
     * node may be NULL if iterator has finished.
     *
     * @return array
     */
    function currentTextPosition()
    {
        return array($this->current, $this->offset);
    }

    /**
     * Returns DOMElement that is currently being iterated or NULL if iterator has finished.
     *
     * @return DOMElement
     */
    function currentElement()
    {
        return $this->current ? $this->current->parentNode : NULL;
    }

    // Implementation of Iterator interface
    function key()
    {
        return $this->key;
    }

    function next()
    {
        if (!$this->current) return;

        if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE)
        {
            if ($this->offset == -1)
            {
                // fastest way to get individual Unicode chars and does not require mb_* functions
                preg_match_all('/./us',$this->current->textContent,$m); $this->letters = $m[0];
            }
            $this->offset++; $this->key++;
            if ($this->offset < count($this->letters)) return;
            $this->offset = -1;
        }

        while($this->current->nodeType == XML_ELEMENT_NODE && $this->current->firstChild)
        {
            $this->current = $this->current->firstChild;
            if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE) return $this->next();
        }

        while(!$this->current->nextSibling && $this->current->parentNode)
        {
            $this->current = $this->current->parentNode;
            if ($this->current === $this->start) {$this->current = NULL; return;}
        }

        $this->current = $this->current->nextSibling;

        return $this->next();
    }

    function current()
    {
        if ($this->current) return $this->letters[$this->offset];
        return NULL;
    }

    function valid()
    {
        return !!$this->current;
    }

    function rewind()
    {
        $this->offset = -1; $this->letters = array();
        $this->current = $this->start;
        $this->next();
    }
}
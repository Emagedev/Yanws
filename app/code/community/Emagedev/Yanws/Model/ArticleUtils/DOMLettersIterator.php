<?php

class Emagedev_Yanws_Model_ArticleUtils_DOMLettersIterator implements Iterator
{
    protected $start, $current;
    protected $offset, $key, $parts;

    /**
     * expects DOMElement or DOMDocument (see DOMDocument::load and DOMDocument::loadHTML)
     */
    public function __construct(DOMNode $el)
    {
        if ($el instanceof DOMDocument) {
            $this->start = $el->documentElement;
        } elseif ($el instanceof DOMElement) {
            $this->start = $el;
        } else {
            throw new InvalidArgumentException("Invalid arguments, expected DOMElement or DOMDocument");
        }
    }

    /**
     * Returns position in text as DOMText node and character offset.
     * (it's NOT a byte offset, you must use mb_substr() or similar to use this offset properly).
     * node may be NULL if iterator has finished.
     *
     * @return array
     */
    public function currentPosition()
    {
        return array($this->current, $this->offset);
    }

    /**
     * Returns DOMElement that is currently being iterated or NULL if iterator has finished.
     *
     * @return DOMElement
     */
    public function currentElement()
    {
        return $this->current ? $this->current->parentNode : null;
    }

    // Implementation of Iterator interface
    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        if (!$this->current) {
            return;
        }

        if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE) {
            if ($this->offset == -1) {
                // fastest way to get individual Unicode chars and does not require mb_* functions
                preg_match_all('/./us', $this->current->textContent, $m);
                $this->parts = $m[0];
            }
            $this->offset++;
            $this->key++;
            if ($this->offset < count($this->parts)) {
                return;
            }
            $this->offset = -1;
        }

        $this->goNext();
    }

    protected function goNext()
    {
        while ($this->current->nodeType == XML_ELEMENT_NODE && $this->current->firstChild) {
            $this->current = $this->current->firstChild;
            if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE) {
                $this->next();
                return;
            }
        }

        while (!$this->current->nextSibling && $this->current->parentNode) {
            $this->current = $this->current->parentNode;
            if ($this->current === $this->start) {
                $this->current = null;
                return;
            }
        }

        $this->current = $this->current->nextSibling;

        $this->next();
    }

    public function current()
    {
        if ($this->current) {
            return $this->parts[$this->offset];
        }
        return null;
    }

    public function valid()
    {
        return !!$this->current;
    }

    public function rewind()
    {
        $this->offset = -1;
        $this->parts = array();
        $this->current = $this->start;
        $this->next();
    }
} 
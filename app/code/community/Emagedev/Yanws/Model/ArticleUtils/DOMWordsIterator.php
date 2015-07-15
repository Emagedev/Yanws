<?php

class Emagedev_Yanws_Model_ArticleUtils_DOMWordsIterator
    extends Emagedev_Yanws_Model_ArticleUtils_DOMLettersIterator
{
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

    public function next()
    {
        if (!$this->current) return;

        if ($this->current->nodeType == XML_TEXT_NODE || $this->current->nodeType == XML_CDATA_SECTION_NODE) {
            if ($this->offset == -1) {
                // fastest way to get individual Unicode chars and does not require mb_* functions
                preg_match_all('/./us', $this->current->textContent, $m);
                $this->parts = $m[0];
            }
            $this->offset++;
            $this->key++;
            if ($this->offset < count($this->parts)) return;
            $this->offset = -1;
        }

        $this->goNext();
    }

    public function current()
    {
        if ($this->current) {
            return $this->parts[$this->offset][0];
        }
        return null;
    }
}
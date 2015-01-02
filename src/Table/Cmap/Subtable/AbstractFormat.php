<?php

namespace PhpFont\OpenType\Table\Cmap\Subtable;

abstract class AbstractFormat implements FormatInterface
{
    /**
     * This is the length in bytes of the subtable.
     *
     * @var int
     */
    private $length;

    /**
     * The language field must be set to zero for all cmap subtables whose platform IDs are other than Macintosh
     * (platform ID 1). For cmap subtables whose platform IDs are Macintosh, set this field to the Macintosh language
     * ID of the cmap subtable plus one, or to zero if the cmap subtable is not language-specific. For example, a Mac
     * OS Turkish cmap subtable must set this field to 18, since the Macintosh language ID for Turkish is 17. A Mac OS
     * Roman cmap subtable must set this field to 0, since Mac OS Roman is not a language-specific encoding.
     *
     * @var int
     */
    private $language;

    /**
     * An array that maps character codes to glyph index values.
     *
     * @var int[]
     */
    private $glyphIdArray;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->glyphIdArray = array();
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getGlyphIdArray()
    {
        return $this->glyphIdArray;
    }

    public function setGlyphId($index, $glyphId)
    {
        $this->glyphIdArray[$index] = $glyphId;
    }

    public function setGlyphIdArray($glyphIdArray)
    {
        $this->glyphIdArray = $glyphIdArray;
    }
}

<?php

namespace PhpFont\OpenType\Table;

use DateTime;
use PhpFont\OpenType\StreamInterface;

/**
 * This table gives global information about the font. The bounding box values should be computed using only glyphs
 * that have contours. Glyphs with no contours should be ignored for the purposes of these calculations.
 *
 * http://www.microsoft.com/typography/otspec/head.htm
 */
class HeadTable
{
    const MAGIC_NUMBER = 0x5F0F3CF5;

    /**
     * 0x00010000 for version 1.0.
     *
     * @var float
     */
    private $tableVersionNumber;

    /**
     * Set by font manufacturer.
     *
     * @var float
     */
    private $fontRevision;

    /**
     * To compute: set it to 0, sum the entire font as ULONG, then store 0xB1B0AFBA - sum.
     *
     * @var int
     */
    private $checkSumAdjustment;

    /**
     * Set to 0x5F0F3CF5.
     *
     * @var int
     */
    private $magicNumber;

    /**
     * Bit 0: Baseline for font at y=0;
     * Bit 1: Left sidebearing point at x=0;
     * Bit 2: Instructions may depend on point size;
     * Bit 3: Force ppem to integer values for all internal scaler math; may use fractional ppem sizes if this bit is
     * clear;
     * Bit 4: Instructions may alter advance width (the advance widths might not scale linearly);
     * Bits 5-10: These should be set according to Apple's specification . However, they are not implemented in
     * OpenType.
     * Bit 11: Font data is 'lossless,' as a result of having been compressed and decompressed with the Agfa MicroType
     * Express engine.
     * Bit 12: Font converted (produce compatible metrics)
     * Bit 13: Font optimized for ClearType™. Note, fonts that rely on embedded bitmaps (EBDT) for rendering should
     * not be considered optimized for ClearType, and therefore should keep this bit cleared.
     * Bit 14: Last Resort font. If set, indicates that the glyphs encoded in the cmap subtables are simply generic
     * symbolic representations of code point ranges and don’t truly represent support for those code points. If unset,
     * indicates that the glyphs encoded in the cmap subtables represent proper support for those code points.
     * Bit 15: Reserved, set to 0
     *
     * @var int
     */
    private $flags;

    /**
     * Valid range is from 16 to 16384. This value should be a power of 2 for fonts that have TrueType outlines.
     *
     * @var int
     */
    private $unitsPerEm;

    /**
     * Number of seconds since 12:00 midnight, January 1, 1904. 64-bit integer
     *
     * @var DateTime
     */
    private $created;

    /**
     * Number of seconds since 12:00 midnight, January 1, 1904. 64-bit integer
     *
     * @var DateTime
     */
    private $modified;

    /**
     * For all glyph bounding boxes.
     *
     * @var int
     */
    private $xMin;

    /**
     * For all glyph bounding boxes.
     *
     * @var int
     */
    private $yMin;

    /**
     * For all glyph bounding boxes.
     *
     * @var int
     */
    private $xMax;

    /**
     * For all glyph bounding boxes.
     *
     * @var int
     */
    private $yMax;

    /**
     * Bit 0: Bold (if set to 1);
     * Bit 1: Italic (if set to 1)
     * Bit 2: Underline (if set to 1)
     * Bit 3: Outline (if set to 1)
     * Bit 4: Shadow (if set to 1)
     * Bit 5: Condensed (if set to 1)
     * Bit 6: Extended (if set to 1)
     * Bits 7-15: Reserved (set to 0).
     *
     * @var int
     */
    private $macStyle;

    /**
     * Smallest readable size in pixels.
     *
     * @var int
     */
    private $lowestRecPPEM;

    /**
     * Deprecated (Set to 2).
     * 0: Fully mixed directional glyphs;
     * 1: Only strongly left to right;
     * 2: Like 1 but also contains neutrals;
     * -1: Only strongly right to left;
     * -2: Like -1 but also contains neutrals. 1
     *
     * @var int
     */
    private $fontDirectionHint;

    /**
     * 0 for short offsets, 1 for long.
     *
     * @var int
     */
    private $indexToLocFormat;

    /**
     * 0 for current format.
     *
     * @var int
     */
    private $glyphDataFormat;

    public function getTableVersionNumber()
    {
        return $this->tableVersionNumber;
    }

    public function getFontRevision()
    {
        return $this->fontRevision;
    }

    public function getCheckSumAdjustment()
    {
        return $this->checkSumAdjustment;
    }

    public function getMagicNumber()
    {
        return $this->magicNumber;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function getUnitsPerEm()
    {
        return $this->unitsPerEm;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getModified()
    {
        return $this->modified;
    }

    public function getXMin()
    {
        return $this->xMin;
    }

    public function getYMin()
    {
        return $this->yMin;
    }

    public function getXMax()
    {
        return $this->xMax;
    }

    public function getYMax()
    {
        return $this->yMax;
    }

    public function getMacStyle()
    {
        return $this->macStyle;
    }

    public function getLowestRecPPEM()
    {
        return $this->lowestRecPPEM;
    }

    public function getFontDirectionHint()
    {
        return $this->fontDirectionHint;
    }

    public function getIndexToLocFormat()
    {
        return $this->indexToLocFormat;
    }

    public function getGlyphDataFormat()
    {
        return $this->glyphDataFormat;
    }

    /**
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->tableVersionNumber = $stream->readFixed();
        $this->fontRevision = $stream->readFixed();
        $this->checkSumAdjustment = $stream->readULong();

        $this->magicNumber = $stream->readULong();
        if ($this->magicNumber != self::MAGIC_NUMBER) {
            throw new \Exception(
                sprintf('Magic number for head table should be set to 0x%x but we got 0x%x', self::MAGIC_NUMBER, $this->magicNumber)
            );
        }

        $this->flags = $stream->readUShort();
        $this->unitsPerEm = $stream->readUShort();
        $this->created = $stream->readLongDateTime();
        $this->modified = $stream->readLongDateTime();
        $this->xMin = $stream->readShort();
        $this->yMin = $stream->readShort();
        $this->xMax = $stream->readShort();
        $this->yMax = $stream->readShort();
        $this->macStyle = $stream->readUShort();
        $this->lowestRecPPEM = $stream->readUShort();
        $this->fontDirectionHint = $stream->readShort();
        $this->indexToLocFormat = $stream->readShort();
        $this->glyphDataFormat = $stream->readShort();
    }
}

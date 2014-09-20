<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;

/**
 * This table contains information for horizontal layout.
 *
 * http://www.microsoft.com/typography/otspec/hhea.htm
 */
class HheaTable
{
    /**
     * 0x00010000 for version 1.0.
     *
     * @var float
     */
    private $tableVersionNumber;

    /**
     * Typographic ascent.
     *
     * @var int
     */
    private $ascender;

    /**
     * Typographic descent.
     *
     * @var int
     */
    private $descender;

    /**
     * Typographic line gap. Negative LineGap values are treated as zero in Windows 3.1, System 6, and System 7.
     *
     * @var type
     */
    private $lineGap;

    /**
     * Maximum advance width value in 'hmtx' table.
     *
     * @var int
     */
    private $advanceWidthMax;

    /**
     * Minimum left sidebearing value in 'hmtx' table.
     *
     * @var int
     */
    private $minLeftSideBearing;

    /**
     * Minimum right sidebearing value; calculated as Min(aw - lsb - (xMax - xMin)).
     *
     * @var int
     */
    private $minRightSideBearing;

    /**
     * Max(lsb + (xMax - xMin)).
     *
     * @var int
     */
    private $xMaxExtent;

    /**
     * Used to calculate the slope of the cursor (rise/run); 1 for vertical.
     *
     * @var int
     */
    private $caretSlopeRise;

    /**
     * 0 for vertical.
     *
     * @var int
     */
    private $caretSlopeRun;

    /**
     * The amount by which a slanted highlight on a glyph needs to be shifted to produce the best appearance. Set to
     * 0 for non-slanted fonts
     *
     * @var int
     */
    private $caretOffset;

    /**
     * 0 for current format.
     *
     * @var int
     */
    private $metricDataFormat;

    /**
     * Number of hMetric entries in 'hmtx' table
     *
     * @var int
     */
    private $numberOfHMetrics;

    public function getTableVersionNumber()
    {
        return $this->tableVersionNumber;
    }

    public function getAscender()
    {
        return $this->ascender;
    }

    public function getDescender()
    {
        return $this->descender;
    }

    public function getLineGap()
    {
        return $this->lineGap;
    }

    public function getAdvanceWidthMax()
    {
        return $this->advanceWidthMax;
    }

    public function getMinLeftSideBearing()
    {
        return $this->minLeftSideBearing;
    }

    public function getMinRightSideBearing()
    {
        return $this->minRightSideBearing;
    }

    public function getXMaxExtent()
    {
        return $this->xMaxExtent;
    }

    public function getCaretSlopeRise()
    {
        return $this->caretSlopeRise;
    }

    public function getCaretSlopeRun()
    {
        return $this->caretSlopeRun;
    }

    public function getCaretOffset()
    {
        return $this->caretOffset;
    }

    public function getMetricDataFormat()
    {
        return $this->metricDataFormat;
    }

    public function getNumberOfHMetrics()
    {
        return $this->numberOfHMetrics;
    }

    /**
     * Reads information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->tableVersionNumber = $stream->readFixed();
        $this->ascender = $stream->readFWord();
        $this->descender = $stream->readFWord();
        $this->lineGap = $stream->readFWord();
        $this->advanceWidthMax = $stream->readUFWord();
        $this->minLeftSideBearing = $stream->readFWord();
        $this->minRightSideBearing = $stream->readFWord();
        $this->xMaxExtent = $stream->readFWord();
        $this->caretSlopeRise = $stream->readShort();
        $this->caretSlopeRun = $stream->readShort();
        $this->caretOffset = $stream->readShort();

        // Read reserved values:
        $stream->readShort();
        $stream->readShort();
        $stream->readShort();
        $stream->readShort();

        $this->metricDataFormat = $stream->readShort();
        $this->numberOfHMetrics = $stream->readUShort();
    }

}

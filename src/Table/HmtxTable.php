<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;
use PhpFont\OpenType\Table\Hmtx\LongHorMetric;

/**
 * The type longHorMetric is defined as an array where each element has two parts: the advance width, which is of
 * type USHORT, and the left side bearing, which is of type SHORT. These fields are in font design units.
 *
 * http://www.microsoft.com/typography/otspec/hmtx.htm
 */
class HmtxTable
{
    /**
     * The number of metrics that comes from the hhea table.
     *
     * @var int
     */
    private $numberOfHMetrics;

    /**
     * Paired advance width and left side bearing values for each glyph. The value numOfHMetrics comes from the 'hhea'
     * table. If the font is monospaced, only one entry need be in the array, but that entry is required. The last
     * entry applies to all subsequent glyphs.
     *
     * @var LongHorMetric[]
     */
    private $longHorMetric;

    /**
     * Here the advanceWidth is assumed to be the same as the advanceWidth for the last entry above. The number of
     * entries in this array is derived from numGlyphs (from 'maxp' table) minus numberOfHMetrics. This generally is
     * used with a run of monospaced glyphs (e.g., Kanji fonts or Courier fonts). Only one run is allowed and it must
     * be at the end. This allows a monospaced font to vary the left side bearing values for each glyph.
     *
     * @var int[]
     */
    private $leftSideBearing;

    /**
     * Initializes a new instance of this class.
     *
     * @param int $numberOfHMetrics The number of metrics that comes from the hhea table.
     */
    public function __construct($numberOfHMetrics)
    {
        $this->numberOfHMetrics = $numberOfHMetrics;
    }

    /**
     * Reads information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->longHorMetric = array();
        for ($i = 0; $i < $this->numberOfHMetrics; ++$i) {
            $metric = new LongHorMetric();
            $metric->read($stream);

            $this->longHorMetric[] = $metric;
        }

        $this->leftSideBearing = array();
        for ($i = 0; $i < $this->numberOfHMetrics; ++$i) {
            $this->leftSideBearing[] = $stream->readShort();
        }
    }

}

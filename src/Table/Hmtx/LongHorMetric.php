<?php

namespace PhpFont\OpenType\Table\Hmtx;

use PhpFont\OpenType\StreamInterface;

/**
 * The type longHorMetric is defined as an array where each element has two parts: the advance width, which is of
 * type USHORT, and the left side bearing, which is of type SHORT. These fields are in font design units.
 *
 * http://www.microsoft.com/typography/otspec/hmtx.htm
 */
class LongHorMetric
{
    /**
     * A value in font design units.
     *
     * @var int
     */
    private $advanceWidth;

    /**
     * A value in font design units.
     *
     * @var int
     */
    private $lsb;

    /**
     * Reads information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->advanceWidth = $stream->readUShort();
        $this->lsb = $stream->readShort();
    }
}

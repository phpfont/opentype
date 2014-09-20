<?php

namespace PhpFont\OpenType\Table\Vdmx;

use PhpFont\OpenType\StreamInterface;

class RatioRecord
{
    /**
     * Character set.
     *
     * @var int
     */
    private $bCharSet;

    /**
     * Value to use for x-Ratio
     *
     * @var int
     */
    private $xRatio;

    /**
     * Starting y-Ratio value.
     *
     * @var int
     */
    private $yStartRatio;

    /**
     * Ending y-Ratio value.
     *
     * @var int
     */
    private $yEndRatio;

    /**
     * Reads the information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->bCharSet = $stream->readByte();
        $this->xRatio = $stream->readByte();
        $this->yStartRatio = $stream->readByte();
        $this->yEndRatio = $stream->readByte();
    }
}

<?php

namespace PhpFont\OpenType\Table\Vdmx;

use PhpFont\OpenType\StreamInterface;

class VTableRecord
{
    /**
     * yPelHeight to which values apply.
     *
     * @var int
     */
    private $yPelHeight;

    /**
     * Maximum value (in pels) for this yPelHeight.
     *
     * @var int
     */
    private $yMax;

    /**
     * Minimum value (in pels) for this yPelHeight.
     *
     * @var int
     */
    private $yMin;

    /**
     * Reads the information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->yPelHeight = $stream->readUShort();
        $this->yMax = $stream->readShort();
        $this->yMin = $stream->readShort();
    }
}

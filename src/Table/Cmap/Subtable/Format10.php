<?php

namespace PhpFont\OpenType\Table\Cmap\Subtable;

use PhpFont\OpenType\StreamInterface;
use RuntimeException;

class Format10 extends AbstractFormat
{
    /**
     * Reads the data from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        throw new RuntimeException(sprintf('CMAP format %d is not supported yet.', $this->getFormat()));
    }

    /**
     * Gets the format number.
     *
     * @return int
     */
    public function getFormat()
    {
        return 10;
    }
}

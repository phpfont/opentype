<?php

namespace PhpFont\OpenType\Table\Cmap\Subtable;

use PhpFont\OpenType\StreamInterface;

class Format0 extends AbstractFormat
{
    /**
     * Reads the data from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        // Read the format number...
        $stream->readUShort();

        $this->setLength($stream->readUShort());
        $this->setLanguage($stream->readUShort());

        for ($i = 0; $i < 256; ++$i) {
            $this->setGlyphId($i, $stream->readByte());
        }
    }

    /**
     * Gets the format number.
     *
     * @return int
     */
    public function getFormat()
    {
        return 0;
    }
}

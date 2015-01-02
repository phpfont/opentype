<?php

namespace PhpFont\OpenType\Table\Cmap\Subtable;

use PhpFont\OpenType\StreamInterface;

class Format6 extends \PhpFont\OpenType\Table\Cmap\Subtable\AbstractFormat
{
    /**
     * First character code of subrange.
     *
     * @var int
     */
    private $firstCode;

    /**
     * Number of character codes in subrange.
     *
     * @var int
     */
    private $entryCount;

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

        $this->setFirstCode($stream->readUShort());
        $this->setEntryCount($stream->readUShort());

        for ($i = 0; $i < $this->getEntryCount(); ++$i) {
            $this->setGlyphId($i, $stream->readUShort());
        }
    }

    /**
     * Gets the format number.
     *
     * @return int
     */
    public function getFormat()
    {
        return 6;
    }

    public function getFirstCode()
    {
        return $this->firstCode;
    }

    public function setFirstCode($firstCode)
    {
        $this->firstCode = $firstCode;
    }

    public function getEntryCount()
    {
        return $this->entryCount;
    }

    public function setEntryCount($entryCount)
    {
        $this->entryCount = $entryCount;
    }
}

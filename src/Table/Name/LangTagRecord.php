<?php

namespace PhpFont\OpenType\Table\Name;

use PhpFont\OpenType\StreamInterface;

/**
 * An entry in the language table.
 *
 * http://www.microsoft.com/typography/otspec/name.htm
 */
class LangTagRecord
{
    /**
     * Language-tag string length (in bytes)
     *
     * @var int
     */
    private $length;

    /**
     * Language-tag string offset from start of storage area (in bytes).
     *
     * @var int
     */
    private $offset;

    /**
     * Reads information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->length = $stream->readUShort();
        $this->offset = $stream->readUShort();
    }
}

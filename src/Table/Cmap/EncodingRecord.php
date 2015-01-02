<?php

namespace PhpFont\OpenType\Table\Cmap;

use PhpFont\OpenType\StreamInterface;

/**
 * Encoding record that specify the particular encoding and the offset to the subtable for that encoding.
 *
 * For more information visit http://www.microsoft.com/typography/otspec/cmap.htm
 */
class EncodingRecord
{
    /**
     * The platform id of this record.
     *
     * @var int
     */
    private $platformID;

    /**
     * The encoding id of this record.
     *
     * @var int
     */
    private $encodingID;

    /**
     * The byte offset from beginning of table to the subtable for this encoding.
     *
     * @var int
     */
    private $offset;

    /**
     * Reads the data from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->platformID = $stream->readUShort();
        $this->encodingID = $stream->readUShort();
        $this->offset = $stream->readULong();
    }

    /**
     * Gets the platform id of this encoding record.
     *
     * @return int
     */
    public function getPlatformID()
    {
        return $this->platformID;
    }

    /**
     * Gets the platform specifig encoding id of this encoding record.
     *
     * @return int
     */
    public function getEncodingID()
    {
        return $this->encodingID;
    }

    /**
     * Gets the byte offset from the beginning of table to the subtable for this encoding.
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }
}

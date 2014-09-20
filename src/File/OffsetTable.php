<?php

namespace PhpFont\OpenType\File;

use PhpFont\OpenType\StreamInterface;

class OffsetTable
{
    /**
     * A four byte identifier.
     *
     * @var int
     */
    private $tag;

    /**
     * The checksum of this table.
     *
     * @var int
     */
    private $checksum;

    /**
     * The offset of the table from the beginning of this file.
     *
     * @var int
     */
    private $offset;

    /**
     * The length of the table.
     *
     * @var int
     */
    private $length;

    /**
     * Gets the tag of this table.
     *
     * @return int
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Gets the tag as a string.
     *
     * @return string
     */
    public function getTagName()
    {
        $b1 = $this->tag >> 24;
        $b2 = $this->tag >> 16;
        $b3 = $this->tag >> 8;
        $b4 = $this->tag;

        return chr($b1) . chr($b2) . chr($b3) . chr($b4);
    }

    /**
     * Gets the checksum of the table.
     *
     * @return int
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * Gets the offset of the table.
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Gets the length of the table.
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Reads the offset table from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->tag = $stream->readULong();
        $this->checksum = $stream->readULong();
        $this->offset = $stream->readULong();
        $this->length = $stream->readULong();

        $size = $stream->getSize();

        if ($this->offset < 0 || $this->offset > $size) {
            throw new \Exception('Table offset (' . $this->offset . ') not within expected range');
        }

        if ($this->length < 0 || ($this->offset + $this->length) > $size) {
            throw new \Exception('Table length (' . $this->length . ') not within expected range');
        }
    }

}

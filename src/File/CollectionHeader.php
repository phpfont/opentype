<?php

namespace PhpFont\OpenType\File;

use PhpFont\OpenType\StreamInterface;

/**
 * An OpenType font collection file header.
 */
class CollectionHeader
{
    const TTCF_ID = 0x74746366;

    /**
     * TrueType Collection ID string: 'ttcf'
     *
     * @var int
     */
    private $tag;

    /**
     * Version of the TTC Header (1.0), 0x00010000
     *
     * @var float
     */
    private $version;

    /**
     * Number of fonts in TTC
     *
     * @var int
     */
    private $numFonts;

    /**
     * Array of offsets to the OffsetTable for each font from the beginning of the file
     *
     * @var int[]
     */
    private $offsetTable;

    /**
     * Tag indicating that a DSIG table exists, 0x44534947 ('DSIG') (null if no signature)
     *
     * @var int
     */
    private $ulDsigTag;

    /**
     * The length (in bytes) of the DSIG table (null if no signature)
     *
     * @var int
     */
    private $ulDsigLength;

    /**
     * The offset (in bytes) of the DSIG table from the beginning of the TTC file (null if no signature)
     *
     * @var int
     */
    private $ulDsigOffset;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->offsetTable = array();
    }

    /**
     * Gets the tag of the header.
     *
     * @return int
     */
    private function getTag()
    {
        return $this->tag;
    }

    /**
     * Gets the version of the header.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Gets the amount of fonts.
     *
     * @return int
     */
    public function getNumFonts()
    {
        return $this->numFonts;
    }

    /**
     * Gets the offsets to the tables.
     *
     * @return int[]
     */
    public function getOffsetTable()
    {
        return $this->offsetTable;
    }

    /**
     * Gets the tag that indicates that a DSIG table exists.
     *
     * @return int
     */
    public function getUlDsigTag()
    {
        return $this->ulDsigTag;
    }

    /**
     * Gets the length of the DSIG table.
     *
     * @return int
     */
    public function getUlDsigLength()
    {
        return $this->ulDsigLength;
    }

    /**
     * Gets the offset of the DSIG table.
     *
     * @return int
     */
    public function getUlDsigOffset()
    {
        return $this->ulDsigOffset;
    }

    /**
     * Reads the header from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->tag = $stream->readTag();
        if ($this->tag !== self::TTCF_ID) {
            throw new RuntimeException(sprintf(
                'Invalid id provided, should be 0x%x but we got 0x%x',
                self::TTCF_ID,
                $this->tag
            ));
        }

        $this->version = $stream->readFixed();
        $this->numFonts = $stream->readULong();

        for ($i = 0; $i < $this->numFonts; ++$i) {
            $this->offsetTable[] = $stream->readULong();
        }

        if ($this->version > 1) {
            $this->ulDsigTag = $stream->readULong();
            $this->ulDsigLength = $stream->readULong();
            $this->ulDsigOffset = $stream->readULong();
        }
    }

}

<?php

namespace PhpFont\OpenType\File;

use PhpFont\OpenType\StreamInterface;

/**
 * An OpenType font file header.
 */
class Header
{
    /**
     * A unsigned int (32-bits) value describing the type of file.
     *
     * The value can be:
     * 0x00010000 - Windows TrueType signature
     * 0x4f54544f - CFF data (OTTO)
     * 0x74727565 - Macintosh TrueType signature (true)
     * 0x74797031 - Macintosh TrueType signature typ1
     *
     * @var float
     */
    private $sfntVersion;

    /**
     * A 16-bits unsigned integer describing the amount of tables that are present in the file.
     *
     * @var int
     */
    private $numTables;

    /**
     * A 16-bits unsigned integer.
     * (Maximum power of 2 <= numTables) x 16
     *
     * @var int
     */
    private $searchRange;

    /**
     * A 16-bits unsigned integer.
     * Log2(maximum power of 2 <= numTables).
     *
     * @var int
     */
    private $entrySelector;

    /**
     * A 16-bits unsigned integer.
     * NumTables x 16-searchRange.
     *
     * @var int
     */
    private $rangeShift;

    /**
     * Gets the version number of this file header.
     *
     * @return float
     */
    public function getSfntVersion()
    {
        return $this->sfntVersion;
    }

    /**
     * Gets the amount of tables that exist.
     *
     * @return int
     */
    public function getNumTables()
    {
        return $this->numTables;
    }

    /**
     * Gets the search range.
     *
     * @return int
     */
    public function getSearchRange()
    {
        return $this->searchRange;
    }

    /**
     * Gets the entry selector.
     *
     * @return int
     */
    public function getEntrySelector()
    {
        return $this->entrySelector;
    }

    /**
     * Gets the range shift.
     *
     * @return int
     */
    public function getRangeShift()
    {
        return $this->rangeShift;
    }

    /**
     * Reads the header from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->sfntVersion = $stream->readFixed();
        $this->numTables = $stream->readUShort();
        $this->searchRange = $stream->readUShort();
        $this->entrySelector = $stream->readUShort();
        $this->rangeShift = $stream->readUShort();
    }
}

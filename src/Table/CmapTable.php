<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;
use PhpFont\OpenType\Table\Cmap\EncodingRecord;
use PhpFont\OpenType\Table\Cmap\Subtable\AbstractFormat;
use PhpFont\OpenType\Table\Cmap\Subtable\Format0;
use PhpFont\OpenType\Table\Cmap\Subtable\Format12;
use PhpFont\OpenType\Table\Cmap\Subtable\Format14;
use PhpFont\OpenType\Table\Cmap\Subtable\Format2;
use PhpFont\OpenType\Table\Cmap\Subtable\Format4;
use PhpFont\OpenType\Table\Cmap\Subtable\Format6;
use RuntimeException;

/**
 * This table defines the mapping of character codes to the glyph index values used in the font. It may contain more
 * than one subtable, in order to support more than one character encoding scheme. Character codes that do not
 * correspond to any glyph in the font should be mapped to glyph index 0. The glyph at this location must be a special
 * glyph representing a missing character, commonly known as .notdef.
 *
 * For more information visit http://www.microsoft.com/typography/otspec/cmap.htm
 */
class CmapTable
{
    private $baseOffset;
    private $version;
    private $numTables;
    private $encodingRecords;
    private $subTables;

    /**
     * Initiializes a new instance of this class.
     *
     * @param int $baseOffset The base offset used to read names.
     */
    public function __construct($baseOffset)
    {
        $this->baseOffset = $baseOffset;
        $this->encodingRecords = array();
        $this->subTables = array();
    }

    /**
     * Gets the base offset used to read the subtables.
     *
     * @return int
     */
    public function getBaseOffset()
    {
        return $this->baseOffset;
    }

    /**
     * Sets the base offset that is used to read the subtables.
     *
     * @param int $baseOffset The value to set.
     */
    public function setBaseOffset($baseOffset)
    {
        $this->baseOffset = $baseOffset;
    }

    /**
     * Gets the version of this table.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Sets the version of this table.
     *
     * @param int $version The value to set.
     */
    public function setVersion($version)
    {
        $this->version = $version;
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
     * Sets the amount of tables that exist.
     *
     * @param int $numTables The value to set.
     */
    public function setNumTables($numTables)
    {
        $this->numTables = $numTables;
    }

    /**
     * Gets a list with encoding records.
     *
     * @return EncodingRecord[]
     */
    public function getEncodingRecords()
    {
        return $this->encodingRecords;
    }

    /**
     * Gets the subtables of this table.
     *
     * @return AbstractFormat
     */
    public function getSubTables()
    {
        return $this->subTables;
    }

    /**
     * Reads the CMAP table from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->version = $stream->readUShort();
        $this->numTables = $stream->readUShort();

        $this->readEncodingRecords($stream);
        $this->readSubtables($stream);
    }

    private function readEncodingRecords(StreamInterface $stream)
    {
        for ($i = 0; $i < $this->numTables; ++$i) {
            $encodingRecord = new EncodingRecord();
            $encodingRecord->read($stream);

            $this->encodingRecords[] = $encodingRecord;
        }
    }

    private function readSubtables(StreamInterface $stream)
    {
        foreach ($this->getEncodingRecords() as $encodingRecord) {
            $stream->setPosition($this->getBaseOffset() + $encodingRecord->getOffset());

            $format = $stream->readUShort();
            $stream->setPosition($this->getBaseOffset() + $encodingRecord->getOffset());

            $subTable = $this->getSubTable($format);
            $subTable->read($stream);

            $this->subTables[] = $subTable;
        }
    }

    private function getSubTable($format)
    {
        switch ($format) {
            case 0:
                $subTable = new Format0();
                break;

            case 2:
                $subTable = new Format2();
                break;

            case 4:
                $subTable = new Format4();
                break;

            case 6:
                $subTable = new Format6();
                break;

            case 12:
                $subTable = new Format12();
                break;

            case 14:
                $subTable = new Format14();
                break;

            default:
                throw new RuntimeException('Subtable format ' . $format . ' is not supported.');
        }

        return $subTable;
    }
}

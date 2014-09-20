<?php

namespace PhpFont\OpenType\Table;

use PhpFont\Binary\StreamInterface as BinaryStreamInterface;
use PhpFont\OpenType\Table\Name\LangTagRecord;
use PhpFont\OpenType\Table\Name\NameRecord;
use PhpFont\OpenType\StreamInterface;

/**
 * The naming table allows multilingual strings to be associated with the OpenType™ font file.
 *
 * http://www.microsoft.com/typography/otspec/name.htm
 */
class NameTable
{
    /**
     * The base offset used to read the names.
     *
     * @var int
     */
    private $baseOffset;

    /**
     * Format selector (=0).
     *
     * @var int
     */
    private $format;

    /**
     * Number of name records.
     *
     * @var int
     */
    private $count;

    /**
     * Offset to start of string storage (from start of table).
     *
     * @var int
     */
    private $stringOffset;

    /**
     * The name records where count is the number of records.
     *
     * @var NameRecord[]
     */
    private $nameRecord;

    /**
     * The string names.
     *
     * @var string[]
     */
    private $names;

    /**
     * Number of language-tag records.
     *
     * @var int
     */
    private $langTagCount;

    /**
     * The language-tag records where langTagCount is the number of records.
     *
     * @var LangTagRecord[]
     */
    private $langTagRecord;

    /**
     * Initiializes a new instance of this class.
     *
     * @param int $baseOffset The base offset used to read names.
     */
    public function __construct($baseOffset)
    {
        $this->baseOffset = $baseOffset;
        $this->names = array();
    }

    /**
     * Reads information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->format = $stream->readUShort();
        $this->count = $stream->readUShort();
        $this->stringOffset = $stream->readUShort();
        $this->nameRecord = $this->readNameTable($stream);

        if ($this->format == 1) {
            $this->langTagCount = $stream->readUShort();
            $this->langTagRecord = $this->readLangRecords();
        }

        $this->readNames($stream);
    }

    /**
     * Reads the records from the name table.
     *
     * @param StreamInterface $stream The stream to read from.
     * @return NameRecord[]
     */
    private function readNameTable(StreamInterface $stream)
    {
        $records = array();

        for ($i = 0; $i < $this->count; ++$i) {
            $record = new NameRecord($this);
            $record->read($stream);

            $records[] = $record;
        }

        return $records;
    }

    /**
     * Reads all the names from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     * @return string[]
     */
    private function readNames(StreamInterface $stream)
    {
        $names = array();

        foreach ($this->nameRecord as $record) {
            // When there is no language code, we can't read the record name:
            if ($record->getLanguageCode() === null) {
                return;
            }

            $stringOffset = $this->baseOffset + $this->stringOffset + $record->getOffset();

            $stream->setPosition($stringOffset);

            if ($record->getPlatformID() == 3) {
                $name = $stream->readStringBytes($record->getLength(), 'UTF-16BE', 'UTF-8');
            } else {
                $name = $stream->readStringBytes($record->getLength(), 'MacRoman', 'UTF-8');
            }

            $names[$record->getLanguageCode()][$record->getNameID()] = $name;
        }

        return $names;
    }

    /**
     * Reads all the language records.
     *
     * @param StreamInterface $stream The stream to read from.
     * @return LangTagRecord[]
     */
    private function readLangRecords(StreamInterface $stream)
    {
        $records = array();

        for ($i = 0; $i < $this->langTagCount; ++$i) {
            $record = new LangTagRecord();
            $record->read($stream);

            $records[] = $record;
        }

        return $records;
    }

}

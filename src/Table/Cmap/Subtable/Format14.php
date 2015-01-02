<?php

namespace PhpFont\OpenType\Table\Cmap\Subtable;

use PhpFont\OpenType\StreamInterface;
use PhpFont\OpenType\Table\Cmap\Subtable\Format14\VarSelectorRecord;
use RuntimeException;

class Format14 implements FormatInterface
{
    private $length;
    private $numVarSelectorRecords;
    private $varSelectorRecords;

    public function __construct()
    {
        $this->varSelectorRecords = array();
    }

    /**
     * Reads the data from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        // Read the format number...
        $stream->readUShort();

        $this->setLength($stream->readULong());
        $this->setNumVarSelectorRecords($stream->readULong());

        for ($i = 0; $i < $this->getNumVarSelectorRecords(); ++$i) {
            $record = new VarSelectorRecord();
            $record->read($stream);

            $this->varSelectorRecords[] = $record;
        }

        // TODO: Continue parsing this format.

        throw new RuntimeException(sprintf('CMAP format %d is not supported yet.', $this->getFormat()));
    }

    /**
     * Gets the format number.
     *
     * @return int
     */
    public function getFormat()
    {
        return 14;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getNumVarSelectorRecords()
    {
        return $this->numVarSelectorRecords;
    }

    public function setNumVarSelectorRecords($numVarSelectorRecords)
    {
        $this->numVarSelectorRecords = $numVarSelectorRecords;
    }
}

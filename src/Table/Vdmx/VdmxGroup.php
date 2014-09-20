<?php

namespace PhpFont\OpenType\Table\Vdmx;

use PhpFont\OpenType\StreamInterface;

class VdmxGroup
{
    /**
     * Number of height records in this group
     *
     * @var int
     */
    private $recs;

    /**
     * Starting yPelHeight
     *
     * @var int
     */
    private $startsz;

    /**
     * Ending yPelHeight
     *
     * @var int
     */
    private $endsz;

    /**
     * The VDMX records
     *
     * @var VTableRecord[]
     */
    private $entry;

    /**
     * Reads the information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->recs = $stream->readUShort();
        $this->startsz = $stream->readByte();
        $this->endsz = $stream->readByte();

        $this->entry = array();
        for ($i = 0; $i < $this->recs; ++$i) {
            $record = new VTableRecord();
            $record->read($stream);

            $this->entry[] = $record;
        }
    }
}

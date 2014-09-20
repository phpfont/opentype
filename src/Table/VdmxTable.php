<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;
use PhpFont\OpenType\Table\Vdmx\RatioRecord;
use PhpFont\OpenType\Table\Vdmx\VdmxGroup;

/**
 * The VDMX table relates to OpenType™ fonts with TrueType outlines.
 *
 * For more information visit http://www.microsoft.com/typography/otspec/vdmx.htm
 */
class VdmxTable
{
    /**
     * Version number (starts at 0).
     *
     * @var int
     */
    private $version;

    /**
     * The number of VDMX groups present.
     *
     * @var int
     */
    private $numRecs;

    /**
     * The number of VDMX groups present.
     *
     * @var int
     */
    private $numRatios;

    /**
     * Ratio ranges (see below for more info)
     *
     * @var type
     */
    private $ratRange;

    /**
     * Offset from start of this table to the VDMX group for this ratio range.
     *
     * @var int
     */
    private $offset;

    /**
     * The actual VDMX groupings.
     *
     * @var type
     */
    private $groups;

    /**
     * Reads the table from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->version = $stream->readUShort();
        $this->numRecs = $stream->readUShort();
        $this->numRatios = $stream->readUShort();

        $this->ratRange = array();
        for ($i = 0; $i < $this->numRatios; ++$i) {
            $record = new RatioRecord();
            $record->read($stream);

            $this->ratRange[] = $record;
        }

        $this->offset = array();
        for ($i = 0; $i < $this->numRatios; ++$i) {
            $this->offset[] = $stream->readUShort();
        }

        $this->groups = array();
        for ($i = 0; $i < $this->numRecs; ++$i) {
            $group = new VdmxGroup();
            $group->read($stream);

            $this->groups[] = $group;
        }
    }

}

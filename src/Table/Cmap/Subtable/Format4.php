<?php

namespace PhpFont\OpenType\Table\Cmap\Subtable;

use PhpFont\OpenType\StreamInterface;

class Format4 extends AbstractFormat
{
    private $segCountX2;
    private $searchRange;
    private $entrySelector;
    private $rangeShift;
    private $endCount;
    private $reservedPad;
    private $startCount;
    private $idDelta;
    private $idRangeOffset;

    public function __construct()
    {
        parent::__construct();

        $this->endCount = array();
        $this->startCount = array();
        $this->idDelta = array();
        $this->idRangeOffset = array();
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

        $this->setLength($stream->readUShort());
        $this->setLanguage($stream->readUShort());
        $this->setSegCountX2($stream->readUShort());
        $this->setSearchRange($stream->readUShort());
        $this->setEntrySelector($stream->readUShort());
        $this->setRangeShift($stream->readUShort());

        $offset = 14;

        for ($i = 0; $i < $this->segCountX2 / 2; ++$i, $offset += 2) {
            $this->setEndCount($i, $stream->readUShort());
        }

        $this->setReservedPad($stream->readUShort());
        $offset += 2;

        for ($i = 0; $i < $this->segCountX2 / 2; ++$i, $offset += 2) {
            $this->setStartCount($i, $stream->readUShort());
        }

        for ($i = 0; $i < $this->segCountX2 / 2; ++$i, $offset += 2) {
            $this->setIdDelta($i, $stream->readShort());
        }

        for ($i = 0; $i < $this->segCountX2 / 2; ++$i, $offset += 2) {
            $this->setIdRangeOffset($i, $stream->readUShort());
        }

        for ($index = 0; $offset < $this->getLength(); $index++, $offset += 2) {
            $this->setGlyphId($index, $stream->readUShort());
        }
    }

    /**
     * Gets the format number.
     *
     * @return int
     */
    public function getFormat()
    {
        return 4;
    }

    public function getSegCountX2()
    {
        return $this->segCountX2;
    }

    public function setSegCountX2($segCountX2)
    {
        $this->segCountX2 = $segCountX2;
    }

    public function getSearchRange()
    {
        return $this->searchRange;
    }

    public function setSearchRange($searchRange)
    {
        $this->searchRange = $searchRange;
    }

    public function getEntrySelector()
    {
        return $this->entrySelector;
    }

    public function setEntrySelector($entrySelector)
    {
        $this->entrySelector = $entrySelector;
    }

    public function getRangeShift()
    {
        return $this->rangeShift;
    }

    public function setRangeShift($rangeShift)
    {
        $this->rangeShift = $rangeShift;
    }

    public function getEndCount()
    {
        return $this->endCount;
    }

    public function setEndCount($index, $endCount)
    {
        $this->endCount[$index] = $endCount;
    }

    public function getReservedPad()
    {
        return $this->reservedPad;
    }

    public function setReservedPad($reservedPad)
    {
        $this->reservedPad = $reservedPad;
    }

    public function getStartCount()
    {
        return $this->startCount;
    }

    public function setStartCount($index, $startCount)
    {
        $this->startCount[$index] = $startCount;
    }

    public function getIdDelta()
    {
        return $this->idDelta;
    }

    public function setIdDelta($index, $idDelta)
    {
        $this->idDelta[$index] = $idDelta;
    }

    public function getIdRangeOffset()
    {
        return $this->idRangeOffset;
    }

    public function setIdRangeOffset($index, $idRangeOffset)
    {
        $this->idRangeOffset[$index] = $idRangeOffset;
    }

    /**
     * Gets a list with all covered character codes.
     *
     * @return int[]
     */
    public function getCoveredCharacters()
    {
        $characterCodes = array();
        for ($i = 0; $i < $this->segCountX2 / 2; $i++) {
            for ($code = $this->startCount[$i]; $code <= $this->endCount[$i]; $code++) {
                $characterCodes[] = $code;
            }
        }
        return $characterCodes;
    }
}

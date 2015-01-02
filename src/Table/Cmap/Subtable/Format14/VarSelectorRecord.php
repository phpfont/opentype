<?php

namespace PhpFont\OpenType\Table\Cmap\Subtable\Format14;

use PhpFont\OpenType\StreamInterface;

class VarSelectorRecord
{
    private $varSelector;
    private $defaultUVSOffset;
    private $nonDefaultUVSOffset;

    /**
     * Reads the data from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->setVarSelector($stream->readUInt24());
        $this->setDefaultUVSOffset($stream->readULong());
        $this->setNonDefaultUVSOffset($stream->readULong());
    }

    public function getVarSelector()
    {
        return $this->varSelector;
    }

    public function setVarSelector($varSelector)
    {
        $this->varSelector = $varSelector;
    }

    public function getDefaultUVSOffset()
    {
        return $this->defaultUVSOffset;
    }

    public function setDefaultUVSOffset($defaultUVSOffset)
    {
        $this->defaultUVSOffset = $defaultUVSOffset;
    }

    public function getNonDefaultUVSOffset()
    {
        return $this->nonDefaultUVSOffset;
    }

    public function setNonDefaultUVSOffset($nonDefaultUVSOffset)
    {
        $this->nonDefaultUVSOffset = $nonDefaultUVSOffset;
    }
}

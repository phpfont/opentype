<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;

/**
 * The LTSH table relates to OpenType™ fonts containing TrueType outlines.
 *
 * For more information visit http://www.microsoft.com/typography/otspec/ltsh.htm
 */
class LtshTable
{
    /**
     * Version number (starts at 0).
     *
     * @var int
     */
    private $version;

    /**
     * Number of glyphs (from “numGlyphs” in 'maxp' table).
     *
     * @var int
     */
    private $numGlyphs;

    /**
     * The vertical pel height at which the glyph can be assumed to scale linearly. On a per glyph basis.
     *
     * @var array
     */
    private $yPels;

    /**
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->version = $stream->readUShort();
        $this->numGlyphs = $stream->readUShort();

        $this->yPels = array();
        for ($i = 0; $i < $this->numGlyphs; ++$i) {
            $this->yPels[] = $stream->readChar();
        }
    }

}

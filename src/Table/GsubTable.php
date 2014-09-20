<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;

/**
 * The Glyph Substitution table (GSUB) contains information for substituting glyphs to render the scripts and language
 * systems supported in a font.
 *
 * For more information visit http://www.microsoft.com/typography/otspec/gsub.htm
 */
class GsubTable
{
    /**
     * Version of the GSUB table-initially set to 0x00010000
     *
     * @var float
     */
    private $version;

    /**
     * Offset to ScriptList table-from beginning of GSUB table
     *
     * @var int
     */
    private $scriptList;

    /**
     * Offset to FeatureList table-from beginning of GSUB table
     *
     * @var int
     */
    private $featureList;

    /**
     * Offset to LookupList table-from beginning of GSUB table
     *
     * @var int
     */
    private $lookupList;

    /**
     * Reads the table from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->version = $stream->readFixed();
        $this->scriptList = $stream->readOffset();
        $this->featureList = $stream->readOffset();
        $this->lookupList = $stream->readOffset();
    }

}

<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;

/**
 * Three tables are used to embed bitmaps in OpenType™ fonts. They are the 'EBLC' table for embedded bitmap locators,
 * the 'EBDT' table for embedded bitmap data, and the 'EBSC' table for embedded bitmap scaling information.
 *
 * For more information visit http://www.microsoft.com/typography/otspec/ebdt.htm
 */
class EbdtTable
{
    /**
     * Initially defined as 0x00020000
     *
     * @var float
     */
    private $version;

    /**
     * Reads the table from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->version = $stream->readFixed();
    }

}

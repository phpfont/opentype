<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;

/**
 * The DSIG table contains the digital signature of the OpenType™ font. Signature formats are widely documented and
 * rely on a key pair architecture. Software developers, or publishers posting material on the Internet, create
 * signatures using a private key. Operating systems or applications authenticate the signature using a public key.
 *
 * For more information visit http://www.microsoft.com/typography/otspec/dsig.htm
 */
class DsigTable
{
    /**
     * The version number of the DSIG table.
     *
     * @var int
     */
    private $ulVersion;

    /**
     * The amount of signatures in the table.
     *
     * @var int
     */
    private $usNumSigs;

    /**
     * The permission flags.
     *
     * @var int
     */
    private $usFlag;

    /**
     * Reads the DSIG table from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->ulVersion = $stream->readULong();
        $this->usNumSigs = $stream->readUShort();
        $this->usFlag = $stream->readUShort();
    }
}

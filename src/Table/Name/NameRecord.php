<?php

namespace PhpFont\OpenType\Table\Name;

use PhpFont\OpenType\StreamInterface;
use RuntimeException;

/**
 * An entry in the name table.
 *
 * http://www.microsoft.com/typography/otspec/name.htm
 */
class NameRecord
{
    /**
     * The platform ID.
     *
     * @var int
     */
    private $platformID;

    /**
     * The platform specific encoding ID.
     *
     * @var int
     */
    private $encodingID;

    /**
     * The language ID.
     *
     * @var int
     */
    private $languageID;

    /**
     * The name ID.
     *
     * @var int
     */
    private $nameID;

    /**
     * The length of the stirng.
     *
     * @var int
     */
    private $length;

    /**
     * The offset of the string from the start of storage in bytes.
     *
     * @var int
     */
    private $offset;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {

    }

    /**
     * Gets the platform ID.
     *
     * @return int
     */
    public function getPlatformID()
    {
        return $this->platformID;
    }

    /**
     * Gets the platform specific encoding ID.
     *
     * @return int
     */
    public function getEncodingID()
    {
        return $this->encodingID;
    }

    /**
     * Gets the language ID.
     *
     * @return int
     */
    public function getLanguageID()
    {
        return $this->languageID;
    }

    /**
     * Gets the name ID.
     *
     * @return int
     */
    public function getNameID()
    {
        return $this->nameID;
    }

    /**
     * Gets the length of the string in bytes.
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Gets the offset of the string in the stream in bytes.
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Gets the language code.
     *
     * @return string
     */
    public function getLanguageCode()
    {
        switch ($this->platformID) {
            case 0:
                return null;

            case 1:
                return $this->getMacintoshLanguageCode();

            case 2:
                throw new RuntimeException('The ISO platform id is deprecated and not supported.');

            case 3:
                return $this->getWindowsLanguageCode();

            case 4:
                throw new RuntimeException('Custom platform id is not supported.');

            default:
                throw new RuntimeException('Unknown platform id provided: ' . $this->platformID);
        }
    }

    /**
     * Gets the language code based on a Macintosh format.
     *
     * @return string
     */
    private function getMacintoshLanguageCode()
    {
        $languageID = $this->languageID;

        switch ($languageID) {
            case 0:
                return 'en';
            case 1:
                return 'fr';
            case 2:
                return 'de';
            case 3:
                return 'it';
            case 4:
                return 'nl';
            case 5:
                return 'sv';
            case 6:
                return 'es';
            case 7:
                return 'da';
            case 8:
                return 'pt';
            case 9:
                return 'no';
            case 10:
                return 'he';
            case 11:
                return 'ja';
            case 12:
                return 'ar';
            case 13:
                return 'fi';
            case 14:
                return 'el';
            default:
                return null;
        }
    }

    /**
     * Gets the language code based on a Windows format.
     *
     * @return string
     */
    private function getWindowsLanguageCode()
    {
        $languageID = $this->languageID;
        $languageID &= 0xff;

        // The low-order bytes specify the language, the high-order bytes specify the dialect. We just care about
        // the language. For the complete list, see: http://www.microsoft.com/globaldev/reference/lcid-all.mspx
        switch ($languageID) {
            case 0x09:
                return 'en';
            case 0x0c:
                return 'fr';
            case 0x07:
                return 'de';
            case 0x10:
                return 'it';
            case 0x13:
                return 'nl';
            case 0x1d:
                return 'sv';
            case 0x0a:
                return 'es';
            case 0x06:
                return 'da';
            case 0x16:
                return 'pt';
            case 0x14:
                return 'no';
            case 0x0d:
                return 'he';
            case 0x11:
                return 'ja';
            case 0x01:
                return 'ar';
            case 0x0b:
                return 'fi';
            case 0x08:
                return 'el';
            default:
                return null;
        }
    }

    /**
     * Reads information from the stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->platformID = $stream->readUShort();
        $this->encodingID = $stream->readUShort();
        $this->languageID = $stream->readUShort();
        $this->nameID = $stream->readUShort();
        $this->length = $stream->readUShort();
        $this->offset = $stream->readUShort();
    }

}

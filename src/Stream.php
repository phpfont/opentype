<?php

namespace PhpFont\OpenType;

use DateTime;
use PhpFont\Binary\Stream as BinaryStream;
use PhpFont\OpenType\StreamInterface as OpenTypeStreamInterface;

class Stream extends BinaryStream implements OpenTypeStreamInterface
{
    /**
     * Reads a byte.
     *
     * @return int
     */
    public function readByte()
    {
        return $this->readUInt8BE();
    }

    /**
     * Reads an 8-bit signed integer.
     *
     * @return int
     */
    public function readChar()
    {
        return $this->readUInt8BE();
    }

    /**
     * Reads a 16-bit unsigned integer.
     *
     * @return int
     */
    public function readUShort()
    {
        return $this->readUInt16BE();
    }

    /**
     * Reads a 16-bit signed integer.
     *
     * @return int
     */
    public function readShort()
    {
        return $this->readInt16BE();
    }

    /**
     * Reads a 24-bit unsigned integer.
     *
     * @return int
     */
    public function readUInt24()
    {
        // TODO
    }

    /**
     * Reads a 32-bit unsigned integer.
     *
     * @return int
     */
    public function readULong()
    {
        return $this->readUInt32BE();
    }

    /**
     * Reads a 32-bit signed integer.
     *
     * @return int
     */
    public function readLong()
    {
        return $this->readInt32BE();
    }

    /**
     * Reads a 32-bit floating point number.
     *
     * @return float
     */
    public function readFixed()
    {
        return $this->readFloat32BE();
    }

    /**
     * Reads the smallest measurable distance in the em space.
     *
     * @return float
     */
    public function readFUnit()
    {
        // TODO
    }

    /**
     * Reads a 16-bit signed integer (SHORT) that describes a quantity in FUnits.
     *
     * @return int
     */
    public function readFWord()
    {
        return $this->readShort();
    }

    /**
     * Reads a 16-bit unsigned integer (USHORT) that describes a quantity in FUnits.
     *
     * @return int
     */
    public function readUFWord()
    {
        return $this->readUShort();
    }

    /**
     * Reads a 16-bit signed fixed number with the low 14 bits of fraction (2.14).
     *
     * @return float
     */
    public function readF2Dot14()
    {
        // TODO
    }

    /**
     * Reads a date represented in number of seconds since 12:00 midnight, January 1, 1904. The value is represented
     * as a signed 64-bit integer.
     *
     * @return DateTime
     */
    public function readLongDateTime()
    {
        $this->readULong();
        $date = $this->readULong() - 2082844800;

        return new DateTime(strftime("%Y-%m-%d %H:%M:%S", $date));
    }

    /**
     * Reads an array of four uint8s (length = 32 bits) used to identify a script, language system, feature, or baseline.
     *
     * @return int
     */
    public function readTag()
    {
        return $this->readUInt32BE();
    }

    /**
     * Reads a glyph index number, same as uint16.
     *
     * @return int
     */
    public function readGlyphId()
    {
        // TODO
    }

    /**
     * Reads an offset to a table, same as uint16 (length = 16 bits), NULL offset = 0x0000
     *
     * @return int
     */
    public function readOffset()
    {
        return $this->readUInt16BE();
    }

    /**
     * Reads a string and converts the encoding.
     *
     * @param int $byteCount The amount of bytes to read.
     * @param string $inputCharacterSet The input character set.
     * @param string $outputCharacterSet The output character set.
     */
    public function readStringBytes($byteCount, $inputCharacterSet, $outputCharacterSet)
    {
        if ($byteCount == 0) {
            return '';
        }

        $bytes = $this->read($byteCount);

        return iconv($inputCharacterSet, $outputCharacterSet, $bytes);
    }
}

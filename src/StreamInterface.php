<?php

namespace PhpFont\OpenType;

use DateTime;
use PhpFont\Binary\StreamInterface as BinaryStreamInterface;

/**
 * The interface that descirbes the types within a OpenType font file.
 */
interface StreamInterface extends BinaryStreamInterface
{
    /**
     * Reads a byte.
     *
     * @return int
     */
    public function readByte();

    /**
     * Reads an 8-bit signed integer.
     *
     * @return int
     */
    public function readChar();

    /**
     * Reads a 16-bit unsigned integer.
     *
     * @return int
     */
    public function readUShort();

    /**
     * Reads a 16-bit signed integer.
     *
     * @return int
     */
    public function readShort();

    /**
     * Reads a 24-bit unsigned integer.
     *
     * @return int
     */
    public function readUInt24();

    /**
     * Reads a 32-bit unsigned integer.
     *
     * @return int
     */
    public function readULong();

    /**
     * Reads a 32-bit signed integer.
     *
     * @return int
     */
    public function readLong();

    /**
     * Reads a 32-bit floating point number.
     *
     * @return float
     */
    public function readFixed();

    /**
     * Reads the smallest measurable distance in the em space.
     *
     * @return float
     */
    public function readFUnit();

    /**
     * Reads a 16-bit signed integer (SHORT) that describes a quantity in FUnits.
     *
     * @return int
     */
    public function readFWord();

    /**
     * Reads a 16-bit unsigned integer (USHORT) that describes a quantity in FUnits.
     *
     * @return int
     */
    public function readUFWord();

    /**
     * Reads a 16-bit signed fixed number with the low 14 bits of fraction (2.14).
     *
     * @return float
     */
    public function readF2Dot14();

    /**
     * Reads a date represented in number of seconds since 12:00 midnight, January 1, 1904. The value is represented
     * as a signed 64-bit integer.
     *
     * @return DateTime
     */
    public function readLongDateTime();

    /**
     * Reads an array of four uint8s (length = 32 bits) used to identify a script, language system, feature, or baseline.
     *
     * @return int
     */
    public function readTag();

    /**
     * Reads a glyph index number, same as uint16.
     *
     * @return int
     */
    public function readGlyphId();

    /**
     * Reads an offset to a table, same as uint16 (length = 16 bits), NULL offset = 0x0000
     *
     * @return int
     */
    public function readOffset();

    /**
     * Reads a string and converts the encoding.
     *
     * @param int $byteCount The amount of bytes to read.
     * @param string $inputCharacterSet The input character set.
     * @param string $outputCharacterSet The output character set.
     */
    public function readStringBytes($byteCount, $inputCharacterSet, $outputCharacterSet);
}

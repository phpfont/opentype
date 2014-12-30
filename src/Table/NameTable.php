<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\Table\Name\LangTagRecord;
use PhpFont\OpenType\Table\Name\NameRecord;
use PhpFont\OpenType\StreamInterface;

/**
 * The naming table allows multilingual strings to be associated with the OpenType™ font file.
 *
 * http://www.microsoft.com/typography/otspec/name.htm
 */
class NameTable
{
    /**
     * Copyright notice.
     */
    const NAME_COPYRIGHT = 0;

    /**
     * Font Family name. Up to four fonts can share the Font Family name, forming a font style linking group
     * (regular, italic, bold, bold italic - as defined by OS/2.fsSelection bit settings).
     */
    const NAME_FAMILY = 1;

    /**
     * Font Subfamily name. The Font Subfamily name distiguishes the font in a group with the same Font Family name
     * (name ID 1). This is assumed to address style (italic, oblique) and weight (light, bold, black, etc.). A font
     * with no particular differences in weight or style (e.g. medium weight, not italic and fsSelection bit 6 set)
     * should have the string “Regular” stored in this position.
     */
    const NAME_SUBFAMILY = 2;

    /**
     * Unique font identifier
     */
    const NAME_ID = 3;

    /**
     * Full font name; a combination of strings 1 and 2, or a similar human-readable variant. If string 2 is
     * "Regular", it is sometimes omitted from name ID 4.
     */
    const NAME_FULL = 4;

    /**
     * Version string. Should begin with the syntax 'Version <number>.<number>' (upper case, lower case, or mixed,
     * with a space between “Version” and the number).
     */
    const NAME_VERSION = 5;

    /**
     * Postscript name for the font; Name ID 6 specifies a string which is used to invoke a PostScript language font
     * that corresponds to this OpenType font. If no name ID 6 is present, then there is no defined method for
     * invoking this font on a PostScript interpreter.
     */
    const NAME_POSTSCRIPT = 6;

    /**
     * Trademark; this is used to save any trademark notice/information for this font. Such information should be
     * based on legal advice. This is distinctly separate from the copyright.
     */
    const NAME_TRADEMARK = 7;

    /**
     * Manufacturer Name.
     */
    const NAME_MANUFACTURER = 8;

    /**
     * Designer; name of the designer of the typeface.
     */
    const NAME_DESIGNER = 9;

    /**
     * Description; description of the typeface. Can contain revision information, usage recommendations, history,
     * features, etc.
     */
    const NAME_DESCRIPTION = 10;

    /**
     * URL Vendor; URL of font vendor (with protocol, e.g., http://, ftp://). If a unique serial number is embedded
     * in the URL, it can be used to register the font.
     */
    const NAME_URL_VENDOR = 11;

    /**
     * URL Designer; URL of typeface designer (with protocol, e.g., http://, ftp://).
     */
    const NAME_URL_DESIGNER = 12;

    /**
     * License Description; description of how the font may be legally used, or different example scenarios for
     * licensed use. This field should be written in plain language, not legalese.
     */
    const NAME_LICENSE_DESCRIPTION = 13;

    /**
     * License Info URL; URL where additional licensing information can be found.
     */
    const NAME_LICENSE_INFO_URL = 14;

    /**
     * Preferred Family; For historical reasons, font families have contained a maximum of four styles, but font
     * designers may group more than four fonts to a single family. The Preferred Family allows font designers to
     * include the preferred family grouping which contains more than four fonts. This ID is only present if it is
     * different from ID 1.
     */
    const NAME_PREFERRED_FAMILY = 16;

    /**
     * Preferred Subfamily; Allows font designers to include the preferred subfamily grouping that is more descriptive
     * than ID 2. This ID is only present if it is different from ID 2 and must be unique for the the Preferred Family.
     */
    const NAME_PREFERRED_SUBFAMILY = 17;

    /**
     * Sample text; This can be the font name, or any other text that the designer thinks is the best sample to
     * display the font in.
     */
    const NAME_SAMPLE_TEXT = 19;

    /**
     * PostScript CID findfont name; Its presence in a font means that the nameID 6 holds a PostScript font name that
     * is meant to be used with the “composefont” invocation in order to invoke the font in a PostScript interpreter.
     * See the definition of name ID 6.
     */
    const NAME_CID_NAME = 20;

    /**
     * The base offset used to read the names.
     *
     * @var int
     */
    private $baseOffset;

    /**
     * Format selector (=0).
     *
     * @var int
     */
    private $format;

    /**
     * Number of name records.
     *
     * @var int
     */
    private $count;

    /**
     * Offset to start of string storage (from start of table).
     *
     * @var int
     */
    private $stringOffset;

    /**
     * The name records where count is the number of records.
     *
     * @var NameRecord[]
     */
    private $nameRecord;

    /**
     * The string names.
     *
     * @var string[]
     */
    private $names;

    /**
     * Number of language-tag records.
     *
     * @var int
     */
    private $langTagCount;

    /**
     * The language-tag records where langTagCount is the number of records.
     *
     * @var LangTagRecord[]
     */
    private $langTagRecord;

    /**
     * Initiializes a new instance of this class.
     *
     * @param int $baseOffset The base offset used to read names.
     */
    public function __construct($baseOffset)
    {
        $this->baseOffset = $baseOffset;
        $this->names = array();
    }

    /**
     * Reads information from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->format = $stream->readUShort();
        $this->count = $stream->readUShort();
        $this->stringOffset = $stream->readUShort();
        $this->nameRecord = $this->readNameTable($stream);

        if ($this->format == 1) {
            $this->langTagCount = $stream->readUShort();
            $this->langTagRecord = $this->readLangRecords();
        }

        $this->names = $this->readNames($stream);
    }

    /**
     * Reads the records from the name table.
     *
     * @param StreamInterface $stream The stream to read from.
     * @return NameRecord[]
     */
    private function readNameTable(StreamInterface $stream)
    {
        $records = array();

        for ($i = 0; $i < $this->count; ++$i) {
            $record = new NameRecord($this);
            $record->read($stream);

            $records[] = $record;
        }

        return $records;
    }

    /**
     * Reads all the names from the given stream.
     *
     * @param StreamInterface $stream The stream to read from.
     * @return string[]
     */
    private function readNames(StreamInterface $stream)
    {
        $names = array();

        foreach ($this->nameRecord as $record) {
            // When there is no language code, we can't read the record name:
            if ($record->getLanguageCode() === null) {
                continue;
            }

            $stringOffset = $this->baseOffset + $this->stringOffset + $record->getOffset();

            $stream->setPosition($stringOffset);

            if ($record->getPlatformID() == 3) {
                $name = $stream->readStringBytes($record->getLength(), 'UTF-16BE', 'UTF-8');
            } else {
                $name = $stream->readStringBytes($record->getLength(), 'MacRoman', 'UTF-8');
            }

            $names[$record->getNameID()][$record->getLanguageCode()] = $name;
        }

        return $names;
    }

    /**
     * Reads all the language records.
     *
     * @param StreamInterface $stream The stream to read from.
     * @return LangTagRecord[]
     */
    private function readLangRecords(StreamInterface $stream)
    {
        $records = array();

        for ($i = 0; $i < $this->langTagCount; ++$i) {
            $record = new LangTagRecord();
            $record->read($stream);

            $records[] = $record;
        }

        return $records;
    }

    /**
     * Gets the name with the given type and language.
     *
     * @param int $type The type of name to get.
     * @param string $language The language to get the name in.
     * @return string
     */
    public function getName($type, $language = null)
    {
        if (!array_key_exists($type, $this->names)) {
            return null;
        }

        if ($language === null || !array_key_exists($language, $this->names[$type])) {
            $result = current($this->names[$type]);
        } else {
            $result = $this->names[$type][$language];
        }

        return $result;
    }
}

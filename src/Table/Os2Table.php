<?php

namespace PhpFont\OpenType\Table;

use PhpFont\OpenType\StreamInterface;

/**
 * The OS/2 table consists of a set of metrics that are required in OpenType fonts.
 *
 * For more information visit http://www.microsoft.com/typography/otspec/os2.htm
 */
class Os2Table
{
    /**
     * The version number for this OS/2 table.
     *
     * @var int
     */
    private $version;

    /**
     * The Average Character Width parameter specifies the arithmetic average of the escapement (width) of all
     * non-zero width glyphs in the font.
     *
     * @var int
     */
    private $xAvgCharWidth;

    /**
     * Indicates the visual weight (degree of blackness or thickness of strokes) of the characters in the font.
     *
     * @var int
     */
    private $usWeightClass;

    /**
     * Indicates a relative change from the normal aspect ratio (width to height ratio) as specified by a font
     * designer for the glyphs in a font.
     *
     * @var int
     */
    private $usWidthClass;

    /**
     * Indicates font embedding licensing rights for the font. Embeddable fonts may be stored in a document. When a
     * document with embedded fonts is opened on a system that does not have the font installed (the remote system),
     * the embedded font may be loaded for temporary (and in some cases, permanent) use on that system by an
     * embedding-aware application. Embedding licensing rights are granted by the vendor of the font.
     *
     * @var int
     */
    private $fsType;

    /**
     * The recommended horizontal size in font design units for subscripts for this font.
     *
     * @var int
     */
    private $ySubscriptXSize;

    /**
     * The recommended vertical size in font design units for subscripts for this font.
     *
     * @var int
     */
    private $ySubscriptYSize;

    /**
     * The recommended horizontal offset in font design untis for subscripts for this font.
     *
     * @var int
     */
    private $ySubscriptXOffset;

    /**
     * The recommended vertical offset in font design units from the baseline for subscripts for this font.
     *
     * @var int
     */
    private $ySubscriptYOffset;

    /**
     * The recommended horizontal size in font design units for superscripts for this font.
     *
     * @var int
     */
    private $ySuperscriptXSize;

    /**
     * The recommended vertical size in font design units for superscripts for this font.
     *
     * @var int
     */
    private $ySuperscriptYSize;

    /**
     * The recommended horizontal offset in font design units for superscripts for this font.
     *
     * @var int
     */
    private $ySuperscriptXOffset;

    /**
     * The recommended vertical offset in font design units from the baseline for superscripts for this font.
     *
     * @var int
     */
    private $ySuperscriptYOffset;

    /**
     * Width of the strikeout stroke in font design units.
     *
     * @var int
     */
    private $yStrikeoutSize;

    /**
     * The position of the top of the strikeout stroke relative to the baseline in font design units.
     *
     * @var int
     */
    private $yStrikeoutPosition;

    /**
     * This parameter is a classification of font-family design.
     *
     * @var int
     */
    private $sFamilyClass;

    /**
     * This 10 byte series of numbers is used to describe the visual characteristics of a given typeface. These
     * characteristics are then used to associate the font with other fonts of similar appearance having different
     * names. The variables for each digit are listed below. The Panose values are fully described in the Panose
     * "greybook" reference, currently owned by Monotype Imaging.
     *
     * @var int
     */
    private $panose;

    /**
     * This field is used to specify the Unicode blocks or ranges encompassed by the font file in the 'cmap' subtables
     * for platform 3, encoding ID 1 (Microsoft platform, Unicode) and platform 3, encoding ID 10
     * (Microsoft platform, UCS-4). If the bit is set (1) then the Unicode range is considered functional. If the bit
     * is clear (0) then the range is not considered functional. Each of the bits is treated as an independent flag and
     * the bits can be set in any combination. The determination of “functional” is left up to the font designer,
     * although character set selection should attempt to be functional by ranges if at all possible.
     *
     * This field holds bits 0 to 31.
     *
     * @var int
     */
    private $ulUnicodeRange1;

    /**
     * This field is used to specify the Unicode blocks or ranges encompassed by the font file in the 'cmap' subtables
     * for platform 3, encoding ID 1 (Microsoft platform, Unicode) and platform 3, encoding ID 10
     * (Microsoft platform, UCS-4). If the bit is set (1) then the Unicode range is considered functional. If the bit
     * is clear (0) then the range is not considered functional. Each of the bits is treated as an independent flag and
     * the bits can be set in any combination. The determination of “functional” is left up to the font designer,
     * although character set selection should attempt to be functional by ranges if at all possible.
     *
     * This field holds bits 32 to 63.
     *
     * @var int
     */
    private $ulUnicodeRange2;

    /**
     * This field is used to specify the Unicode blocks or ranges encompassed by the font file in the 'cmap' subtables
     * for platform 3, encoding ID 1 (Microsoft platform, Unicode) and platform 3, encoding ID 10
     * (Microsoft platform, UCS-4). If the bit is set (1) then the Unicode range is considered functional. If the bit
     * is clear (0) then the range is not considered functional. Each of the bits is treated as an independent flag and
     * the bits can be set in any combination. The determination of “functional” is left up to the font designer,
     * although character set selection should attempt to be functional by ranges if at all possible.
     *
     * This field holds bits 64 to 95.
     *
     * @var int
     */
    private $ulUnicodeRange3;

    /**
     * This field is used to specify the Unicode blocks or ranges encompassed by the font file in the 'cmap' subtables
     * for platform 3, encoding ID 1 (Microsoft platform, Unicode) and platform 3, encoding ID 10
     * (Microsoft platform, UCS-4). If the bit is set (1) then the Unicode range is considered functional. If the bit
     * is clear (0) then the range is not considered functional. Each of the bits is treated as an independent flag and
     * the bits can be set in any combination. The determination of “functional” is left up to the font designer,
     * although character set selection should attempt to be functional by ranges if at all possible.
     *
     * This field holds bits 96 to 127.
     *
     * @var int
     */
    private $ulUnicodeRange4;

    /**
     * The four character identifier for the vendor of the given type face.
     *
     * @var int
     */
    private $achVendID;

    /**
     * Contains information concerning the nature of the font patterns.
     *
     * @var int
     */
    private $fsSelection;

    /**
     * The minimum Unicode index (character code) in this font, according to the cmap subtable for platform ID 3 and
     * platform- specific encoding ID 0 or 1. For most fonts supporting Win-ANSI or other character sets, this value
     * would be 0x0020. This field cannot represent supplementary character values (codepoints greater than 0xFFFF).
     *
     * Fonts that support supplementary characters should set the value in this field to 0xFFFF if the minimum index
     * value is a supplementary character.
     *
     * @var int
     */
    private $usFirstCharIndex;

    /**
     * The maximum Unicode index (character code) in this font, according to the cmap subtable for platform ID 3 and
     * encoding ID 0 or 1. This value depends on which character sets the font supports. This field cannot represent
     * supplementary character values (codepoints greater than 0xFFFF). Fonts that support supplementary characters
     * should set the value in this field to 0xFFFF.
     *
     * @var int
     */
    private $usLastCharIndex;

    /**
     * The typographic ascender for this font. Remember that this is not the same as the Ascender value in the 'hhea'
     * table, which Apple defines in a far different manner. One good source for sTypoAscender in Latin based fonts is
     * the Ascender value from an AFM file. For CJK fonts see below.
     *
     * @var int
     */
    private $sTypoAscender;

    /**
     * The typographic descender for this font. Remember that this is not the same as the Descender value in the 'hhea'
     * table, which Apple defines in a far different manner. One good source for sTypoDescender in Latin based fonts is
     * the Descender value from an AFM file. For CJK fonts see below.
     *
     * @var int
     */
    private $sTypoDescender;

    /**
     * The typographic line gap for this font. Remember that this is not the same as the LineGap value in the 'hhea'
     * table, which Apple defines in a far different manner.
     *
     * @var int
     */
    private $sTypoLineGap;

    /**
     * The ascender metric for Windows. This, too, is distinct from Apple's Ascender value and from the usTypoAscender
     * values. usWinAscent is computed as the yMax for all characters in the Windows ANSI character set. usWinAscent is
     * used to compute the Windows font height and default line spacing. For platform 3 encoding 0 fonts, it is the same
     * as yMax. Windows will clip the bitmap of any portion of a glyph that appears above this value. Some applications
     * use this value to determine default line spacing. This is strongly discouraged. The typographic ascender,
     * descender and line gap fields in conjunction with unitsPerEm should be used for this purpose. Developers should
     * set this field keeping the above factors in mind.
     *
     * @var int
     */
    private $usWinAscent;

    /**
     * The descender metric for Windows. This, too, is distinct from Apple's Descender value and from the
     * usTypoDescender values. usWinDescent is computed as the -yMin for all characters in the Windows ANSI character
     * set. usWinDescent is used to compute the Windows font height and default line spacing. For platform 3 encoding 0
     * fonts, it is the same as -yMin. Windows will clip the bitmap of any portion of a glyph that appears below this
     * value. Some applications use this value to determine default line spacing. This is strongly discouraged. The
     * typographic ascender, descender and line gap fields in conjunction with unitsPerEm should be used for this
     * purpose. Developers should set this field keeping the above factors in mind.
     *
     * @var int
     */
    private $usWinDescent;

    /**
     * This field is used to specify the code pages encompassed by the font file in the 'cmap' subtable for platform 3,
     * encoding ID 1 (Microsoft platform). If the font file is encoding ID 0, then the Symbol Character Set bit should
     * be set. If the bit is set (1) then the code page is considered functional. If the bit is clear (0) then the code
     * page is not considered functional. Each of the bits is treated as an independent flag and the bits can be set in
     * any combination. The determination of “functional” is left up to the font designer, although character set
     * selection should attempt to be functional by code pages if at all possible.
     *
     * Bits 0-31
     *
     * @var int
     */
    private $ulCodePageRange1;

    /**
     * This field is used to specify the code pages encompassed by the font file in the 'cmap' subtable for platform 3,
     * encoding ID 1 (Microsoft platform). If the font file is encoding ID 0, then the Symbol Character Set bit should
     * be set. If the bit is set (1) then the code page is considered functional. If the bit is clear (0) then the code
     * page is not considered functional. Each of the bits is treated as an independent flag and the bits can be set in
     * any combination. The determination of “functional” is left up to the font designer, although character set
     * selection should attempt to be functional by code pages if at all possible.
     *
     * Bits 32-63
     *
     * @var int
     */
    private $ulCodePageRange2;

    /**
     * This metric specifies the distance between the baseline and the approximate height of non-ascending lowercase
     * letters measured in FUnits. This value would normally be specified by a type designer but in situations where
     * that is not possible, for example when a legacy font is being converted, the value may be set equal to the top
     * of the unscaled and unhinted glyph bounding box of the glyph encoded at U+0078 (LATIN SMALL LETTER X). If no
     * glyph is encoded in this position the field should be set to 0.
     *
     * @var int
     */
    private $sxHeight;

    /**
     * This metric specifies the distance between the baseline and the approximate height of uppercase letters measured
     * in FUnits. This value would normally be specified by a type designer but in situations where that is not possible,
     * for example when a legacy font is being converted, the value may be set equal to the top of the unscaled and
     * unhinted glyph bounding box of the glyph encoded at U+0048 (LATIN CAPITAL LETTER H). If no glyph is encoded in
     * this position the field should be set to 0.
     *
     * @var int
     */
    private $sCapHeight;

    /**
     * Whenever a request is made for a character that is not in the font, Windows provides this default character.
     * If the value of this field is zero, glyph ID 0 is to be used for the default character otherwise this is the
     * Unicode encoding of the glyph that Windows uses as the default character. This field cannot represent
     * supplementary character values (codepoints greater than 0xFFFF), and so applications are strongly discouraged
     * from using this field.
     *
     * @var int
     */
    private $usDefaultChar;

    /**
     * This is the Unicode encoding of the glyph that Windows uses as the break character. The break character is
     * used to separate words and justify text. Most fonts specify 'space' as the break character. This field cannot
     * represent supplementary character values (codepoints greater than 0xFFFF) , and so applications are strongly
     * discouraged from using this field.
     *
     * @var int
     */
    private $usBreakChar;

    /**
     * The maximum length of a target glyph context for any feature in this font. For example, a font which has only
     * a pair kerning feature should set this field to 2. If the font also has a ligature feature in which the glyph
     * sequence 'f f i' is substituted by the ligature 'ffi', then this field should be set to 3. This field could be
     * useful to sophisticated line-breaking engines in determining how far they should look ahead to test whether
     * something could change that effects the line breaking. For chaining contextual lookups, the length of the string
     * (covered glyph) + (input sequence) + (lookahead sequence) should be considered.
     *
     * @var int
     */
    private $usMaxContext;

    /**
     * @param StreamInterface $stream The stream to read from.
     */
    public function read(StreamInterface $stream)
    {
        $this->version = $stream->readUShort();
        $this->xAvgCharWidth = $stream->readShort();
        $this->usWeightClass = $stream->readUShort();
        $this->usWidthClass = $stream->readUShort();
        $this->fsType = $stream->readUShort();
        $this->ySubscriptXSize = $stream->readShort();
        $this->ySubscriptYSize = $stream->readShort();
        $this->ySubscriptXOffset = $stream->readShort();
        $this->ySubscriptYOffset = $stream->readShort();
        $this->ySuperscriptXSize = $stream->readShort();
        $this->ySuperscriptYSize = $stream->readShort();
        $this->ySuperscriptXOffset = $stream->readShort();
        $this->ySuperscriptYOffset = $stream->readShort();
        $this->yStrikeoutSize = $stream->readShort();
        $this->yStrikeoutPosition = $stream->readShort();
        $this->sFamilyClass = $stream->readShort();
        $this->panose = array();
        for ($i = 0; $i < 10; ++$i) {
            $this->panose[] = $stream->readByte();
        }
        $this->ulUnicodeRange1 = $stream->readULong();
        $this->ulUnicodeRange2 = $stream->readULong();
        $this->ulUnicodeRange3 = $stream->readULong();
        $this->ulUnicodeRange4 = $stream->readULong();
        $this->achVendID = array();
        for ($i = 0; $i < 4; ++$i) {
            $this->achVendID[] = $stream->readChar();
        }
        $this->fsSelection = $stream->readUShort();
        $this->usFirstCharIndex = $stream->readUShort();
        $this->usLastCharIndex = $stream->readUShort();
        $this->sTypoAscender = $stream->readShort();
        $this->sTypoDescender = $stream->readShort();
        $this->sTypoLineGap = $stream->readShort();
        $this->usWinAscent = $stream->readUShort();
        $this->usWinDescent = $stream->readUShort();
        $this->ulCodePageRange1 = $stream->readULong();
        $this->ulCodePageRange2 = $stream->readULong();
        $this->sxHeight = $stream->readShort();
        $this->sCapHeight = $stream->readShort();
        $this->usDefaultChar = $stream->readUShort();
        $this->usBreakChar = $stream->readUShort();
        $this->usMaxContext = $stream->readUShort();
    }

}

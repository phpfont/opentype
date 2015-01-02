<?php

namespace PhpFont\OpenType\Table\Cmap\Subtable;

/**
 * The format interface describes a cmap subtable format.
 */
interface FormatInterface
{
    /**
     * Gets the format number.
     *
     * @return int
     */
    public function getFormat();
}

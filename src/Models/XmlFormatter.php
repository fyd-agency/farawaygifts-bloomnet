<?php

namespace BloomNetwork\Models;

use Spatie\ArrayToXml\ArrayToXml;

interface XmlFormatter
{
    public function xml(): string;
}
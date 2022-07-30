<?php

namespace BloomNetwork\Models;

interface XmlFormatter
{
    public function toXml(): \DOMDocument;
}
<?php

if (! function_exists('dd')) {
    function dd(): void
    {
        foreach (func_get_args() as $x) {
            dump($x);
        }
        exit;
    }
}

function array_to_xml(array $data): DOMDocument
{
    $xml = new DOMDocument();

    foreach ($data as $key => $value) {
        if (is_array($value)) {

        }
    }
}

foreach ($xml_data as $key => $value) {
    if (is_array($value)) {
        if (is_numeric($key)) {
            $key = 'item'.$key; //dealing with <0/>..<n/> issues
        }
        $subnode = $xml_data->addChild($key);
        array_to_xml($value, $subnode);
    } else {
        $xml_data->addChild("$key", htmlspecialchars("$value"));
    }
}

<?php

namespace App\URLParser;

class URLParserMain
{
    private $parts;
    private $key;
    private $finalPart;

    public function getUrlPart($message, $part)
    {
        $this->parts = explode('/', parse_url($message)['path']);
        $this->key = array_search($part, $this->parts) + 1;
        $this->finalPart = $this->parts[$this->key];
        return $this->finalPart;
    }
}

?>

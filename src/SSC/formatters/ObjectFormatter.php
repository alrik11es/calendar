<?php
namespace SSC\formatters;
class ObjectFormatter implements FormatterInterface{
    
    public function setFormat($data)
    {
        return json_decode(json_encode($data), FALSE);
    }
}
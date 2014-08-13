<?php
namespace SSC\formatters;
class JsonFormatter implements FormatterInterface{
    public function setFormat($data){
        return json_encode($data);
    }
}

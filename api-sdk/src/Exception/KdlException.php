<?php

namespace kdl\Exception;


class KdlException extends \Exception
    {
        protected $message;
        protected $code;

        function __construct($message="", $code){
           $this -> message = $message;
           $this -> code = $code;
           #$this -> hint_message = "[KdlException] code: ".$code." message: ".$message;
           parent::__construct($message, $code);
        }
        function __tostring(){
            return __CLASS__.":[".$this->code."]:".$this->message."\n";
        } 
    }

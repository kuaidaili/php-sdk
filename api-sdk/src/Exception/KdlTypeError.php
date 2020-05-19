<?php

namespace kdl\Exception;

class KdlTypeError extends KdlException
    {
        function __construct($message, $code=-1){
            parent::__construct($message, $code=-1);
        }    
    }

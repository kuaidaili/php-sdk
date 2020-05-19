<?php

namespace kdl\Exception;

class KdlStatusError extends kdlException
    {
        function __construct($message, $code){
            parent::__construct($message, $code);
        }    
        
    }
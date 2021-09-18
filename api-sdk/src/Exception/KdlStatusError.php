<?php

namespace kdl\Exception;

class KdlStatusError extends KdlException
    {
        function __construct($message, $code){
            parent::__construct($message, $code);
        }    
        
    }

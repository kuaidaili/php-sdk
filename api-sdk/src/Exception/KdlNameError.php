<?php

namespace kdl\Exception;

class KdlNameError extends KdlException
    {
        function __construct($message, $code=-2){
            parent::__construct($message, $code=-2);
        }    
    }
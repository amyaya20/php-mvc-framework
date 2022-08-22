<?php


    namespace amohd12\phpmvc\exception;


    class NotFoundException extends \Exception {

        // public function __construct(){



            
        // }


        protected $message = 'Page not found';
        protected $code = 404;


    }
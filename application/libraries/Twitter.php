<?php
class Twitter
{
    public function __construct()
    {
        require_once dirname(__FILE__) . '/Twitter/tmhOAuth.php';
        require_once dirname(__FILE__) . '/Twitter/tmhUtilities.php';
    }
}
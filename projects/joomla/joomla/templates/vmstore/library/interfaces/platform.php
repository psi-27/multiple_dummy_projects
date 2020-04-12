<?php
// Joomla Security Check - no direct access to this file
// Prevents File Path Exposure
defined('_JEXEC') or die('Restricted access');

interface VmStorePlatformInterface
{
    public static function getInstance ();

    function __construct ();
}

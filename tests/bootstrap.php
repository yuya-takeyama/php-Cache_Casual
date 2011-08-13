<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../src');
require_once 'Cache/Casual.php';
require_once 'Cache/Casual/Container/Memory.php';
require_once 'Cache/Casual/Container/File.php';
require_once 'vfsStream/vfsStream.php';

<?php
set_include_path(dirname(__FILE__) . '/../../src' . PATH_SEPARATOR . get_include_path());
require_once 'Cache/Casual.php';
require_once 'Cache/Casual/Container/Memory.php';
require_once 'Cache/Casual/Container/File.php';
require_once 'vfsStream/vfsStream.php';
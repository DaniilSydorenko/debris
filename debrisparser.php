<?php
require_once 'lib/autoload.php';

$ImageParser = new ImageParser();
$AudioParser = new AudioParser();

echo $ImageParser->getSize() . " = " . $AudioParser->getSize();
<?php
/*******************************************************************************
 * Name: Main
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Include engine
include_once "../../engine/Gaia.php";


// Get gaia instance and try to set stage from APPLICATION_ENV
$Gaia = \Gaia::getInstance(\getenv("APPLICATION_ENV"));

// Run gaia
$Gaia->run();
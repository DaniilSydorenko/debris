<?php
/*******************************************************************************
 * Name: App -> Error
 * Version:
 * Author:
 ******************************************************************************/


// Namespace
namespace App;


/**
 * Error class
 */
class Error extends \Gaia\Controllers\Normal
{
	/**
	 * Exception interceptor
	 *
	 * @param $Exception
	 */
    public static function exception($Exception) {
		echo $Exception->getMessage();
    }
}

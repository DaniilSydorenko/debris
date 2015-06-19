<?php
/*******************************************************************************
 * Name: App -> JSON -> Error
 * Version:
 * Author:
 ******************************************************************************/


// Namespace
namespace App\JSON;


/**
 * Error class
 */
class Error extends \Gaia\Controllers\JSON
{
	/**
	 * Bad request / 404
	 *
	 * @throws \Exception
	 */
    public function badRequest() {
		// Throw new exception about bad request
		throw new \Exception("Bad request");
    }

    /**
     * Exception interceptor
     *
     * @param \Exception $Exception
     * @return array
     */
    public static function exception($Exception) {
		// Return exception as array
		return array(
			"exception"	=> array(
				"code"		=> $Exception->getCode(),
				"message"	=> $Exception->getMessage(),
				"file"		=> $Exception->getFile(),
				"line"		=> $Exception->getLine(),
				"trace"		=> $Exception->getTraceAsString()
			)
		);
    }
}

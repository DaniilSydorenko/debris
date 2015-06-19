<?php
/*******************************************************************************
 * Name: Error -> Code
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Libraries\Error;

/**
 * Error Code
 */
class Code
{
    /* Common */
    const NOT_FOUND                     = "Not Found";
    const DATABASE_ERROR                = "Database Error";

    /* URL */
    const CAN_NOT_SAVE                  = "Can not save your url. Please try later.";
    const CAN_NOT_SET_VIEW              = "Can not the view for this url.";
}
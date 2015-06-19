<?php
/*******************************************************************************
 * Name: Model -> File
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Models;


/**
 * File
 *
 * @Table(name="files", indexes={@Index(name="fk_files_types_idx", columns={"type_id"})})
 * @Entity(repositoryClass="\App\Repositories\File")
 */
class File extends \App\Entities\File
{
    // Add logic here...
}
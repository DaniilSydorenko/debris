<?php
/*******************************************************************************
 * Name: App -> Command -> Doctrine
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Commands;


/**
 * Doctrine class
 */
class Doctrine extends \Gaia\Executable\Command
{
    /**
     * Generate models from database scheme
     *
     * @param $generateRepositories
     * @return int
     */
    public function generateModelsFromDb($generateRepositories = true) {
        // Generate models from database
        $this->getDoctrine()->generateModelsFromDb($generateRepositories);

        // Exit
        return 0;
    }
}

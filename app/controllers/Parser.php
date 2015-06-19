<?php
/*******************************************************************************
 * Name: App -> Parser
 * Version: 1.0
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App;


/**
 * Parser class
 */
class Parser extends \Gaia\Controllers\Twig
{

    /**
     * Show main page
     */
    public function show()
    {
//        $key = $this->getRequest()->getURI();
        // 404
//        if ($this->getRequest()->is404()) {
//            // Show error page
//            $this->display("pages/error/404.twig");
//
//            // Exit
//            exit();
//        }

        // Assign content
        $this->assign("data", [
            "title"   => "File Parser",
        ]);

        // Render template with form
        $this->display("parser/index.twig");
    }
}
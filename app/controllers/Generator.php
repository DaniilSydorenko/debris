<?php
/*******************************************************************************
 * Name: App -> Generator
 * Version: 1.0
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App;


/**
 * Generator class
 */
class Generator extends \Gaia\Controllers\Twig
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
            "title"   => "Sitemap Generator",
        ]);

        // Render template with form
        $this->display("generator/index.twig");
    }
}
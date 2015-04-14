<?php

/**
 * Class Autoloader
 */
class Autoloader
{
    /**
     *
     */
    public static function getAutoloader()
    {
        // Class extension
        $extension = ".class.php";

        // Check PHP version
        $dir = (\version_compare(PHP_VERSION, '5.3.0') >= 0) ? $dir = __DIR__ : $dir = \dirname(__FILE__);

        // Scan lib dir for needed classes
        $libFiles = \scandir($dir);

        foreach ($libFiles as $key => $file) {
            if (\strpos($file, $extension)) {
                $pathToFile = $dir  . DIRECTORY_SEPARATOR . $file;

                // Check if file exists and if it is not a dir with same name
                if (\is_file($pathToFile)) {
                    // Include all files
                    require($pathToFile);
                }
            }
        }
    }
}

spl_autoload_register("Autoloader::getAutoloader");
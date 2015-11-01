<?php
/*******************************************************************************
 * Name: Gaia
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Include
include_once "Core/Loader.php";


/**
 * Class Gaia
 */
class Gaia
{
    // Object instance
    private static $oInstance = false;

    // Dispatcher
    private $Dispatcher = null;

    // Gaia configuration
    private $Config = null;

    // Gaia stage
    private $stage = null;


    /**
     * Default constructor
     *
     * @param null $stage
     */
    final private function __construct($stage = null) {
        // Initialize auto-loader
        \Gaia\Core\Loader::init();

        // Set stage
        $this->stage = $stage;

        // Load gaia config with good stage
        $this->Config = new \Gaia\Utils\Config("gaia.ini", $this->getStage());

        // Set include path
        \set_include_path(\get_include_path() . \PATH_SEPARATOR . $this->Config->gaia->paths->include);

        // Turn off displaying errors
        \ini_set("display_errors", false);

        // Debug mode
        if ($this->Config->gaia->debug) {
            \error_reporting(\E_ALL);
        }

        // Production mode
        else {
            \error_reporting(0);
        }

        // Initialize dispatcher
        $this->Dispatcher = new \Gaia\Core\Dispatcher($this->Config);
    }

    /**
     * Catch all exception and try to redirect to user defined controllers - or default controllers
     *
     * @param $Exception
     * @throws \Exception
     */
    final private function handleException($Exception) {
        // Clean current output buffer
        // \ob_clean();

        // Send error code to client in response header
        \header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error", true, 500);

        // JSON request
        if ($this->Dispatcher->isJSON()) {
            // Get class name
            $className = $this->Config->gaia->dispatcher->controller->exception->json->namespace . "\\" .
                $this->Config->gaia->dispatcher->controller->exception->json->className;

            // Get method name
            $methodName = $this->Config->gaia->dispatcher->controller->exception->json->methodName;

            // Class exists
            if (\class_exists($className)) {
                // Execute interceptor
                $Interceptor = new $className(null, false, $this->Config->gaia->database->enabled);

                // Get method result from interceptor
                $methodResult = $Interceptor->{$methodName}($Exception);

                // Set result state
                $resultState = true;

                if (\is_array($methodResult)) {
                    $resultState = isset($methodResult["result"]) != false ? $methodResult["result"] : true;

                    if (isset($methodResult["result"])) {
                        unset($methodResult["result"]);
                    }
                }

                // Return result
                $result = array(
                    "result"    => $resultState,
                    "data"      => $methodResult
                );

                // Prevent caching
                \header("Cache-Control: no-cache");
                \header("Pragma: no-cache");
                \header("Expires: " . \gmdate(\DATE_RFC1123, \time() - 1));

                // Set json header
                \header("Content-type: application/json; charset=utf-8");

                // Send result
                echo \json_encode($result);
            }

            // Class doesn't exist
            else {
                // This is original PHP fatal error
                if ($Exception instanceof \Gaia\Utils\Object && $Exception->isFatalError()) {
                    // Show json error
                    \Gaia\Core\Exception\Handler::json($Exception);
                }

                // Error
                else {
                    // Default exception handler for JSON query
                    \set_exception_handler(array("\\Gaia\\Core\\Exception\\Handler", "json"));

                    // Throw again
                    throw new \Exception($Exception);
                }
            }
        }

        // Other request (Not JSON)
        else {
            // Get class name
            $className = $this->Config->gaia->dispatcher->controller->exception->view->namespace . "\\" .
                $this->Config->gaia->dispatcher->controller->exception->view->className;

            // Get method name
            $methodName = $this->Config->gaia->dispatcher->controller->exception->view->methodName;

            // Class exists
            if (\class_exists($className)) {
                // Execute interceptor
                $Interceptor = new $className(null, false, $this->Config->gaia->database->enabled);
                $Interceptor->{$methodName}($Exception);
            }

            // Class doesn't exist
            else {
                // This is original PHP fatal error
                if ($Exception instanceof \Gaia\Utils\Object && $Exception->isFatalError()) {
                    // Show normal error
                    \Gaia\Core\Exception\Handler::normal($Exception);
                }

                // Error
                else {
                    // Default exception handler for JSON query
                    \set_exception_handler(array("\\Gaia\\Core\\Exception\\Handler", "normal"));

                    // Throw again
                    throw new \Exception($Exception);
                }
            }
        }

        // Exit permanently
        exit();
    }

    /**
     * Get gaia instance
     *
     * @param null $stage
     *
     * @return \Gaia
     */
    final public static function getInstance($stage = null) {
        if (self::$oInstance == false) {
            self::$oInstance = new Gaia($stage);
        }

        return self::$oInstance;
    }

    /**
     * Get dispatcher object
     *
     * @return \Gaia\Core\Dispatcher
     */
    final public function getDispatcher() {
        return $this->Dispatcher;
    }

    /**
     * Get stage
     *
     * @return string
     */
    final public function getStage() {
        return $this->stage;
    }

    /**
     * Run framework
     */
    final public function run() {
        // Catch all fatal error generated directly from PHP
        \register_shutdown_function(function() {
            // Get last error
            $lastError = \error_get_last();

            // Got error - show exception using gaia exception handler
            if ($lastError != null) {
                // Set error 'type' as 'code'
                $lastError["code"] = $lastError["type"];

                // Set error flag (internal PHP exception)
                $lastError["isFatalError"] = true;

                // Handle exception via Gaia interface
                $this->handleException(new \Gaia\Utils\Object($lastError));
            }
        });

        // Catch all warnings and others error generated directly from PHP
        \set_error_handler(function($code, $message, $file, $line) {
            // Handle exception
            $this->handleException(new \Gaia\Utils\Object(array(
                "message"   => $message,
                "code"      => $code,
                "file"      => $file,
                "line"      => $line
            )));
        }, \E_ALL);

        // Try to initialize database and run dispatcher
        try {
            // Check database is enabled
            if ($this->Config->gaia->database->enabled) {
                // Try to initialize doctrine
                $Doctrine = \Gaia\Components\ORM\Doctrine::getInstance("database.ini", $this->Config->gaia->debug);

                // Is not initialized - throw new exception
                if ($Doctrine->isInitialized() == false) {
                    throw $Doctrine->getInitializeException();
                }
            }

            // Run dispatcher
            $this->Dispatcher->run();
        }

        // Got exception
        catch (\Exception $Exception) {
            // Catch exception
            $this->handleException($Exception);
        }
    }
}

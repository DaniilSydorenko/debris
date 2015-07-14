<?php
/*******************************************************************************
 * Name: App -> API -> Shortener
 * Version: 1.0
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Namespace
namespace App\API;

use App\Components\Shortener as ShortenerComponent;

/**
 * Shortener class
 */
class Shortener extends \Gaia\Controllers\JSON
{
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    private $method = null;

    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    private $endpoint = null;

    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    private $args = [];

    /**
     * Method: getMethod
     * Get type of Request Method
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Method: setMethod
     * Set type of Request Method
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Method: getEndpoint
     * Get working method, in my case short()
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Method: setEndpoint
     * Set working method, in my case short()
     * @param mixed $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $apiEndpoint = \explode('/', \rtrim($endpoint, '/'));
        $this->endpoint = \strtolower($apiEndpoint[2]);
    }

    /**
     * Method: setArgs
     * Set array with arguments from request
     * @param array $parameters
     */
    public function setArgs(array $parameters)
    {
        $this->args = $parameters;
    }

    /**
     * Method: getArgs
     * Get array with arguments from request
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Method: short
     * Check request method, get args from url and handles the data
     * In success case return shortened url in response
     */
    public function short()
    {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        // Set request method
        $this->setMethod($_SERVER['REQUEST_METHOD']);

        // Set request arguments
        $this->setArgs((array)$this->getRequest()->getParameters());

        // Set API endpoint
        $this->setEndpoint($this->getRequest()->getURI());

        // Allow POST & GET only
        switch ($this->getMethod()) {
            case 'GET':
            case 'POST':
                if ($this->getEndpoint() == "short") {
                    $this->_response('OK', 200);
                    $requestData = $this->_cleanInputs($this->getArgs());
                    $ShortenerComponent = new ShortenerComponent();
                    $shortenUrl = $ShortenerComponent->shortenUrl($requestData['url']);
                    return $shortenUrl;
                } else {
                    $this->_response('Invalid Path', 400);
                }
                break;
            case 'DELETE':
            case 'PUT':
                $this->_response('Invalid Method', 405);
                break;
            default:
                $this->_response('Invalid Method', 405);
                break;
        }
    }

    /**
     * Method: processAPI
     * Allow for CORS, assemble and pre-process the data
     */
    public function processAPI()
    {
        if (method_exists($this, $this->endpoint)) {
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        return $this->_response("No Endpoint: $this->endpoint", 404);
    }

    /**
     * Method: _response
     * Return HTTP response
     */
    private function _response($data, $status = 200)
    {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }

    /**
     * Method: _cleanInputs
     * Clean data
     * @param mixed $data
     * @return array|string
     */
    private function _cleanInputs($data)
    {
        $clean_input = [];
        if (\is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = \strtolower(\trim(\strip_tags($data)));
        }
        return $clean_input;
    }

    /**
     * Method: _requestStatus
     * @param integer $code
     */
    private function _requestStatus($code)
    {
        $status = [
            200 => 'OK',
            400 => 'Bad Request',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ];
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}

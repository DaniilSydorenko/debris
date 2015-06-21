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
 * @TODO Не важно, как выполнится запрос — Facebook всегда вернет нам код 200 OK.
 * @TODO откинуть все методы кроме GET, получить все прараметры, разбить на элементы массива
 * @TODO перевести в lowercase, допускать сразу до пяти урлов, ошибки возварашать в ответе
 * @TODO
 * @TODO
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
     * Property: $request
     *
     */
    private $request = null;

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Method: endpoint
     * The Model requested in the URI. eg: /files
     */
    public function setEndpoint()
    {
        $endpoint = $this->getRequest()->getURI();
        if (!empty($endpoint)) {
            $this->endpoint = explode('', \rtrim($endpoint), '/');
        }
    }

    /**
     * Method: endpoint
     * The Model requested in the URI. eg: /files
     */
    public function getEndpoint()
    {
        return $this->endpoint[2];
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
     * Return array with arguments from request
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Method: short
     * Return shortened urls
     * @param string $url
     */

    /**
     * Method: checkRequest
     * Allow for CORS, assemble and pre-process the data
     */
    public function short()
    {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->setMethod($_SERVER['REQUEST_METHOD']);
        $this->setArgs((array)$this->getRequest()->getParameters());

        switch ($this->getMethod()) {
        case 'GET':
                $endpoint = \strtolower($this->getEndpoint());

                if (empty($endpoint) && $endpoint == "short") {
                    $this->_response('Invalid Path', 400);
                } else {
                    $requestData = $this->request = $this->_cleanInputs($this->getArgs());
                    $this->_response('OK', 200);

                    // Защитить от написания лишнего
                    // или нправильного пути
                    // endpoint short
                    // или нправильного пути
                    // или нправильного пути


//                    return $response = [
//                        'urlViews' => $requestData['url']
//                    ];

                    $ShortenerComponent = new ShortenerComponent();
                    return $ShortenerComponent->shortenUrl($requestData['url']);
                }
            break;
        case 'DELETE':
        case 'POST':
        case 'PUT':
            $this->_response('Invalid Method', 405);
            break;
        default:
            $this->_response('Invalid Method', 405);
            break;
        }
    }

    /**
     * Method: short
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
     *
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
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    /**
     * Method: _requestStatus
     *
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

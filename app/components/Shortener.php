<?php
/*******************************************************************************
 * Name: App -> Components
 * Version: 1.0
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Components;

use Gaia\Components\ORM\Doctrine;
use App\Entities\Url;
use App\Components\Session as SessionComponent;

/**
 * Shortener class
 *
 * @TODO Кирилица в описании
 *
 */
class Shortener
{

    /**
     * Doctrine instance
     * @var $Doctrine null
     */
    private $Doctrine = null;


    /**
     * Constructor for Shortener Component
     * 1. Set Doctrine instance
     */
    public function __construct()
    {
        $this->Doctrine = Doctrine::getInstance();
    }

    /**
     * Base functionality of URL Shortener
     * @param $url
     * @return array
     */
    public function shortenUrl($url)
    {
        $responseFromValidation = $this->validateUrl($url);
        $response = [];

        switch ($responseFromValidation) {
            case 001 :
                return $response = [
                    'response' => $this->_errorCode(001)
                ];
                break;

            case 002 :
                return $response = [
                    'response' => $this->_errorCode(002)
                ];
                break;

            case 003 :
                return $response = [
                    'response' => $this->_errorCode(003)
                ];
                break;

            case 004 :
                return $response = [
                    'response' => $this->_errorCode(004)
                ];
                break;

            default:

                // Try to find url
                $Url = $this->Doctrine->getRepository("App\\Models\\Url")->findOneBy([
                    "url" => $responseFromValidation
                ]);

                if ($Url instanceof \App\Entities\Url) {
                    // Add short url to cookie
                    SessionComponent::getInstance(null, $Url->getShortUrl());
                    return $response = [
                        'shortUrl'    => $Url->getShortUrl(),
                        'description' => $Url->getDescription(),
                        'longUrl'     => $responseFromValidation,
                        'urlViews'    => $Url->getViews()
                    ];
                } else {

                    // Set short url path
                    $rootPath = 'http://' . \getenv('HTTP_HOST') . \dirname(\getenv('SCRIPT_NAME'));

                    // Set short url key
                    $shortUrl = $rootPath . \substr(md5(uniqid(rand(), 1)), 0, 4);

                    // Get url description and set no more than 300 symbols in UTF-8 and trim from spaces
                    $siteDescription = $this->getSiteDescription($responseFromValidation);
                    if (empty($siteDescription) && mb_strlen($siteDescription) > 300) {
                        $siteDescription = $responseFromValidation;
                    }

                    // Set hash (for future pass)
                    $hash = \sha1(\md5(\uniqid()));

                    // Miscellaneous::getClientIp()  ??????

                    $userIp = '';
                    if (\getenv('HTTP_CLIENT_IP'))
                        $userIp = getenv('HTTP_CLIENT_IP');
                    else if (\getenv('HTTP_X_FORWARDED_FOR'))
                        $userIp = getenv('HTTP_X_FORWARDED_FOR');
                    else if (\getenv('HTTP_X_FORWARDED'))
                        $userIp = getenv('HTTP_X_FORWARDED');
                    else if (\getenv('HTTP_FORWARDED_FOR'))
                        $userIp = getenv('HTTP_FORWARDED_FOR');
                    else if (\getenv('HTTP_FORWARDED'))
                        $userIp = getenv('HTTP_FORWARDED');
                    else if (\getenv('REMOTE_ADDR'))
                        $userIp = getenv('REMOTE_ADDR');
                    else
                        $userIp = 'UNKNOWN';

                    // Try to save
                    $result = $this->setShortUrl($responseFromValidation, $shortUrl, $siteDescription, $hash, $userIp);
                    $responseResult = (empty($result)) ? $shortUrl : $result;

                    // Add short url to cookie
                    if (\strpos($responseResult, "debris")) {
                        SessionComponent::getInstance(null, $responseResult);
                    }

                    return $response = [
                        'shortUrl' => $responseResult,
                        'description' => $siteDescription,
                        'longUrl' => $responseFromValidation,
                        'urlViews' => 0
                    ];
                }
                break;
        }
    }

    /**
     * Check for duplicated by system url key
     *
     * @param $url
     * @internal param $shortUrl
     * @internal param $rootPath
     * @return null|string
     */
//    protected function duplicatedUrlKey($shortUrl, $rootPath)
//    {
//        $DuplicatedUrl = $this->getDoctrine()->getRepository('AcmeUrlBundle:Urls')->findOneBy(["shortUrl" => $shortUrl]);
//        if ($DuplicatedUrl instanceof \Acme\UrlBundle\Entity\Urls) {
//            return $shortUrl = $rootPath . \substr(md5(uniqid(rand(),1)),0,4);
//        } else {
//            return null;
//        }
//    }

    /**
     * Get site tile:
     * 1. Check encoding
     * 2. Set length - 300 symbols
     *
     * @param $url
     * @return null|string
     */
    private function getSiteDescription($url)
    {
        $siteDescription = null;
        $agent = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';;

        $ch = \curl_init();
        \curl_setopt($ch, CURLOPT_URL, $url);
        \curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        \curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $htmlData = \curl_exec($ch);

        if (!\curl_errno($ch)) {

            if (\strlen($htmlData) > 0) {
                $res = preg_match('/<title>(.*)<\/title>/siU', $htmlData, $title_matches);
                if (!$res) {
                    return null;
                } else {
                    // Clean up title: remove EOL's and excessive whitespace
                    // and convert html entities to usual text symbols
                    $title = \html_entity_decode(\trim(\preg_replace('/\s+/', ' ', $title_matches[1])));

                    // If url not in utf-8 convert to utf-8
                    if (mb_detect_encoding($title, 'UTF-8', true) === false) {

                        /*
                         * @TODO LANGUAGES
                         * Big trouble with encoding
                         * A lot of languages should be handle here
                         */

                        $encodedSiteTitle = \mb_convert_encoding($title, "utf-8", "windows-1251");
                        $siteDescription = \mb_substr($encodedSiteTitle, 0, 300, 'UTF-8');
                    } else {
                        $siteDescription = \mb_substr(\trim($title), 0, 300, 'UTF-8');
                    }

                    return $siteDescription;
                }
            }
        } else {
            return null;
        }
        curl_close($ch);

          //@TODO Убрать HTML символы
          // Адрес с лишним слешом выдает ошибку - http://developerslife.ru/1242/ !!!
    }

    /**
     * Validate url in two steps:
     * 1. Check length
     * 2. Trim url
     * 3. Check structure
     * 4. Check for Debris domain
     *
     * @param $url
     * @return int|string
     */
    private function validateUrl($url)
    {
        // Check if url string longer than 1000 symbols
        if (\mb_strlen($url, 'UTF-8') < 1000) {

            // Cut spaces
            $urlClear = \trim($url);

            // Check if it is correct url
            if (\preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $urlClear)) {

                // Check if url has debris domain
                if (\strpos($urlClear, "debris.dev")) {
                    return 003;
                } else {
                    return $urlClear;
                }
            } else {
                return 002;
            }
        } else {
            return 001;
        }
    }

    /**
     * Save short url with parameters
     *
     * @param $url
     * @param $shortUrl
     * @param $description
     * @param $hash
     * @param $userIp
     * @return null|string
     */
    private function setShortUrl($url, $shortUrl, $description, $hash, $userIp)
    {
        // Create new url
        $Url = new Url();
        $Url->setUrl($url);
        $Url->setShortUrl($shortUrl);
        $Url->setDescription($description);
        $Url->setHash($hash);
        $Url->setIp($userIp);
        try {
            $this->Doctrine->persist($Url);
            $this->Doctrine->flush();

            return null;
        } catch (\Exception $Exception) {
            $Error = new \Exception(\App\Libraries\Error\Code::CAN_NOT_SAVE);
            return $Error->getMessage();
        }
    }

    /**
     * Method: _requestStatus
     *
     * @param integer $code
     */
    private function _errorCode($code)
    {
        $status = [
            001 => "Your url bigger than 1000 symbols.",
            002 => "We are so sorry, but you url is invalid.",
            003 => "Wazzup, this is a Debris shortened url.",
            004 => "This page does not exists",
            005 => 'Internal Server Error',
        ];
        return ($status[$code]) ? $status[$code] : $status[005];
    }
}

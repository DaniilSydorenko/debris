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

/**
 * Shortener class
 *
 * @TODO Кирилица в описании
 * @TODO Дубликация ключей
 * @TODO CURL вместо header
 * @TODO Возврат descripion при помощи get_meta_tags
 * @TODO Возврат 0 или 1 или 2
 * @TODO Сессия в Main и провер ка в JSON
 * @TODO
 *
 */
class Shortener
{

    public function shortenUrl($url)
    {
        // Validate url
        $validUrl = $this->validateUrl($url);

        if ($validUrl && $validUrl !== "debris") {

            $Doctrine = Doctrine::getInstance();

            $Url = $Doctrine->getRepository("App\\Models\\Url")->findOneBy(["url" => $url]);

            $response = '';

            // If url exists - send data to user
            if ($Url instanceof \App\Entities\Url) {
                return $response = [
                    'response' => $Url->getShortUrl(),
                    'longUrl'  => $url,
                    'urlViews' => $Url->getViews()
                ];
            } else {
                // Set short url path
                $rootPath = 'http://'. \getenv('HTTP_HOST') . \dirname(\getenv('SCRIPT_NAME'));
                $shortUrl = $rootPath . \substr(md5(uniqid(rand(),1)),0,4);

                // If key is duplicated - generating new key till will find the original one
//                do {
//                    $duplicatedUrlKey = $this->duplicatedUrlKey($shortUrl, $rootPath);
//                    if (!$duplicatedUrlKey) {
//                        break;
//                    }
//                } while ($duplicatedUrlKey);

                // Set hash(for future, maybe a password ??)
                $hash = \sha1(\md5(\uniqid()));

                // Try to get the client ip address
                $userIp = '';

                if (\getenv('HTTP_CLIENT_IP'))
                    $userIp = getenv('HTTP_CLIENT_IP');
                else if(\getenv('HTTP_X_FORWARDED_FOR'))
                    $userIp = getenv('HTTP_X_FORWARDED_FOR');
                else if(\getenv('HTTP_X_FORWARDED'))
                    $userIp = getenv('HTTP_X_FORWARDED');
                else if(\getenv('HTTP_FORWARDED_FOR'))
                    $userIp = getenv('HTTP_FORWARDED_FOR');
                else if(\getenv('HTTP_FORWARDED'))
                    $userIp = getenv('HTTP_FORWARDED');
                else if(\getenv('REMOTE_ADDR'))
                    $userIp = getenv('REMOTE_ADDR');
                else
                    $userIp = 'UNKNOWN';

                // Try to save
                $result = $this->setShortUrl($url, $shortUrl, $hash, $userIp);
                $Url = $Doctrine->getRepository("App\\Models\\Url")->findOneBy(["url" => $url]);
                $responseResult = (!empty($result)) ? $result : $shortUrl;

                return $response = [
                    'response' => $responseResult,
                    'longUrl'  => $url,
                    'urlViews' => $Url->getViews()
                ];

            }
        } else if ($validUrl && $validUrl === "debris") {
            return $response = [
                'response' => "Wazzup, this is a Debris shortened URL :)"
            ];
        } else {
            return $response = [
                'response' => "We are so sorry, but you URL is invalid!"
            ];
        }
    }

    /**
     * Check for duplicated by system url key
     *
     * @param $shortUrl
     * @param $rootPath
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
     * Validate url in two steps:
     * 1. Check by regExp
     * 2. If structure is ok - check if this url was not in Debris SNR
     * 3. If was not - send request on this url
     *
     * @param $url
     * @return string|bool
     */
    protected function validateUrl($url)
    {
        if (\preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $url)) {
            // If was shortered by Debris
            $strinurl = \strpos($url, "debris.dev");

            if ($strinurl) {
                return "debris";
            } else {
                // Send request
                $file_headers = @\get_headers($url);

                // Return true if found 200 in the response
                return (\strpos($file_headers[0],"200")) ? true : false;
            }
        } else {
            return false;
        }
    }

    /**
     * Save short url with parameters
     *
     * @param $url
     * @param $shortUrl
     * @param $hash
     * @param $userIp
     * @return null|string
     */
    protected function setShortUrl($url, $shortUrl, $hash, $userIp)
    {
        // Create new URL
        $Url = new Url();
        $Url->setUrl($url);
        $Url->setShortUrl($shortUrl);
        $Url->setViews(0);
        $Url->setHash($hash);
        $Url->setIp($userIp);

        $Doctrine = Doctrine::getInstance();


        // Save to db
        try {
            $EM = $Doctrine->getEntityManager();
            $EM->persist($Url);
            $EM->flush();
            return null;
        } catch (\Exception $Exception) {
            $Error = new \Exception(\App\Libraries\Error\Code::CAN_NOT_SAVE);
            return $Error->getMessage();
        }
    }
}
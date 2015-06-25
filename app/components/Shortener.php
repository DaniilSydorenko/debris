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
 * @TODO Сессия в Main и провер ка в JSON
 *
 */
class Shortener
{
    /**
     * @param $url
     * @return array
     */
    public function shortenUrl($url)
    {
        switch ($this->validateUrl($url)) {
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
                // If last symbol is "/" - just return url, if no - return url + "/"
                // Need to make "http://url.com" === "http://url.com/"
                $urlFiltered = (\mb_substr($url, -1) == '/') ? \mb_strtolower($url) : \mb_strtolower($url) . '/';
                $Doctrine = Doctrine::getInstance();

                // Try to find url
                $Url = $Doctrine->getRepository("App\\Models\\Url")->findOneBy(["url" => $urlFiltered]);
                $response = '';
                if ($Url instanceof \App\Entities\Url) {
                    return $response = [
                        'response' => $Url->getShortUrl(),
                        'description' => $Url->getDescription(),
                        'longUrl' => $url,
                        'urlViews' => $Url->getViews()
                    ];
                } else {

                    // Set short url path
                    // Разобраться почему иногда генерит --> http://www.debrs.com
                    $rootPath = 'http://' . \getenv('HTTP_HOST') . \dirname(\getenv('SCRIPT_NAME'));

                    // Set short url key
                    $shortUrl = $rootPath . \substr(md5(uniqid(rand(), 1)), 0, 4);

                    // Get url description and set no more than 300 symbols in UTF-8 and trim from spaces
                    //@TODO Eсть сайты где нету description !!!!!!!!!!
                    //@TODO BUG --> http://vindavoz.ru/win_obwee/411-krakozyabry-vmesto-russkih-bukv.html
                    //@TODO BUG --> алохо русский записало

                    // Site title
                    $siteTitle = $this->getSiteDescription($urlFiltered);

                    // If key is duplicated - generating new key till will find the original one
//                do {
//                    $duplicatedUrlKey = $this->duplicatedUrlKey($shortUrl, $rootPath);
//                    if (!$duplicatedUrlKey) {
//                        break;
//                    }
//                } while ($duplicatedUrlKey);

                    // Set hash(for future, maybe a password ??)
                    $hash = \sha1(\md5(\uniqid()));

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
                    $result = $this->setShortUrl($urlFiltered, $shortUrl, $siteTitle, $hash, $userIp);
                    $responseResult = (empty($result)) ? $shortUrl : $result;

                    return $response = [
                        'response' => $responseResult,
                        'description' => $siteTitle,
                        'longUrl' => $url,
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
    protected function getSiteDescription($url)
    {
        $siteTitle = null;

        try {
            $opts = ['http' => ['header' => "User-Agent:MyAgent/1.0\r\n"]];
            $context = \stream_context_create($opts);
            $header = \file_get_contents($url, false, $context);
        } catch (\Exception $Exception) {
            $siteTitle = null;
        }


        // Get page source
        if (!$header) return false;

        // ERROR!!!
        // http://developerslife.ru/1242/
        // "file_get_contents(http://developerslife.ru/1242/): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found"

        // Subtract title
        if (preg_match("|<[s]*title[s]*>([^<]+)<[s]*/[s]*title[s]*>|Ui", $header, $t)) {
            $siteTitle = trim($t[1]);
        }

        if ($siteTitle) {
            // If url not in utf-8 convert to utf-8
            if (mb_detect_encoding($siteTitle, 'UTF-8', true) === false) {

                /*
                 * @TODO LANGUAGES
                 * Big trouble with encoding
                 * A lot of langs should be handle here
                 */

                $encodedSiteTitle = \mb_convert_encoding($siteTitle, "utf-8", "windows-1251");
                $siteTitle = \mb_substr(\trim($encodedSiteTitle), 0, 300, 'UTF-8');
            } else {
                $siteTitle = \mb_substr(\trim($siteTitle), 0, 300, 'UTF-8');
            }
        } else {
            $siteTitle = $url;
        }

        return $siteTitle;
    }

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
        // здесь тоже валидацию по последнему слешу

        if (\mb_strlen($url, 'UTF-8') < 1000) {
            if (\preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $url)) {

                //@TODO А если запиздолят просто слово debris в строке ??
                // фейковый урл со словом debris

                $urlDebris = \strpos(\mb_strtolower($url), "debris");

                if ($urlDebris) {
                    return 003;
                } else {
                    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HEADER, true);
                    curl_setopt($ch, CURLOPT_NOBODY, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    $document = curl_exec($ch);

                    $response = explode("\n", $document);

                    //@TODO Может возвращать валидированный линк ??
                    //@TODO Обрезать в конце знаки ??

                    // Может возвращать html страницы здесь, точнее раз делаю запрос курлом
                    // и проверю урл здесь, то можно возварщать массив с урлом и тайтлом отсюда
                    // из валидейшена

                    if (\strpos($response[0], "200")) {
                        return $url;
                    } else {
                        return 004;
                    }
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
    protected function setShortUrl($url, $shortUrl, $description, $hash, $userIp)
    {
        // Create new url
        $Url = new Url();
        $Url->setUrl($url);
        $Url->setShortUrl($shortUrl);
        $Url->setDescription($description);
        $Url->setViews(0);
        $Url->setHash($hash);
        $Url->setIp($userIp);
        $Doctrine = Doctrine::getInstance();
        try {
            $Doctrine->persist($Url);
            $Doctrine->flush();
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
            001 => "Your url bigger than 1000 signs. It is so strange, yeah?",
            002 => "We are so sorry, but you url is invalid.",
            003 => "Wazzup, this is a Debris shortened url.",
            004 => "This page does not exists",
            005 => 'Internal Server Error',
        ];
        return ($status[$code]) ? $status[$code] : $status[005];
    }
}

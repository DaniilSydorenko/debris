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
        $validUrl = $this->validateUrl($url);

        switch ($validUrl) {
            case 0 :
                return $response = [
                    'response' => "Your url bigger than 1000 signs. It is so strange, yeah?"
                ];
                break;

            case 1 :
                return $response = [
                    'response' => "We are so sorry, but you url is invalid."
                ];
                break;

            case 2 :
                return $response = [
                'response' => "Wazzup, this is a Debris shortened url."
            ];
                break;

            case 3 :
                // If last symbol is "/" - just return url, if no - return url + "/"
                // Need to make "http://url.com" === "http://url.com/"
                $urlFiltered = (\mb_substr($url, -1) == '/') ? \mb_strtolower($url) : \mb_strtolower($url) . '/';
                $Doctrine = Doctrine::getInstance();

                // Try to find url
                $Url = $Doctrine->getRepository("App\\Models\\Url")->findOneBy(["url" => $urlFiltered]);
                $response = '';
                if ($Url instanceof \App\Entities\Url) {
                    return $response = [
                        'response'    => $Url->getShortUrl(),
                        'description' => $Url->getDescription(),
                        'longUrl'     => $url,
                        'urlViews'    => $Url->getViews()
                    ];
                } else {
                    // Set short url path
                    $rootPath = 'http://'. \getenv('HTTP_HOST') . \dirname(\getenv('SCRIPT_NAME'));

                    // Set short url key
                    $shortUrl = $rootPath . \substr(md5(uniqid(rand(),1)),0,4);

                    // Get url description and set no more than 300 symbols in UTF-8 and trim from spaces
                    $tagDescription = \get_meta_tags($urlFiltered);
                    if (isset($tagDescription['description'])) {
                        $urlDescription = \mb_substr(\trim($tagDescription['description']), 0 , 300, 'UTF-8');
                    } else {
                        $urlDescription = $urlFiltered;
                    }

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
                    $result = $this->setShortUrl($urlFiltered, $shortUrl, $urlDescription, $hash, $userIp);
                    $Url = $Doctrine->getRepository("App\\Models\\Url")->findOneBy(["url" => $url]);
                    $responseResult = (empty($result)) ? $shortUrl : $result;

                    return $response = [
                        'response'    => $responseResult,
                        'description' => $urlDescription,
                        'longUrl'     => $url,
                        'urlViews'    => 0
                    ];
                }
                break;
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
        // здесь тоже валидацию по последнему слешу

        if (\mb_strlen($url, 'UTF-8') < 1000) {
            if (\preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $url)) {

                //@TODO А если запиздолят просто слово debris в строке ??
                $urlDebris = \strpos(\mb_strtolower($url), "debris");

                if ($urlDebris) {
                    return 2;
                } else {
                    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_USERAGENT,      $agent);
                    curl_setopt($ch, CURLOPT_URL,            $url);
                    curl_setopt($ch, CURLOPT_HEADER,         true);
                    curl_setopt($ch, CURLOPT_NOBODY,         true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT,        15);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    $document = curl_exec($ch);
                    $document = explode("\n", $document);

                    //@TODO Может возвращать валидированный линк ??
                    //@TODO Обрезать в конце знаки ??

                    return (\strpos($document[0],"200")) ? 3 : 0;
                }
            } else {
                return 1;
            }
        } else {
            return 0;
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
}

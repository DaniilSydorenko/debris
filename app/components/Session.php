<?php
/*******************************************************************************
 * Name: Session
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Components;

use Gaia\Components\ORM\Doctrine;
use Gaia\Utils\Miscellaneous;
use App\Components\Shortener as ShortenerComponent;
use App\Entities\Url;


/**
 * Class Session
 */
class Session
{
    // Instance of doctrine
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $Doctrine = null;

    // Session id
    protected $sessionId = false;

    // Session data
    protected $sessionData = false;

    // Session lifetime (in seconds) - default 14 days
    protected $sessionLifetime = 1209600;

    // Domain
    protected $domain = null;

    // Urls
    protected $anonimUrls = null;

    // Session variable name
    protected $sessionVariableName = "sessionId";

    private $anonimUrlsCookieName = "anonimUrls";

    // Instance of this class
    private static $oInstance = false;

    private $latestUrls = null;


    /**
     * Get instance of session object
     *
     * @static
     * @param null $domain
     * @param null $url
     * @return \App\Components\Session
     */
    public static function getInstance($domain = null, $url = null)
    {
        if (self::$oInstance == false) {
            self::$oInstance = new Session($domain, $url);
        }

        return self::$oInstance;
    }

    /**
     * Default constructor
     *
     * @param null $domain
     * @param null $url
     */
    private function __construct($domain = null, $url = null)
    {
        // Prepare cookies
        foreach ($_COOKIE as $Key => $Value) {
            if (\array_key_exists($Key, $_REQUEST)) {
                unset($_REQUEST[$Key]);
            }

            if (\array_key_exists($Key, $_GET)) {
                $_COOKIE[$Key] = $_GET[$Key];
            }

            if (\array_key_exists($Key, $_POST)) {
                $_COOKIE[$Key] = $_POST[$Key];
            }
        }

        // Set domain
//        $this->domain = $domain;
//
        // Get doctrine instance
        $this->Doctrine = Doctrine::getInstance();
//
//        // Clean up, set id, prepare session
//        $this->cleanUp()
//
//;

        if (isset($_COOKIE[$this->anonimUrlsCookieName])) {
            $this->setLatestUrls($_COOKIE[$this->anonimUrlsCookieName]);

        }
//        print_r($latestUrls); die;

        // Set session id
        $this->generateSessionId();
//        var_dump($url); die;

        if ($url) {

        }
//        var_dump($url);


        // Prepare session
        $this->prepareSession($url);
    }

    /**
     * Get client browser
     *
     * @return mixed
     */
    private function getClientBrowser()
    {
        return isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "Unknown";
    }

    /**
     * Generate session id
     */
    private function generateSessionId()
    {
        // Reset session id
        $this->sessionId = false;

        // Read session id from cookies - if defined
        if (isset($_COOKIE[$this->sessionVariableName]) && (\strlen($_COOKIE[$this->sessionVariableName]) > 0)) {
            $this->sessionId = $_COOKIE[$this->sessionVariableName];
        } // Try to read session id from request - if defined
        else if (isset($_REQUEST[$this->sessionVariableName]) && (\strlen($_REQUEST[$this->sessionVariableName]) > 0)) {
            $this->sessionId = $_REQUEST[$this->sessionVariableName];
        } // Generate session id
        else {
            $this->sessionId = $this->getRandomSessionId();
        }
    }

    private function setAnonimCookie($url)
    {
        if (isset($_COOKIE[$this->anonimUrlsCookieName])) {
            if (strpos($_COOKIE[$this->anonimUrlsCookieName], $url) === false) {
                $setWithNewUrl = $_COOKIE[$this->anonimUrlsCookieName] . "," . $url;
                setcookie($this->anonimUrlsCookieName, $setWithNewUrl, time() + (86400 * 30), "/"); // 86400 = 1 day
            }
        } else {
            setcookie($this->anonimUrlsCookieName, $url, time() + (86400 * 30), "/"); // 86400 = 1 day
        }
    }

    /**
     * Clean up session
     */
    private function cleanUp()
    {
        // Date / time
        $DateTime = new \DateTime();

        // Create query builder
        $Query = $this->Doctrine->createQuery("SELECT Session from \\App\\Models\\Session Session where Session.valid < :timestamp");

        // Add query parameters
        $Query->setParameter("timestamp", $DateTime->getTimestamp());

        // Get sessions
        $Sessions = $Query->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);

        // Got some old sessions
        if (\count($Sessions) > 0) {
            // Remove old session
            foreach ($Sessions as &$Session) {
                // Delete session
                $this->Doctrine->remove($Session);
            }

            // Flush changes
            $this->Doctrine->flush();
        }
    }

    /**
     * Get random session id
     *
     * @return string
     */
    private function getRandomSessionId()
    {
        // Get current date-time
        $Now = new \DateTime();

        // Return new unique session id
        return \md5(\uniqid($Now->getTimestamp(), true) . Miscellaneous::getClientIp() . $this->getClientBrowser());
    }

    /**
     * Prepare session
     * @param null $url
     */
    private function prepareSession($url)
    {
//        var_dump($url); die;
        // Get current date-time
        $Now = new \DateTime();

        // Session id is not set - try to set session id
        if (!$this->sessionId) {
            $this->generateSessionId();
        }

        // Try to find session by session id
//        $Session = $this->Doctrine->getRepository("\\App\\Models\\Session")->findOneBy(array(
//            "sessionId" => $this->sessionId
//        ));

        // Session not found
//        if ($Session === null) {
//
////            $User = $this->Doctrine->getRepository("App\\Models\\User")->findOneBy(array("id" => 1));
//
//            // Create new session
//            $NewSession = new \App\Models\Session();
//
//            // Set session properties
//            $NewSession->setSessionId($this->sessionId);
//            $NewSession->setIp(Miscellaneous::getClientIp());
//            $NewSession->setBrowser((string)$this->getClientBrowser());
//            $NewSession->setValid($Now->getTimestamp() + $this->sessionLifetime);
//            $NewSession->setData("");
////            $NewSession->setUsers($User);
//
//            // Save session
//            $this->Doctrine->persist($NewSession);
//            $this->Doctrine->flush();
//        } // Session exist
//        else {
//            // Set valid
//            $Session->setValid($Now->getTimestamp() + $this->sessionLifetime);
//
//            // Save session
//            $this->Doctrine->flush();
//
//            // Un-serialize session data
//            $this->sessionData = \unserialize($Session->getData());
//        }

        // Start session (required for external libraries like facebook ..etc)
//        \session_start();

        // Set session id in cookies
        $_COOKIE[$this->sessionVariableName] = $this->sessionId;

        // Set cookie without domain
        if ($this->domain === null) {
            \setcookie($this->sessionVariableName, $this->sessionId, $Now->getTimestamp() + $this->sessionLifetime, "/");

//            $Shortener = new ShortenerComponent();
//
//            \setcookie("anonimUrls", , $Now->getTimestamp() + $this->sessionLifetime, "/");
        } // Set cookie with domain
        else {
            \setcookie($this->sessionVariableName, $this->sessionId, $Now->getTimestamp() + $this->sessionLifetime, "/", $this->domain);
        }

        if ($url) {
//            var_dump("dfg"); die;
            $this->setAnonimCookie($url);
        }
    }


    /**
     * Get session id
     *
     * @return string
     */
    public function getId()
    {
        return $this->sessionId;
    }

    /**
     * Set session lifetime (in seconds)
     *
     * @param $sessionLifetime
     */
    public function setLifetime($sessionLifetime)
    {
        $this->sessionLifetime = $sessionLifetime;
    }

    /**
     * Get session lifetime (in seconds)
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->sessionLifetime;
    }

    /**
     * Write data to session
     *
     * @param $name
     * @param $value
     * @return bool
     */
    public function write($name, $value)
    {
        // Session id doesn't exist - try to generate new one
        if (!$this->sessionId) {
            $this->generateSessionId();
        }

        /**
         * @var $Session \App\Models\Session
         */
        // Try to find session by session id
        $Session = $this->Doctrine->getRepository("\\App\\Models\\Session")->findOneBy(array(
            "sessionId" => $this->sessionId
        ));

        // Session doesn't exist - return false
        if ($Session === null) {
            return false;
        }

        // Set session data
        $this->sessionData[$name] = $value;

        // Serialize session
        $Session->setData(\serialize($this->sessionData));

        // Update UserId field
        if ("User" == $name && \is_array($value) && isset($value["id"])) {
            if ($User = $this->Doctrine->getRepository("\\App\\Models\\User")->findOneBy(["id" => $value["id"]])) {
                $Session->setUsers($User);
            }
        }

        // Save session data
        $this->Doctrine->flush();

        // Return result
        return true;
    }

    /**
     * Read data from session
     *
     * @param $name
     * @return mixed|null
     */
    public function read($name)
    {
        return isset($this->sessionData[$name]) ? $this->sessionData[$name] : null;
    }

    /**
     * Delete data from session
     *
     * @param $name
     * @return bool
     */
    public function delete($name)
    {
        // Try to find session by session id
        $Session = $this->Doctrine->getRepository("\\App\\Models\\Session")->findOneBy([
            "sessionId" => $this->sessionId
        ]);

        // Session doesn't exist - return false
        if ($Session === null) {
            return false;
        }

        // Remove selected element from session data
        if (\is_array($this->sessionData)) {
            if (\array_key_exists($name, $this->sessionData)) {
                unset($this->sessionData[$name]);
            }
        }

        // Update userId field
        if ("User" == $name) {
            $Session->setUsers(null);
        }

        // Serialize session data
        $Session->setData(\serialize($this->sessionData));

        // Save session data
        $this->Doctrine->flush();

        // Return result
        return true;
    }

    /**
     * Destroy session
     *
     * @return bool
     */
    public function destroy()
    {

        // Session id doesn't exist - try to generate new one
        if (!$this->sessionId) {
            $this->generateSessionId();
        }

        // Try to find session by session id
        $Session = $this->Doctrine->getRepository("\\App\\Models\\Session")->findOneBy(array(
            "sessionId" => $this->sessionId
        ));

        // Session doesn't exist - return false
        if ($Session === null) {
            return false;
        }

        // Unset cookie and session data
        \setcookie($this->sessionVariableName, "", null, "/");

        // Unset session data
        unset($this->sessionData);

        // Unset cookie if is set
        if (isset($_COOKIE[$this->sessionVariableName])) {
            unset($_COOKIE[$this->sessionVariableName]);
        }

        // Delete session
        $this->Doctrine->remove($Session);
        $this->Doctrine->flush();

        // Remove PHP session from cookie
        $_SESSION = array();

        // Clear all sessions variables
        \session_unset();

        // Return result
        return true;
    }

    /**
     * Logout users
     *
     * @param int[] $userIds
     */
    public function logoutUsers($userIds)
    {
        if (!\is_array($userIds)) {
            $userIds = [$userIds];
        }

        // Create query builder
        $QB = $this->Doctrine->createQueryBuilder();

        $QB->delete("\\App\\Models\\Session", "Session");
        $QB->where($QB->expr()->in("Session.User", $userIds));

        $QB->getQuery()->execute();
    }


    /**
     * @return null
     */
    public function getLatestUrls()
    {
        // @TODO get latest url with long url and description

        if (!empty($this->latestUrls)) {
            $latestUrlsArray = \explode(",", $this->latestUrls);

            $usersUrls = [];

            foreach ($latestUrlsArray as $key => $url) {

//                $Url = $this->Doctrine->getRepository("App\\Models\\Url")->findOneBy(["url" => "http://php.net/manual/ru/features.cookies.php"]);
//                var_dump($Url); die;

                /**
                 * @var $Url \App\Entities\Url
                 */
                $Url = $this->Doctrine->getRepository("\\App\\Models\\Url")->findOneBy(["shortUrl" => $url]);


                $usersUrls[$key] = [
                    "shortUrl" => $Url->getShortUrl(),
                    "url" => $Url->getUrl(),
                    "description" => $Url->getDescription()
                ];
            }

            return $usersUrls;

        } else {
            return null;
        }
    }

    /**
     * @param null $latestUrls
     */
    public function setLatestUrls($latestUrls)
    {
        $this->latestUrls = $latestUrls;
    }

}

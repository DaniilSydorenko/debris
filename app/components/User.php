<?php
/*******************************************************************************
 * Name: User authorization component
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Components\Authorization;
use Gaia\Components\ORM\Doctrine;


/**
 * User authorization
 */
class User
{
    // Session object instance
	private $Session = null;

    // Doctrine
    private $Doctrine = null;


	/**
	 * Default constructor
	 */
	public function __construct() {
        // Set session
		$this->Session = \App\Components\Session\Session::getInstance();

        // Set doctrine
        $this->Doctrine = Doctrine::getInstance();
	}

	/**
	 * Login
	 *
	 * @param $email
	 * @param $password
	 * @throws \Exception
	 * @return bool
	 */
	public function login($email, $password) {
        /**
         * Get user
         * @var $User \App\Models\User
         */
        $User = $this->Doctrine->getRepository("App\\Models\\User")->findOneBy(array("email" => $email));

		if ($User === null || $User->isDeleted()) {
			return null;
		}

        // User is not activated
        if ($User->isEnabled() == false) {
            throw new \Exception("User is not enabled.", \App\Libraries\Error\Code::USER_IS_NOT_ENABLED);
        }

        // Password mismatch
        if ($User->getPassword() != \sha1($User->getPasswordSalt() . $password)) {
            return null;
        }

        // Save only user id
        $userAsArray = array("id" => $User->getId());

        // Write session
		$this->Session->write("User", $userAsArray);

		return $User;
	}

    /**
     * Logout
     *
     * @return mixed
     */
	public function logout() {
		return $this->Session->destroy();
	}

    /**
     * Get current user
     *
     * @return mixed
     */
	public function get() {
		$sessionDataArray = $this->Session->read("User");

		if ($sessionDataArray) {
			// User repository
            $UserRepository = $this->Doctrine->getRepository("App\\Models\\User");

            // Current user
            $CurrentUser = $UserRepository->findOneBy(array("id" => (int)$sessionDataArray['id']));

			if ($CurrentUser !== null) {
                // Return current user
				return $CurrentUser;
			}
		}

		return null;
	}

    /**
     * Check user is logged in
     *
     * @return bool
     */
	public function isLoggedIn() {
		if (!$this->get()) {
			return false;
		}

		return true;
	}

    /**
     * Check user is valid
     *
     * @param $email
     * @param $password
     * @return bool
     */
	public function isValid($email, $password) {
		// User repository
        $UserRepository = $this->Doctrine->getRepository("App\\Models\\User");

        // User
        $User = $UserRepository->findOneByEmail($email);

		// Password mismatch
		if ($User->getPassword() != \sha1($User->getPasswordSalt() . $password)) {
			return false;
		}

		if ($User === null) {
			return false;
		}

		return true;
	}
}

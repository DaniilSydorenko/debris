<?php
/*******************************************************************************
 * Name: Entity -> Url
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Entities;


/**
 * Url
 *
 * @Table(name="urls")
 * @MappedSuperClass(repositoryClass="\App\Repositories\Url")
 * @HasLifecycleCallbacks
 */
class Url
{
	/**
	 * @var integer $id
	 *
	 * @Column(name="`id`", type="integer", nullable=false)
	 * @Id
	 * @GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string $url
	 *
	 * @Column(name="`url`", type="string", length=2048, nullable=false)
	 */
	private $url;

	/**
	 * @var string $shortUrl
	 *
	 * @Column(name="`short_url`", type="string", length=512, nullable=false)
	 */
	private $shortUrl;

	/**
	 * @var string $description
	 *
	 * @Column(name="`description`", type="string", length=2048, nullable=false)
	 */
	private $description;

	/**
	 * @var string $hash
	 *
	 * @Column(name="`hash`", type="string", length=256, nullable=false)
	 */
	private $hash;

	/**
	 * @var string $ip
	 *
	 * @Column(name="`ip`", type="string", length=45, nullable=false)
	 */
	private $ip;

	/**
	 * @var integer $views
	 *
	 * @Column(name="`views`", type="integer", nullable=false)
	 */
	private $views = 0;

	/**
	 * @var datetime $date
	 *
	 * @Column(name="`date`", type="datetime", nullable=false)
	 */
	private $date;


	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set url
	 *
	 * @param string $url
	 * @return \App\Entities\Url
	 */
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}

	/**
	 * Get url
	 *
	 * @return string 
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Set shortUrl
	 *
	 * @param string $shortUrl
	 * @return \App\Entities\Url
	 */
	public function setShortUrl($shortUrl) {
		$this->shortUrl = $shortUrl;
		return $this;
	}

	/**
	 * Get shortUrl
	 *
	 * @return string 
	 */
	public function getShortUrl() {
		return $this->shortUrl;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 * @return \App\Entities\Url
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string 
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Set hash
	 *
	 * @param string $hash
	 * @return \App\Entities\Url
	 */
	public function setHash($hash) {
		$this->hash = $hash;
		return $this;
	}

	/**
	 * Get hash
	 *
	 * @return string 
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * Set ip
	 *
	 * @param string $ip
	 * @return \App\Entities\Url
	 */
	public function setIp($ip) {
		$this->ip = $ip;
		return $this;
	}

	/**
	 * Get ip
	 *
	 * @return string 
	 */
	public function getIp() {
		return $this->ip;
	}

	/**
	 * Set views
	 *
	 * @param integer $views
	 * @return \App\Entities\Url
	 */
	public function setViews($views) {
		$this->views = $views;
		return $this;
	}

	/**
	 * Get views
	 *
	 * @return integer 
	 */
	public function getViews() {
		return $this->views;
	}

	/**
	 * Set date
	 *
	 * @param datetime $date
	 * @return \App\Entities\Url
	 */
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}

	/**
	 * Get date
	 *
	 * @return datetime 
	 */
	public function getDate() {
		return $this->date;
	}
}
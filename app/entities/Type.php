<?php
/*******************************************************************************
 * Name: Entity -> Type
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Entities;


/**
 * Type
 *
 * @Table(name="types")
 * @MappedSuperClass(repositoryClass="\App\Repositories\Type")
 * @HasLifecycleCallbacks
 */
class Type
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
	 * @var string $title
	 *
	 * @Column(name="`title`", type="string", length=45, nullable=false)
	 */
	private $title;

	/**
	 * @var string $extension
	 *
	 * @Column(name="`extension`", type="string", length=25, nullable=false)
	 */
	private $extension;


	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return \App\Entities\Type
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string 
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Set extension
	 *
	 * @param string $extension
	 * @return \App\Entities\Type
	 */
	public function setExtension($extension) {
		$this->extension = $extension;
		return $this;
	}

	/**
	 * Get extension
	 *
	 * @return string 
	 */
	public function getExtension() {
		return $this->extension;
	}
}
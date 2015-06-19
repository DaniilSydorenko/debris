<?php
/*******************************************************************************
 * Name: Entity -> File
 * Version: 1.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Entities;


/**
 * File
 *
 * @Table(name="files", indexes={@Index(name="fk_files_types_idx", columns={"type_id"})})
 * @MappedSuperClass(repositoryClass="\App\Repositories\File")
 * @HasLifecycleCallbacks
 */
class File
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
	 * @Column(name="`title`", type="string", length=255, nullable=false)
	 */
	private $title;

	/**
	 * @var integer $size
	 *
	 * @Column(name="`size`", type="integer", nullable=false)
	 */
	private $size;

	/**
	 * @var string $path
	 *
	 * @Column(name="`path`", type="string", length=255, nullable=true)
	 */
	private $path = null;

	/**
	 * @var datetime $uploadedDate
	 *
	 * @Column(name="`uploaded_date`", type="datetime", nullable=false)
	 */
	private $uploadedDate;

	/**
	 * @var string $uploadedBy
	 *
	 * @Column(name="`uploaded_by`", type="string", length=45, nullable=false)
	 */
	private $uploadedBy;

	/**
	 * @var boolean $isDeleted
	 *
	 * @Column(name="`is_deleted`", type="boolean", nullable=true)
	 */
	private $isDeleted = false;

	/**
	 * @var \App\Entities\Type $Type
	 *
	 * @ManyToOne(targetEntity="\App\Entities\Type")
	 * @JoinColumns({
	 *   @JoinColumn(name="type_id", referencedColumnName="id")
	 * })
	 */
	private $Type;


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
	 * @return \App\Entities\File
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
	 * Set size
	 *
	 * @param integer $size
	 * @return \App\Entities\File
	 */
	public function setSize($size) {
		$this->size = $size;
		return $this;
	}

	/**
	 * Get size
	 *
	 * @return integer 
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * Set path
	 *
	 * @param string $path
	 * @return \App\Entities\File
	 */
	public function setPath($path) {
		$this->path = $path;
		return $this;
	}

	/**
	 * Get path
	 *
	 * @return string 
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Set uploadedDate
	 *
	 * @param datetime $uploadedDate
	 * @return \App\Entities\File
	 */
	public function setUploadedDate($uploadedDate) {
		$this->uploadedDate = $uploadedDate;
		return $this;
	}

	/**
	 * Get uploadedDate
	 *
	 * @return datetime 
	 */
	public function getUploadedDate() {
		return $this->uploadedDate;
	}

	/**
	 * Set uploadedBy
	 *
	 * @param string $uploadedBy
	 * @return \App\Entities\File
	 */
	public function setUploadedBy($uploadedBy) {
		$this->uploadedBy = $uploadedBy;
		return $this;
	}

	/**
	 * Get uploadedBy
	 *
	 * @return string 
	 */
	public function getUploadedBy() {
		return $this->uploadedBy;
	}

	/**
	 * Get (or set) isDeleted
	 *
	 * @param boolean $isDeleted
	 * @return \App\Entities\File
	 */
	public function isDeleted($isDeleted = null) {
		if ($isDeleted === null) {
			return $this->isDeleted;
		}
		
		$this->isDeleted = $isDeleted;
		return $this;
	}

	/**
	 * Set Type
	 *
	 * @param \App\Entities\Type $Type
	 * @return \App\Entities\File
	 */
	public function setType(\App\Entities\Type $Type = null) {
		$this->Type = $Type;
		return $this;
	}

	/**
	 * Get Type
	 *
	 * @return \App\Entities\Type 
	 */
	public function getType() {
		return $this->Type;
	}
}
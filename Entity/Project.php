<?php

namespace Rofil\Repo\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Rofil\Repo\ContentBundle\Entity\ProjectRepository")
 */
class Project
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var integer
     *
     * @ORM\Column(name="published", type="smallint")
     */
    private $published;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\Rofil\Admin\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @var Int [<description>]
     * @ORM\Column(name="viewed", type="smallint")
     */
    protected $viewed;

    protected $slug;

    public function getSlug()
    {
        $title = strtolower($this->getTitle());
        $title = preg_replace('/[\ ]+/', '-', $title);
        $title = preg_replace("/[^a-zA-Z0-9\-]+/", "", $title);
        return $title;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Project
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set published
     *
     * @param integer $published
     * @return Project
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return integer 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Project
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Project
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Project
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Project
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return Project
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Project
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @ORM\PrePersist
     */
    public function doBeforePersist()
    {
        $this->setCreatedAt(new \DateTime);
        $this->setUpdatedAt(new \DateTime);
        $this->setViewed(0);
    }

    /**
     * 
     */
    protected $imagePath;

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath(UploadedFile $file)
    {
        $this->imagePath = $file;

        return $this;
    }

    /**
     * @ORM\PreFlush()
     * This function is used to upload image
     * @return void
     */
    public function upload()
    {
        if(null == $this->getImagePath()) return null;

        $this->removeImage();

        $filename = time().'.'.$this->getImagePath()->guessClientExtension();

        $this->getImagePath()->move($this->getUploadImageRootDir(), $filename);

        $this->setImage($filename);

        $this->imagePath=null;
    }

    public function removeImage()
    {
        $file = $this->getAbsoluteImagePath();
        if(file_exists($file) && !is_dir($file))
            unlink($file);
    }

    public function getUploadImageRootDir()
    {
        return __DIR__.'/../../../../../web/'.$this->getUploadImageDir();
    }

    public function getUploadImageDir()
    {
        return 'files/projects';
    }

    protected $webImagePath;

    public function getWebImagePath()
    {
        return null === $this->getImage() ? null : $this->getUploadImageDir() . '/' . $this->getImage();
    }

    protected $absoluteImagePath;

    public function getAbsoluteImagePath()
    {
        return null === $this->getImage() ? null : $this->getUploadImageRootDir() . '/' . $this->getImage();
    }


    /**
     * Set viewed
     *
     * @param integer $viewed
     * @return Project
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;

        return $this;
    }

    /**
     * Get viewed
     *
     * @return integer 
     */
    public function getViewed()
    {
        return $this->viewed;
    }
}

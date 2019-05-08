<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\Comment;
use Application\Entity\Tag;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post
{
    // Константы статуса поста.
    const STATUS_DRAFT       = 1; // Черновик.
    const STATUS_PUBLISHED   = 2; // Опубликованный пост.

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="title")
     */
    protected $title;

    /**
     * @ORM\Column(name="content")
     */
    protected $content;

    /**
     * @ORM\Column(name="status")
     */
    protected $status;
    /**
     * @ORM\Column(name="date_created")
     */
    protected $dateCreated;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Возвращает содержимое поста.
    public function getContent()
    {
        return $this->content;
    }

    // Задает содержимое поста.
    public function setContent($content)
    {
        $this->content = $content;
    }

    // Возвращает дату создания данного поста.
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    // Задает дату создания данного поста.
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }



    //____________________________________________________________________________________________


    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Comment", mappedBy="post")
     * @ORM\JoinColumn(name="id", referencedColumnName="post_id")
     */

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Entity\Tag", inversedBy="posts")
     * @ORM\JoinTable(name="post_tag",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */

    protected $comments;
    protected $tags;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }


    /**
     * Возвращает комментарии для этого поста.
     * @return ArrayCollection
     */

    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Добавляет новый комментарий к этому посту.
     * @param $comment
     */
    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }


    // Возвращает теги для данного поста.
    public function getTags()
    {
        return $this->tags;
    }

    // Добавляет новый тег к данному посту.
    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }

    // Удаляет связь между этим постом и заданным тегом.
    public function removeTagAssociation($tag)
    {
        $this->tags->removeElement($tag);
    }

}
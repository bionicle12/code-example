<?php

namespace DDD\Page\Entity;

use App\Models\User;
use Illuminate\Support\Collection;

class Page
{
    protected $id;
    protected $category;
    protected $slug;
    /**
     * @var \Auth
     */
    protected $user;
    protected $createAt;
    protected $updatedAt;
    /** @var array */
    protected $content;

    public function __construct($category, $slug, PageContent $content = null, User $user = null, $id = null, $createdAt = null)
    {
        $this->id = $id;
        $this->content = $content;
        $this->category = $category;
        $this->slug = $slug;
        $this->user = $user;
        $this->createAt = $createdAt ?? now();
        $this->updatedAt = $createdAt ?? now();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getUser()
    {

    }

    public function getCreatedAt()
    {
        return $this->createAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getId()
    {
        return (int)$this->id;
    }
}

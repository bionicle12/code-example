<?php

namespace Domain\Page\Entity;

use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Class Page
 *
 * @package Domain\Page\Entity
 */
class Page
{
    /**
     * @var mixed|null
     */
    protected $id;

    /**
     * @var
     */
    protected $category;

    /**
     * @var
     */
    protected $slug;

    /**
     * @var \App\Models\User
     */
    protected $user;

    /**
     * @var \Illuminate\Support\Carbon|mixed
     */
    protected $createAt;

    /**
     * @var \Illuminate\Support\Carbon|mixed
     */
    protected $updatedAt;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $content;

    /**
     * Page constructor.
     *
     * @param $category
     * @param $slug
     * @param \Illuminate\Support\Collection $content
     * @param \App\Models\User $user
     * @param null $id
     * @param null $createdAt
     */
    public function __construct($category, $slug, Collection $content, User $user, $id = null, $createdAt = null)
    {
        $this->id = $id;
        $this->content = $content;
        $this->category = $category;
        $this->slug = $slug;
        $this->user = $user;
        $this->createAt = $createdAt ?? now();
        $this->updatedAt = $createdAt ?? now();
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     */
    public function getUser()
    {

    }

    /**
     * @return \Illuminate\Support\Carbon|mixed
     */
    public function getCreatedAt()
    {
        return $this->createAt;
    }

    /**
     * @return \Illuminate\Support\Carbon|mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int)$this->id;
    }
}

<?php

namespace DDD\HMenu\Model;

use DDD\HMenu\Entity\HMenu;
use DDD\Locale\Model\LocaleModel;
use DDD\ModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HMenuModel extends Model implements ModelInterface
{
    use HasFactory;

    protected $table = "hmenus";

    public $timestamps = false;

    protected $guarded = ['id'];

    public const STATUS_DRAFT = false;
    public const STATUS_PUBLISH = true;

    public function toDomain()
    {
        return new HMenu(
            $this->title,
            $this->url,
            $this->status,
            $this->parent_id,
            [],
            $this->sort_order,
            $this->class,
            $this->id
        );
    }
}

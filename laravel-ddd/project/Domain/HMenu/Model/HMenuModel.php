<?php

namespace Domain\HMenu\Model;

use Domain\HMenu\Entity\HMenu;
use Domain\Locale\Model\LocaleModel;
use Domain\ModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HMenuModel extends Model implements ModelInterface
{
    use HasFactory;

    protected $table = "hmenus";

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'parent_id' => 'integer'
    ];

    public const HMENU_STATUS_DRAFT = 0;
    public const HMENU_STATUS_PUBLISH = 1;

    public function parent()
    {
        return $this->belongsTo(HMenuModel::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(HMenuModel::class, 'parent_id');
    }

    public function locale()
    {
        return $this->belongsTo(LocaleModel::class, 'locale_id');
    }

    public function toDomain()
    {
        return new HMenu(
            $this->title,
            $this->url,
            $this->status,
            $this->locale,
            $this->parent,
            $this->children,
            $this->sortOrder,
            $this->class,
            $this->id
        );
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function __sleep()
    {
        return [$this->title];
    }
}

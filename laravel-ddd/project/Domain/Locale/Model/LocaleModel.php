<?php

namespace Domain\Locale\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class LocaleModel extends Model
{
    use HasFactory;

    protected $table = "locales";

    public $timestamps = false;

    protected $guarded = ['id'];

    public const LOCALE_STATUS_DRAFT = 0;
    public const LOCALE_STATUS_PUBLISH = 1;
}


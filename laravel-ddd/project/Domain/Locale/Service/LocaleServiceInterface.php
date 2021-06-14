<?php

namespace Domain\Locale\Service;

use Domain\Locale\Entity\Locale;
use Illuminate\Database\Eloquent\Collection;

interface LocaleServiceInterface
{
    public function findAll();
}

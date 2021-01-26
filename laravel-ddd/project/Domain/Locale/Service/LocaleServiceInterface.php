<?php

namespace DDD\Locale\Service;

interface LocaleServiceInterface
{
    public function getAll();

    public function findDefault();

    public function findByCode($code);
}

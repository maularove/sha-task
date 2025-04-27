<?php

namespace App\Shared\Services;

use Psr\Container\ContainerInterface;

class LanguageService
{
    public function __construct(protected ContainerInterface $container) {}

    public function getLanguage(): string
    {
        // Default to Spanish instead of using tenant language
        return "es";
    }

    public function getText($key): string
    {
        $lang = $this->getLanguage();
        $json = json_decode(file_get_contents("lang/$lang.json"), true);
        return $json[$key] ?? $key;
    }
}

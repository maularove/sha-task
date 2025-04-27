<?php

namespace App\Shared\Services;

use Psr\Container\ContainerInterface;

class LanguageService
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function getLanguage(): string
    {
        $lang = $this->container->get('tenant')->language;
        if ($lang == 0) {
            $language = "es";
        } else if ($lang == 1) {
            $language =  "es";
        } else if ($lang == 2) {
            $language =  "en";
        } else if ($lang == 3) {
            $language = "pt";
        }
        
        return $language;
    }

    public function getText($key): string
    {
        $lang = $this->getLanguage();
        $json = json_decode(file_get_contents("lang/$lang.json"), true);
        return $json[$key] ?? $key;
    }
}
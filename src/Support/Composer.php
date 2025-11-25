<?php

namespace FeatureKit\Support;

use Illuminate\Support\Str;

class Composer
{
    public static function getAutoloadedClasses(): array
    {
        $composerPath = base_path('vendor/composer/autoload_classmap.php');
        if (! file_exists($composerPath)) {
            throw new \Exception('Composer autoload_classmap.php not found');
        }

        $composerContents = include $composerPath;

        if(!$composerContents || !is_array($composerContents)){
            throw new \Exception('Composer autoload_classmap.php is not of expected type [array]');
        }

        return array_keys($composerContents);
    }
}

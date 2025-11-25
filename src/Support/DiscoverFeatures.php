<?php

namespace FeatureKit\Support;

use FeatureKit\Support\Composer;
use Illuminate\Support\Str;
use FeatureKit\Factories\Feature;
use FeatureKit\Helpers\KitHelper;

class DiscoverFeatures
{
    public static function getFeatureClasses(): array
    {
        $features = array_filter(Composer::getAutoloadedClasses(), function ($class){
            if(Str::contains($class, 'Feature')){
                $reflection = new \ReflectionClass($class);
                return $reflection->isSubclassOf(Feature::class);
            }
            return false;
        });

        return $features;
    }

    public static function getFeatureInstances(): array
    {
        $features = self::getFeatureClasses();
        $instances = [];
        foreach ($features as $feature) {
            $instances[] = new $feature();
        }

        return $instances;
    }
}

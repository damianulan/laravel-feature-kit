<?php

namespace FeatureKit\Support;

use FeatureKit\Support\Composer;
use Illuminate\Support\Str;
use FeatureKit\Factories\Feature;

class DiscoverFeatures
{
    public static function getFeatureClasses(): array
    {
        $classes = array_filter(Composer::getAutoloadedClasses(), function ($class){
            if(Str::contains($class, 'Feature')){
                $reflection = new \ReflectionClass($class);
                return $reflection->isInstantiable() && $reflection->isSubclassOf(Feature::class);
            }
            return false;
        });

        return array_values($classes);
    }

    public static function getFeatureInstances(): array
    {
        $instances = [];
        foreach(self::getFeatureClasses() as $class){
            $object = new $class();
            $instances[$object->key] = $object;
        }

        return $instances;
    }
}

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
        $classes = array_filter(Composer::getAutoloadedClasses(), function ($class){
            if(Str::contains($class, 'Feature')){
                $reflection = new \ReflectionClass($class);
                return $reflection->isInstantiable() && $reflection->isSubclassOf(Feature::class);
            }
            return false;
        });

        return array_values($classes);
    }

    /**
     * Get feature instances based on a composer classmap
     *
     * @return array
     */
    public static function getFeatureInstances(): array
    {
        $instances = KitHelper::getCache('autoload', []);

        if(empty($instances)){
            foreach(self::getFeatureClasses() as $class){
                $object = new $class();
                $instances[$object->key] = $object;
            }
            KitHelper::setCache('autoload', $instances);
        }

        return $instances;
    }
}

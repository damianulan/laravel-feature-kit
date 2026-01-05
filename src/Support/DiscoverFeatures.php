<?php

namespace FeatureKit\Support;

use FeatureKit\Support\Composer;
use Illuminate\Support\Str;
use FeatureKit\Factories\Feature;
use FeatureKit\Helpers\KitHelper;

class DiscoverFeatures
{
    /**
     * Filter composer classes to those Discoverable as a Feature.
     *
     * @return array
     */
    public static function getFeatureAutoloadClasses(): array
    {
        return array_values(array_filter(Composer::getAutoloadedClasses(), fn ($class) => Str::contains($class, '\\Feature')));
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
            foreach(array_merge(self::getFeatureAutoloadClasses(), config('featurekit.features', [])) as $class){
                if(self::isValidFeatureClass($class)){
                    $object = new $class();
                    $instances[$object->key] = $object;
                }
            }

            KitHelper::setCache('autoload', $instances);
        }

        return $instances;
    }

    private static function isValidFeatureClass(string $class): bool
    {
        // Ensure class exists (autoload allowed)
        if (!class_exists($class)) {
            return false;
        }

        try {
            $reflection = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            return false;
        }

        // Must be instantiable (not abstract, not interface, etc.)
        if (!$reflection->isInstantiable()) {
            return false;
        }

        // Must extend FeatureKit\Factories\Feature
        if (!$reflection->isSubclassOf(Feature::class)) {
            return false;
        }

        return true;
    }
}

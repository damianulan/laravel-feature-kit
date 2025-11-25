<?php

namespace FeatureKit\Helpers;

use Illuminate\Support\Facades\Cache;
use FeatureKit\Repositories\BaseRepository;

class KitHelper
{
    public static function repository(): BaseRepository
    {
        return app('FeatureRepository');
    }

    public static function getCache(string $key): string
    {
        return Cache::get('featurekit.' . $key);
    }

    public static function setCache(string $key, string $value, ?int $ttl = null): void
    {
        if(!config('featurekit.cache.enabled')){
            return;
        }
        if(is_null($ttl)){
            $ttl = (int) config('featurekit.cache.ttl');
        }
        Cache::put('featurekit.' . $key, $value, config('featurekit.cache.ttl'));
    }
}

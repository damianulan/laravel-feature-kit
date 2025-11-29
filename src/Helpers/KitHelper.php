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

    public static function getCache(string $key, $default = null)
    {
        return Cache::get('featurekit.' . $key, $default);
    }

    public static function setCache(string $key, $value, ?int $ttl = null): void
    {
        if(!config('featurekit.cache.enabled')){
            return;
        }
        if(is_null($ttl)){
            $ttl = now()->addMinutes(config('featurekit.cache.ttl'));
        }
        Cache::put('featurekit.' . $key, $value, $ttl);
    }
}

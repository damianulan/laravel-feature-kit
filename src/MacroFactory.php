<?php

namespace FeatureKit;

use Closure;
use Illuminate\Support\Collection;
class MacroFactory
{
    public static function load(): void
    {
        Collection::macro('whenHasFeature', function (string $key, Closure $callback, $user = null): Collection {
            if(app(Features::class)->check($key, $user)){
                $callback($this);
            }
            return $this;
        });
    }
}

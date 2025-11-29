<?php

namespace FeatureKit;

use Illuminate\Support\Collection;
class MacroFactory
{
    public static function load(): void
    {
        Collection::macro('feature', function (string $key, $user = null): bool {
            return app(Features::class)->check($key, $user);
        });
    }
}

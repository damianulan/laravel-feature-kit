<?php

namespace FeatureKit;

use FeatureKit\Helpers\KitHelper;
use Illuminate\Support\Collection;
use FeatureKit\Factories\Feature;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
class Features extends Collection
{
    public function __construct()
    {
        $items = KitHelper::repository()->getFeatures();
        parent::__construct($items);
    }

    #[\Override]
    public static function make($items = [])
    {
        return app(Features::class);
    }

    final public function find(string $key): Feature
    {
        return parent::get($key);
    }

    public function isEnabled(string $key, $user = null): bool
    {
        $feature = $this->get($key);
        if(!is_null($user)){
            $feature->setUser($user);
        }
        return $feature->isEnabled();
    }

    public function check(string $key, $user = null): bool
    {
        $feature = $this->get($key);
        if(!is_null($user)){
            $feature->setUser($user);
        }
        return $feature->check();
    }
}

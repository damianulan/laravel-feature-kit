<?php

namespace FeatureKit\Repositories;

use FeatureKit\Factories\Feature;
use FeatureKit\Models\FeatureModel;
use FeatureKit\Support\DiscoverFeatures;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
abstract class BaseRepository
{
    protected array $features = [];
    protected array $registered = [];

    abstract protected function loadRegisteredFeatures(): array;
    abstract public function create(Feature $feature): Feature;
    abstract public function delete(Feature $feature): Feature;

    public function __construct()
    {
        $this->registered = collect($this->loadRegisteredFeatures())
            ->mapWithKeys(function($item) {
                if(!is_object($item)){
                    $item = (object) $item;
                }

                return [$item->key => $item];
            })->toArray();
        $this->analyzeFeatures();

    }

    private function analyzeFeatures(): void
    {
        $instances = DiscoverFeatures::getFeatureInstances();

        foreach($instances as $instance){
            if(!isset($this->registered[$instance->key])){
                $instance = $this->create($instance);
            }

            $this->features[$instance->key] = $instance;
        }

        foreach($this->features as $key => $value){
            if(!isset($instances[$key])){
                $this->delete($value);
            } else {
                //foreach($instances[$key])
            }
        }


    }

    public function getFeatures(): array
    {
        return $this->features;
    }
}

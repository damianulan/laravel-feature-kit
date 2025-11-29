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
    /**
     * Final features output with FeatureKit\Factories\Feature instances.
     *
     * @var array
     */
    protected array $features = [];

    /**
     * Features registered in a store
     *
     * @var array
     */
    protected array $registered = [];

    /**
     * Load storage contents of features with array output.
     *
     * @return array
     */
    abstract protected function loadRegisteredFeatures(): array;

    /**
     * Store an instance based on FeatureKit\Factories\Feature instance
     *
     * @param \FeatureKit\Factories\Feature $feature
     * @return \FeatureKit\Factories\Feature
     */
    abstract public function create(Feature $feature): Feature;

    /**
     * Delete an instance from storage based on FeatureKit\Factories\Feature instance
     *
     * @param \FeatureKit\Factories\Feature $feature
     * @return \FeatureKit\Factories\Feature
     */
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
            if(empty($cache) && !isset($instances[$key])){
                $this->delete($value);
                unset($this->features[$key]);
            } else {
                if(isset($this->registered[$key])){
                    foreach($this->registered[$key] as $k => $v){
                        $this->features[$key]->$k = $v;
                    }
                    $this->features[$key]->register();
                }
            }
        }
    }

    /**
     * Get feature list from repository
     *
     * @return array
     */
    public function getFeatures(): array
    {
        return $this->features;
    }
}

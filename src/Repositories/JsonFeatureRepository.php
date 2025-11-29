<?php

namespace FeatureKit\Repositories;

use Illuminate\Support\Facades\File;
use FeatureKit\Factories\Feature;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
class JsonFeatureRepository extends BaseRepository
{
    private function getDirectory(): string
    {
        return config('featurekit.drivers.json.storage_path');
    }

    private function getPath(): string
    {
        return $this->getDirectory() . '/datas.json';
    }

    protected function loadRegisteredFeatures(): array
    {
        $path = $this->getPath();
        if(File::exists($path)){
            return json_decode(File::get($path), true);
        }
        return [];
    }

    private function putFile($content): void
    {
        File::ensureDirectoryExists($this->getDirectory());
        File::put($this->getPath(), json_encode($content, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    }

    public function create(Feature $feature): Feature
    {
        $feature->enabled = true;
        $this->putFile($this->registered);
        $this->registered[$feature->key()] = $feature->toArray();
        return $feature;
    }

    public function delete(Feature $feature): Feature
    {
        unset($this->registered[$feature->key()]);
        $this->putFile($this->registered);
        return $feature;
    }
}

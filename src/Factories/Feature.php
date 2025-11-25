<?php

namespace FeatureKit\Factories;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
abstract class Feature implements Arrayable
{
    protected $attributes = [];

    abstract public function define(): bool;
    abstract public function key(): string;

    public function __construct(array $attributes = [])
    {
        if(empty($this->key())){
            throw new \Exception('Feature key cannot be empty.');
        }
        $this->initialize();
    }

    private function initialize(array $attributes = []): void
    {
        $this->setAttribute('enabled', false);

        foreach($this->attributes as $key => $value){
            $this->setAttribute($key, $this->$key);
        }
        foreach($attributes as $key => $value){
            $this->setAttribute($key, $value);
        }

        $this->attributes['key'] = $this->key();
        ksort($this->attributes);
    }

    public function __get(string $key)
    {
        return $this->getAttribute($key);
    }

    public function __set(string $key, $value): void
    {
        $this->setAttribute($key, $value);
    }

    public function hasAttribute(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function getAttribute(string $key)
    {
        if(!isset($this->attributes[$key])){
            throw new \Exception("Feature attribute '$key' does not exist.");
        }
        return $this->attributes[$key];
    }

    public function setAttribute(string $key, $value): void
    {
        if(empty($value) && $value !== 0 && $value !== false){
            throw new \Exception('Feature attribute cannot be empty.');
        }
        if($key === 'key'){
            return ;
        }
        $this->attributes[$key] = $value;
    }

    public function check(): bool
    {
        return $this->define() && $this->isEnabled();
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}

<?php

namespace FeatureKit\Factories;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Auth;

/**
 *
 * @property-read string $key
 * @property-read bool $enabled
 * @property-read mixed $user
 * @property-read bool $registered
 *
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
abstract class Feature implements Arrayable
{
    protected $attributes = [];
    protected $user = null;
    private $registered = false;

    abstract public function define(): bool;
    abstract public function key(): string;

    public function __construct(array $attributes = [])
    {
        if(empty($this->key())){
            throw new \Exception('Feature key cannot be empty.');
        }
        $this->initialize($attributes);
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
        $this->setUser();
    }

    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function __unset(string $key): void
    {
        if(isset($this->attributes[$key])){
            unset($this->attributes[$key]);
        }
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

    public function setUser($user = null): void
    {
        if(is_null($user) && Auth::check()){
            $user = Auth::user();
        }
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function register(): void
    {
        $this->registered = true;
    }

    public function check(): bool
    {
        return $this->define() && $this->isEnabled() && $this->isRegistered();
    }

    public function isEnabled(): bool
    {
        return $this->enabled && $this->isRegistered();
    }

    public function isRegistered(): bool
    {
        return $this->registered;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}

<?php

declare(strict_types=1);

namespace App\Core;

class Container
{
    protected array $bindings  = [];
    protected array $instances = [];

    public function bind($key, mixed $stored, bool $singleton = false): void
    {
        $this->bindings[$key] = [
            'stored'    => $stored,
            'singleton' => $singleton,
        ];
    }

    /**
     * @param mixed $key
     *
     * @throws \Exception
     */
    public function resolve($key): mixed
    {
        if (!array_key_exists($key, $this->bindings)) {
            throw new \RuntimeException("No matching binding found for {$key}");
        }

        $resolved = $this->bindings[$key]['stored'];

        if ($this->bindings[$key]['singleton'] && isset($this->instances[$key])) {
            return $this->instances[$key];
        }

        if ($resolved instanceof \Closure) {
            $resolved = $resolved();
        }

        if ($this->bindings[$key]['singleton']) {
            $this->instances[$key] = $resolved;
        }

        return $resolved;
    }

    public function singleton($key, $value): void
    {
        $this->bind($key, $value, true);
    }
}

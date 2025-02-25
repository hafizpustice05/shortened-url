<?php

use RuntimeException;

class container
{
    public $bindings = [];

    function bind($name, callable $resolver)
    {
        $this->bindings[$name] = $resolver;
    }

    function make($name)
    {
        return $this->bindings[$name]();
    }

    function getFuel(VehicleInterface $vehicle)
    {
        return $vehicle->FuelType();
    }
}

interface Animal {}

class Fish implements Animal
{
    public function swim()
    {
        return "Swimming";
    }

    public function eat()
    {
        return "Eating";
    }
}

interface VehicleInterface
{
    public function FuelType(Animal $animal);
}

class Bike implements VehicleInterface
{
    public function FuelType(Animal $animal)
    {
        return "OCTEN";
    }
}

class Car implements VehicleInterface
{
    public function __construct(protected Fish $fish) {}

    public function FuelType(Animal $animal)
    {
        return "DIESEL";
    }
}

$container = new container;

$container->bind('fish', function () {
    return new Fish();
});

$container->bind(VehicleInterface::class, function () {
    return new Bike();
});

$reflectionClass = new ReflectionClass(Car::class);
// dd($reflectionClass->isInstantiable());

// dd($reflectionClass->getConstructor());


// dd($reflectionClass);

// dd($container->make('VehicleInterface')->FuelType());
// dd($container->bindings);


app()->bind('fish', function () {
    return new Fish();
});

app()->bind('bike', function () {
    return new bike();
});

// dd(app()->make('fish')->eat());

class Facade
{
    public static function __callStatic($method, $args)
    {
        $instance = app()->make(static::getFacadeAccessor());

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }

    protected static function getFacadeAccessor() {}
}


class BikeFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bike';
    }
}

class FishFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'fish';
    }
}


// dd(app()->make('bike')->start());
// dd(FishFacade::swim());

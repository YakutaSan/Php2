<?php

namespace App\Blog\UnitTests\Container;
use App\Blog\UnitTests\Container\SomeClassWithoutDependencies;
use App\Blog\UnitTests\Container\SomeClassWithParameter;

class ClassDependingOnAnother
{
    public function __construct(
        private SomeClassWithoutDependencies $one,
        private SomeClassWithParameter       $two,
    )
    {

    }
}
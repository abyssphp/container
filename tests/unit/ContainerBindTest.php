<?php

/**
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This file is part of abyss\container
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Abyss\Test\Unit;

use Abyss\Container\Concrete\Scalar;
use Abyss\Container\Container;
use Abyss\Test\Unit\Fixture\ContainerImplementation;
use Abyss\Test\Unit\Fixture\ContainerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Container::class)]
class ContainerBindTest extends TestCase
{
    public function testContainerCanBindAnyValue(): void
    {
        $container = new Container();
        $container->bind('foo', new Scalar('foo'));

        self::assertEquals('foo', $container->make('foo'));
    }

    public function testPrimitiveValueToConcreteResolution(): void
    {
        $container = new Container();
        $container->bind('foo', stdClass::class);

        self::assertInstanceOf(stdClass::class, $container->make('foo'));
    }

    public function testBindingAnInstanceAsShared(): void
    {
        $container = new Container();
        $container->singleton(ContainerInterface::class, ContainerImplementation::class);

        $instance1 = $container->make(ContainerInterface::class);
        $instance2 = $container->make(ContainerInterface::class);

        self::assertSame($instance1, $instance2);
    }
}

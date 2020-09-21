<?php

/**
 * @file
 * Tests for Itafroma\Zork\State\Oblist
 */

namespace Itafroma\Zork\Tests;

use Itafroma\Zork\State\Oblist;

class OblistTest extends ZorkTest
{
    /**
     * Tests Itafroma\Zork|State\Oblist::create() when the atom does not exist.
     *
     * @covers Itafroma\Zork\State\Oblist::create
     * @dataProvider oblistPropertyProvider
     */
    public function testCreateAtomDoesNotExist($oblist, $property_name)
    {
        $return = $oblist->create($property_name);

        $this->assertNull($return);
    }

    /**
     * Tests Itafroma\Zork|State\Oblist::create() when the atom already exists.
     *
     * @covers Itafroma\Zork\State\Oblist::create
     * @dataProvider oblistPropertyProvider
     */
    public function testCreateAtomExists($oblist, $property_name, $property_value)
    {
        $oblist->set($property_name, $property_value);
        $return = $oblist->create($property_name);

        self::assertEquals($property_value, $return);
    }

    /**
     * Tests Itafroma\Zork\State\Oblist::get() when the requested object exists.
     *
     * @covers Itafroma\Zork\State\Oblist::get
     * @dataProvider oblistPropertyProvider
     */
    public function testGetObjectExists($oblist, $property_name, $property_value)
    {
        self::setPrivateProperty($oblist, 'atoms', [$property_name => $property_value]);

        self::assertEquals($property_value, $oblist->get($property_name));
    }

    /**
     * Tests Itafroma\Zork\State\Oblist::get() when the requested object does not exist.
     *
     * @covers Itafroma\Zork\State\Oblist::get
     * @dataProvider oblistPropertyProvider
     */
    public function testGetObjectDoesNotExist($oblist, $property_name)
    {
        self::assertFalse($oblist->get($property_name));
    }

    /**
     * Provides an oblist with a test property and value.
     */
    public function oblistPropertyProvider()
    {
        $properties = $this->propertyProvider();

        foreach ($properties as &$property) {
            array_unshift($property, new Oblist());
        }

        return $properties;
    }
}

<?php

namespace phpUnitTutorial\Test;

class DependencyLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->depLoader = new \xes\DependencyLoader();
    }

    /**
     * @dataProvider providerNoData
     */
    public function testAddingWithoutData($dep)
    {
        $this->setExpectedException('Exception', "Dependency must have either local or cdn URL");
        $this->depLoader->add($dep);
    }

    /**
     * @dataProvider providerUnnamed
     */
    public function testAddingWithoutName($dep)
    {
        $this->setExpectedException('Exception', "Dependency must be named");
        $this->depLoader->add($dep);
    }

    public function providerUnnamed()
    {
        return [
            [$this->local(), $this->cdn()]
        ];
    }

    public function providerNoData()
    {
        return [
            [$this->name()]
        ];
    }

    public function name()
    {
        return ['name' => 'MyLibrary'];
    }

    public function local()
    {
        return ['local' => 'lib/MyLibrary/dist.js'];
    }

    public function cdn()
    {
        return ['cdn' => 'https://cdn.example.com/dist.js'];
    }
}

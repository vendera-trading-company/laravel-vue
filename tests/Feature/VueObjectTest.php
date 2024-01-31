<?php

namespace Tests\Feature;

use Tests\TestCase;
use VenderaTradingCompany\LaravelVue\Actions\Vue\VueObject;
use VenderaTradingCompany\PHPActions\Action;

class VueObjectTest extends TestCase
{
    public function testStringCanBeConverter()
    {
        $value = 'test';

        $response = Action::run(VueObject::class, [
            'object' => $value
        ])->getData('object');

        $this->assertEquals('"' . $value . '"', $response);
    }

    public function testNumberCanBeConverter()
    {
        $value = 1034;

        $response = Action::run(VueObject::class, [
            'object' => $value
        ])->getData('object');

        $this->assertEquals('' . $value . '', $response);
    }

    public function testTrueBoolCanBeConverter()
    {
        $value = true;

        $response = Action::run(VueObject::class, [
            'object' => $value
        ])->getData('object');

        $this->assertEquals('true', $response);
    }

    public function testFalseBoolCanBeConverter()
    {
        $value = false;

        $response = Action::run(VueObject::class, [
            'object' => $value
        ])->getData('object');

        $this->assertEquals('' . $value . '', $response);
    }
}

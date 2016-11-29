<?php

use Faker\Factory;

abstract class ApiTestCase extends TestCase
{
    /**
     * Faker.
     *
     * @var \Faker\Generator
     */
    protected $fake;

    public function setUp()
    {
        parent::setUp();

        $this->fake = Factory::create();
    }
}
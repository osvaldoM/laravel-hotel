<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;

    /**
     * Set up the test
     */
    public function setUp(): void
    {
        parent::setUp(); //
        $this->faker = Faker::create();
        Storage::fake('local');
        $this->withoutExceptionHandling();
    }

    /**
     * Reset the migrations
     */
    public function tearDown(): void
    {
        $this->artisan('migrate:fresh');
        parent::tearDown();

    }
}

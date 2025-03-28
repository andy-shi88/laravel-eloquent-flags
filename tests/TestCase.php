<?php

namespace AndyShi88\LaravelEloquentFlags\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    protected function setUpDatabase()
    {
        if (! Schema::hasTable('test_models')) {
            Schema::create('test_models', function (Blueprint $table) {
                $table->increments('id');
                $table->text('name')->nullable();
                $table->text('other_field')->nullable();
                $table->unsignedInteger('flag_a')->nullable();
                $table->unsignedBigInteger('flag_b')->nullable();
                $table->text('field_with_mutator')->nullable();
                $table->json('nested')->nullable();
            });
        }
    }
}

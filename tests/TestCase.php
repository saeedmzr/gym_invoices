<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $path = base_path() . "/database/database.sqlite";
        if (!file_exists($path))
            File::put($path, '');

//        Artisan::call('migrate:fresh --database=sqlite');

    }
}

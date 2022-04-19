<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_should_return_201_status_code_mostrecent_()
    {
        $response = $this->get('/bitcoin/most-recent');
        $response->assertCreated(true);
        $response->assertStatus(201);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_should_return_201_status_code_historyprice()
    {
        $response = $this->get('/bitcoin/history?date=30-12-2017&time=12:00');
        $response->assertCreated(true);
        $response->assertStatus(201);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_should_return_404_status_code_coin_invalid()
    {
        $response = $this->get('/non-exist/most-recent');
        $response->assertStatus(404);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_should_return_404_status_code_datetime_invalid()
    {
        $response = $this->get('/bitcoin/history?non-exist');
        $response->assertStatus(404);
    }
}

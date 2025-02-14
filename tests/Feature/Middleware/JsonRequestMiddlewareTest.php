<?php

namespace Tests\Feature\Middleware;

use Tests\TestCaseWithAuth;

class JsonRequestMiddlewareTest extends TestCaseWithAuth
{
    /** @test */
    public function it_requests_successfully()
    {
        $data = [
            'age' => '28',
            'currency_id' => 'USD',
            'start_date' => '2025-02-01',
            'end_date' => '2025-02-05',
        ];

        $response = $this->postJson('api/quotation', $data, $this->headers());

        $response->assertStatus(200);
    }

    /** @test */
    public function it_throws_an_exception_for_invalid_json_content_type()
    {
        $data = [
            'age' => '28',
            'currency_id' => 'USD',
            'start_date' => '2025-02-01',
            'end_date' => '2025-02-05',
        ];

        $response = $this->post('api/quotation', $data, $this->headers());

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Content-Type must be application/json']);
    }
}

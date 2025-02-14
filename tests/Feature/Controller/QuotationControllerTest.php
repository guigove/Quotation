<?php

namespace Tests\Feature\Controller;

use App\Models\Quotation;
use Tests\TestCaseWithAuth;

class QuotationControllerTest extends TestCaseWithAuth
{
    /** @test */
    public function it_creates_a_quotation_successfully()
    {
        $data = [
            'age' => '25,35,45',
            'currency_id' => 'USD',
            'start_date' => '2025-02-01',
            'end_date' => '2025-02-05',
        ];

        $response = $this->postJson('api/quotation', $data, $this->headers());
        $response->assertStatus(200)
                 ->assertJsonStructure(['total', 'currency_id', 'quotation_id']);

        $quotation = Quotation::where($data)->latest()->first();
        $expectedTotal = round((0.6  * 3 * 5) + (0.7 * 3 * 5) + (0.8 * 3 * 5), 2);
        $this->assertEquals($expectedTotal, $quotation->total); 
    }

    /** @test */
    public function it_validates_the_age_format()
    {
        $data = [
            'age' => '28,',
            'currency_id' => 'USD',
            'start_date' => '2025-02-01',
            'end_date' => '2025-02-05',
        ];

        $response = $this->postJson('api/quotation', $data, $this->headers());
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors('age');
    }

    /** @test */
    public function it_validates_the_currency_type()
    {
        $data = [
            'age' => '28',
            'currency_id' => 'BRL',
            'start_date' => '2025-02-01',
            'end_date' => '2025-02-05',
        ];

        $response = $this->postJson('api/quotation', $data, $this->headers());
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors('currency_id');
    }

    /** @test */
    public function it_validates_required_fields_for_quotation()
    {
        $response = $this->postJson('api/quotation', [], $this->headers());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['age', 'currency_id', 'start_date', 'end_date']);
    }

    /** @test */
    public function it_validates_end_date_before_start_date()
    {
        $data = [
            'age' => '28',
            'currency_id' => 'USD',
            'start_date' => '2025-02-01',
            'end_date' => '2025-01-05',
        ];

        $response = $this->postJson('api/quotation', $data, $this->headers());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('end_date');
    }
}

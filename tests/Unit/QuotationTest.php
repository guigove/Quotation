<?php

namespace Tests\Unit;

use App\Models\Quotation;
use Tests\TestCase;
use InvalidArgumentException;

class QuotationTest extends TestCase
{
    /** @test */
    public function it_calculates_the_total_correctly()
    {
        $quotation = new Quotation([
            'age' => '20,40,50',
            'start_date' => '2025-02-01',
            'end_date' => '2025-02-05',
        ]);

        // Expected trip length = 5 days (from 2025-02-01 to 2025-02-05)
        // Age loads: 0.6 for 20, 0.7 for 40, 0.8 for 50
        // Fixed rate: 3  
        $expectedTotal = round((0.6  * 3 * 5) + (0.7 * 3 * 5) + (0.8 * 3 * 5), 2);

        $this->assertEquals($expectedTotal, $quotation->calculate());
    }

    /** @test */
    public function it_calculates_the_trip_length_correctly()
    {
        $quotation = new Quotation([
            'start_date' => '2025-02-01',
            'end_date' => '2025-02-10',
        ]);

        $this->assertEquals(10, $quotation->calculateTripLength());
    }

    /** @test */
    public function it_throws_an_exception_for_end_date_before_start_date()
    {
        $this->expectException(InvalidArgumentException::class);

        $quotation = new Quotation([
            'start_date' => '2025-02-01',
            'end_date' => '2025-01-10',
        ]);

        $this->assertEquals(10, $quotation->calculateTripLength());
    }

    /** @test */
    public function it_calculates_the_age_load_correctly()
    {
        $quotation = new Quotation([
            'age' => '20, 70'
        ]);

        $this->assertEquals([0.6, 1], $quotation->getAgeLoad());
    }

    /** @test */
    public function it_throws_an_exception_for_invalid_age()
    {
        $this->expectException(InvalidArgumentException::class);

        $quotation = new Quotation([
            'age' => '20,85'
        ]);

        $quotation->getAgeLoad();
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Quotation extends Model
{
    private const FIXED_RATE = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'age',
        'currency_id',
        'total',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
    ];

    /**
     * Calculate the quote.
     *
     * @return float
     */
    public function calculate(): float
    {
        $quotation = 0;
        $tripLength = $this->calculateTripLength();
        $ageLoads = $this->getAgeLoad();

        foreach ($ageLoads as $ageLoad) {
            $quotation += self::FIXED_RATE * $ageLoad * $tripLength;
        }

        $this->total = round($quotation, 2);

        return $this->total;
    }

    /**
     * Calculate trip length.
     *
     * @return int
     */
    public function calculateTripLength(): int
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        if ($end->lt($start)) {
            throw new InvalidArgumentException('The end date must be a date after or equal to start date');
        }

        return $start->diffInDays($end) + 1;
    }

    /**
     * Get the load based on age.
     *
     * @return array
     */
    public function getAgeLoad(): array
    {
        $loads = [];
        $ages = explode(',', $this->age);

        foreach ($ages as $age) {
            $age = intval($age);

            if ($age >= 18 && $age <= 30) {
                $loads[] = 0.6;
            } elseif ($age >= 31 && $age <= 40) {
                $loads[] = 0.7;
            } elseif ($age >= 41 && $age <= 50) {
                $loads[] = 0.8;
            } elseif ($age >= 51 && $age <= 60) {
                $loads[] = 0.9;
            } elseif ($age >= 61 && $age <= 70) {
                $loads[] = 1;
            } else {
                throw new InvalidArgumentException('The age must be from 18 to 70 years old');
            }
        }

        return $loads;
    }
}

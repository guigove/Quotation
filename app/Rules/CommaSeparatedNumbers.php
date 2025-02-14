<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CommaSeparatedNumbers implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $numbers = explode(',', $value);

        foreach ($numbers as $number) {
            if (!ctype_digit(trim($number))) {
                $fail("The $attribute must be a comma-separated list of valid numbers.");
                return;
            }
        }
    }
}

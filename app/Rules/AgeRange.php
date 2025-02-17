<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AgeRange implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ages = explode(',', $value);
        foreach ($ages as $age) {
            if ($age < 18 || $age > 70) {
                $fail("The $attribute must be from 18 to 70 years old");
                return;
            }
        }
    }
}

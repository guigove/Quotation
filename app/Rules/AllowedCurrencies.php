<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllowedCurrencies implements ValidationRule
{
    private const ALLOWED_CURRENCIES = ['EUR', 'GBP', 'USD'];
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array(strtoupper($value), self::ALLOWED_CURRENCIES)) {
            $fail("The currency code must be EUR, GBP or USD.");
            return;
        }
        
    }
}

<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DocumentRule implements ValidationRule
{
    private $tipo;
    
    public function __construct ($tipo) {
        $this->tipo = $tipo;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!validateDocument($value,$this->tipo)){
            $fail(__('Invalid Document'));
        }
    }
}

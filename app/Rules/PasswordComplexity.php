<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class PasswordComplexity implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

     public function passes($attribute, $value)
    {
        // Verificar pelo menos 2 letras
        $letters = preg_match_all('/[a-zA-Z]/', $value);
        // Verificar pelo menos 2 números
        $numbers = preg_match_all('/\d/', $value);

        return $letters >= 2 && $numbers >= 2;
    }
    public function message()
    {
        return 'A senha deve conter pelo menos 2 letras e 2 números.';
    }

}

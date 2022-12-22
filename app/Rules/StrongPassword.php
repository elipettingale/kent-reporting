<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ZxcvbnPhp\Zxcvbn;

class StrongPassword implements Rule
{
    private $strength;
    private $analysis;

    public function __construct($strength)
    {
        $this->strength = $strength;
    }

    public function passes($attribute, $value)
    {
        if (env('APP_ENV') !== 'production') {
            if ($value === 'password') {
                return true;
            }
        }

        $this->analysis = (new Zxcvbn())->passwordStrength($value);
        $score = $this->analysis['score'] + 1;

        return $score >= $this->strength;
    }

    public function message()
    {
        $warning = $this->analysis['feedback']['warning'] ?? '';
        $suggestions = implode(' ', $this->analysis['feedback']['suggestions'] ?? []);

        return "Please use a stronger password, {$warning}. {$suggestions}";
    }
}

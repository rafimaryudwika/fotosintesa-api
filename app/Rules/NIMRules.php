<?php

namespace App\Rules;

use App\Traits\PeriodeParams;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NIMRules implements ValidationRule
{
    use PeriodeParams;
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public $implicit = false;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array(substr($value, 0, 3), $this->GetSyaratPeserta()) === false) {
            $fail('Kamu tidak memenuhi syarat pendaftaran Fotosintesa, ' . $this->GetFailedMessage());
        }
    }
}

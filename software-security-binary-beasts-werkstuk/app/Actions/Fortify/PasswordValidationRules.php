<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;
use \illuminate\Validation\Rules\Password as PasswordValidation;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required', 'string',
            (new Password)->requireSpecialCharacter()->requireUppercase(),PasswordValidation::min(8)->uncompromised(300), 'confirmed'];
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckGatewayNameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!empty($value)){
//            return class_exists(ucfirst($value));
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'this gateway name not exit please add appropriate class';
    }
}

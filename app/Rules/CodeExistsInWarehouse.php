<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;

class CodeExistsInWarehouse implements Rule
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
    public function passes($attribute, $resourceCode)
    {
        if (DB::table('resources')->where('code', $resourceCode)->where(
                'warehouse', Auth::user()->warehouse)->count() > 0 ||
                strlen($resourceCode) < 1 || strlen($resourceCode) > 50) {
            return 0;
        };
        return 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Zasób istnieje już na tym magazynie lub jego kod nie jest prawidłowy.';
    }
}

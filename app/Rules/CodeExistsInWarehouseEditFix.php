<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Resource;

class CodeExistsInWarehouseEditFix implements Rule
{
    public $code;
    public $id;
    
    public function __construct(string $code, int $id)
    {
        $this->code = $code;
        $this->id = $id;
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
        $resourceId = Resource::find($this->id);
        $proposedResource = Resource::where('code', $resourceCode)
        ->where('warehouse', Auth::user()->warehouse)->first();
        if ($proposedResource != null) {
            if ($proposedResource->id != $this->id ||
                    strlen($resourceCode) < 1 || strlen($resourceCode) > 50) {
                return 0;
            };
        }
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

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Resource;

class NameExistsInWarehouseEditFix implements Rule
{
    public $name;
    public $id;
    public function __construct(string $name, int $id)
    {
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $resourceName)
    {
        $resourceId = Resource::find($this->id);
        $proposedResource = Resource::where('name', $resourceName)
        ->where('warehouse', Auth::user()->warehouse)->first();
        if ($proposedResource != null) {
            if ($proposedResource->id != $this->id ||
                    strlen($resourceName) < 1 || strlen($resourceName) > 50) {
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
        return 'Zasób istnieje już na tym magazynie lub jego nazwa nie jest prawidłowa.';
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OneOrOther implements Rule
{
    protected $other_field_name;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($other_field_name)
    {
        $this->other_field_name = $other_field_name;
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
        if(request()->has($attribute)) {
            if(request()->has($this->other_field_name)) {
                $other_value = request()->get($this->other_field_name);
                return empty($other_value);
            }
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
        return "Only :attribute or {$this->other_field_name} may be non-empty.";
    }
}

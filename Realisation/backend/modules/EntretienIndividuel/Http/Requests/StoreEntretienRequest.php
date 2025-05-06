<?php

namespace Modules\EntretienIndividuel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntretienRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Add your validation rules here
        ];
    }
} 
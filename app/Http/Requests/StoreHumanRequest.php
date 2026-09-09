<?php

namespace App\Http\Requests;

use App\Models\Human;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class StoreHumanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'aura' => ['required', 'integer', 'min:0'],
            'hierarchy' => ['required', new In(Human::HIERARCHIES)],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'company_id' => 'sometimes|exists:companies,id',
            'name' => 'sometimes',
            'location' => 'sometimes',
            'lat' => 'sometimes',
            'long' => 'sometimes',
            'timezone' => 'sometimes',
            'country' => 'sometimes',
        ];
    }
}

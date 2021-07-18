<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreURLRedirectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reuqest rules
     *
     * @return array request rules
     */
    public function rules()
    {
        return [
            'url' => 'required|url',
            'delete_at' => 'nullable|date',
            'check_url' => 'nullable|boolean'
        ];
    }

    /**
     * Request json
     *
     * @return bool
     */
    public function wantsJson(): bool
    {
        return true;
    }
}

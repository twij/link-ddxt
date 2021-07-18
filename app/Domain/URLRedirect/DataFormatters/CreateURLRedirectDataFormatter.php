<?php

namespace App\Domain\URLRedirect\DataFormatters;

use App\Support\DataFormatter\DataFormatter;

class CreateURLRedirectDataFormatter extends DataFormatter
{
    /**
     * @var array Allowed keys
     */
    protected array $allowed = [
        'url',
        'token',
        'user_id',
        'delete_at'
    ];
    
    /**
     * @var array Validation rules
     */
    protected array $rules = [
        'url' => 'required|url',
        'token' => 'required|string|unique:App\Domain\URLRedirect\URLRedirect,token',
        'user_id' => 'nullable|integer|exists:users',
        'delete_at' => 'nullable|date'
    ];
}

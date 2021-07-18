<?php

namespace App\Domain\URLRedirect\DataTransferObjects;

use App\Support\DataTransferObject\DataTransferObject;

class URLRedirectDTO extends DataTransferObject
{
    /**
     * @var array Allowed keys
     */
    protected array $allowed = [
        'url',
        'delete_at',
        'check_url'
    ];

    /**
     * @var string Url to redirect
     */
    public string $url;

    /**
     * @var string Token string (generated)
     */
    public string $token;

    /**
     * @var int User id
     */
    public int $user_id;

    /**
     * @var string Delete at date
     */
    public string $delete_at;

    /**
     * @var bool Check if the url is valid before creating a record
     */
    public bool $check_url = false;
}

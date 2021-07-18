<?php

namespace App\Domain\URLRedirect;

use App\Support\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class URLRedirect extends Model
{
    use SoftDeletes;

    use PresentableTrait;

    /**
     * @var string Define presenter
     */
    protected $presenter = 'App\Domain\URLRedirect\URLRedirectPresenter';

    protected $table = 'url_redirects';

    /**
     * @var string[] Fillable properties
     */
    protected $fillable = [
        'token',
        'url',
        'user_id',
        'delete_at'
    ];
}

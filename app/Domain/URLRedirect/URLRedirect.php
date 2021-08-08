<?php

namespace App\Domain\URLRedirect;

use App\Support\Presenter\PresentableTrait;
use Database\Factories\URLRedirectFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class URLRedirect extends Model
{
    use SoftDeletes;

    use PresentableTrait;

    use HasFactory;

    /**
     * Define presenter
     *
     * @var string
     */
    protected $presenter = 'App\Domain\URLRedirect\URLRedirectPresenter';

    /**
     * Database table
     *
     * @var string
     */
    protected $table = 'url_redirects';

    /**
     * Fillable properties
     *
     * @var string[]
     */
    protected $fillable = [
        'token',
        'url',
        'user_id',
        'delete_at'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory URLRedirect Factory
     */
    protected static function newFactory(): Factory
    {
        return URLRedirectFactory::new();
    }
}

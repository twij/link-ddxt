<?php

namespace App\Domain\URLRedirect;

use App\Support\Presenter\Presenter;
use Illuminate\Support\Facades\App;

class URLRedirectPresenter extends Presenter
{
    /**
     * Local URL
     *
     * @return string Local URL
     */
    public function localURL(): string
    {
        return App::make('url')->to('/'.$this->token);
    }
}

<?php

namespace App\Domain\URLRedirect;

use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use App\Domain\URLRedirect\Exceptions\URLNotFoundException;
use App\Support\Repository\Repository;
use Exception;
use Illuminate\Support\Str;

class URLRedirectRepository extends Repository implements URLRedirectRepositoryInterface
{
    /**
     * Specify model class
     * 
     * @return string 
     */
    public function model(): string
    {
        return URLRedirect::class;
    }

    /**
     * Get a unique token
     *
     * @return string Unique token
     *
     * @throws Exception
     */
    public function getUniqueToken(): string
    {
        $i = 0;
        $length = 4;
        do {
            if ($i > 1000000) {
                $length++;
                $i = 0;
            }
            $token = Str::random($length);
            $ex = $this->model->where('token', $token)->first();
            $i++;
        } while (!empty($ex));

        return $token;
    }

    /**
     * Find an entry by its token
     *
     * @param string $token Token value
     *
     * @return URLRedirect URL redirect
     *
     * @throws URLNotFoundException 
     */
    public function findByToken(string $token): URLRedirect
    {
        if ($redirect = $this->model->where('token', $token)->first()) {
            return $redirect;
        }

        throw new URLNotFoundException();
    }
}

<?php

namespace App\Http\Controllers;

use App\Domain\URLRedirect\Actions\CreateURLRedirectAction;
use App\Domain\URLRedirect\Actions\ResolveURLRedirectAction;
use App\Domain\URLRedirect\DataTransferObjects\URLRedirectDTO;
use App\Domain\URLRedirect\Exceptions\InvalidURLException;
use App\Http\Requests\StoreURLRedirectRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class URLRedirectController extends Controller
{
    /**
     * Store a URL Redirect
     *
     * @param CreateURLRedirectAction  $action   Create URL Redirect action
     * @param StoreURLRedirectRequest  $request  Request data
     *
     * @return JsonResponse Redirect URL
     *
     * @throws BindingResolutionException 
     * @throws ValidationException 
     * @throws InvalidURLException 
     */
    public function store(
        CreateURLRedirectAction $action,
        StoreURLRedirectRequest $request
    ): \Illuminate\Http\JsonResponse {
        return response()->json($action->execute(
            new URLRedirectDTO($request->validated())
        ));
    }

    /**
     * Get a redirect
     *
     * @param ResolveURLRedirectAction  $action  Resolve action
     * @param string                    $token   Token
     * 
     * @return RedirectResponse 
     * @throws BindingResolutionException 
     */
    public function get(
        ResolveURLRedirectAction $action,
        string $token
    ): \Illuminate\Http\RedirectResponse {
        return redirect($action->execute($token));
    }
}

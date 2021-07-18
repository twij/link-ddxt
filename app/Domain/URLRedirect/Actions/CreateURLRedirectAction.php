<?php

namespace App\Domain\URLRedirect\Actions;

use App\Domain\URLRedirect\Actions\CheckURLIsValidAction;
use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use App\Domain\URLRedirect\DataFormatters\CreateURLRedirectDataFormatter;
use App\Domain\URLRedirect\DataTransferObjects\URLRedirectDTO;
use Illuminate\Database\Eloquent\Model;
use App\Domain\URLRedirect\Exceptions\InvalidURLException;

class CreateURLRedirectAction
{
    /**
     * @var URLRedirectRepositoryInterface URL Redirect repository
     */
    protected URLRedirectRepositoryInterface $redirect_repository;

    /**
     * @var CheckURLIsValidAction Check URL is valid action
     */
    protected CheckURLIsValidAction $check_url_action;

    /**
     * Creates a new URL Redirect entry
     *
     * @param URLRedirectRepositoryInterface  $redirect_repository  URL Redirect repository
     * @param CheckURLIsValidAction           $check_url_action     Check URL is valid action
     */
    public function __construct(
        URLRedirectRepositoryInterface $redirect_repository,
        CheckURLIsValidAction $check_url_action
    ) {
        $this->redirect_repository = $redirect_repository;
        $this->check_url_action = $check_url_action;
    }

    /**
     * Execute the action
     *
     * @param URLRedirectDTO $data Request data
     *
     * @return Model New URL Redirect model
     *
     * @throws InvalidURLException 
     */
    public function execute(URLRedirectDTO $data): array
    {
        if ($data->check_url) {
            $this->check_url_action->execute($data->url);
        }

        $data->token = $this->redirect_repository->getUniqueToken();

        $redirect = $this->redirect_repository->create(
            $data->applyFormatter(new CreateURLRedirectDataFormatter())
        );

        return ['url' => $redirect->present()->localURL];
    }
}
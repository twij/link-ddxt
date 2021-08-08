<?php

namespace App\Domain\URLRedirect;

use App\Domain\URLRedirect\Actions\CheckURLRedirectDeletedAction;
use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use App\Domain\URLRedirect\Exceptions\URLDeletedException;
use App\Domain\URLRedirect\Exceptions\URLNotFoundException;
use App\Support\Repository\Repository;
use Exception;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Container\Container;
use Illuminate\Log\Logger;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class URLRedirectRepository extends Repository implements URLRedirectRepositoryInterface
{
    /**
     * Cache repository
     *
     * @var CacheRepository
     */
    protected CacheRepository $cache;

    /**
     * Cache prefix key
     *
     * @var string
     */
    protected string $cache_key;

    /**
     * Logger
     *
     * @var Logger
     */
    protected Logger $logger;

    /**
     * App container
     *
     * @var Container
     */
    protected Container $container;

    /**
     * Constructor
     *
     * @param CacheRepository $cache Cache repository
     */
    public function __construct(
        Container $container,
        Collection $collection,
        CacheRepository $cache,
        Logger $logger
    ) {
        parent::__construct($container, $collection);
        $this->container = $container;
        $this->cache = $cache;
        $this->cache_key = $this->model() . '-';
        $this->logger = $logger;
    }

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
     * Find a redirect by its token
     *
     * @param string $token Token value
     *
     * @return URLRedirect URL Redirect entry
     *
     * @throws URLNotFoundException 
     */
    public function findByToken(string $token): URLRedirect
    {
        if ($result = $this->model->where('token', $token)->first()) {
            return $result;
        }
        
        throw new URLNotFoundException();
    }

    /**
     * Find a URL by its token (cached)
     *
     * @param string $token Token value
     *
     * @return string Redirect URL
     *
     * @throws URLNotFoundException 
     */
    public function findURLByTokenCached(string $token): string
    {
        return $this->cache->rememberForever(
            $this->cache_key . $token,
            function () use ($token) {
                if (! $redirect = $this->model->where('token', $token)->first()) {
                    throw new URLNotFoundException();
                }

                if ($this->container->make(
                    CheckURLRedirectDeletedAction::class
                )->execute($redirect)) {
                    throw new URLDeletedException();
                }

                return $redirect->url;
            }
        );
    }

    /**
     * Create new entry and cache its URL
     *
     * @param array $data Model data
     *
     * @return URLRedirect New URL Redirect
     */
    public function create(array $data): URLRedirect
    {
        $new = parent::create($data);
        $this->cache->put($this->cache_key . $new->token, $new->url);
        return $new;
    }

    /**
     * Delete an entry and remove from cache
     *
     * @param int $id Id to delete
     *
     * @return null|bool Status
     */
    public function delete(int $id): ?bool
    {
        $entry = $this->model->find($id);
        $this->cache->forget($this->cache_key . $entry->token);
        return parent::delete($id);
    }

    /**
     * Update an entry and cache
     *
     * @param array   $data       Data
     * @param int     $id         Id
     * @param string  $attribute  Attribute
     *
     * @return URLRedirect Updated model
     */
    public function update(array $data, int $id): URLRedirect
    {
        if ($entry = $this->model->where('id', '=', $id)->first()) {
            if (isset($data['token'])) {
                $this->cache->forget($this->cache_key . $data['token']);
            }
            if ($entry->update($data)) {
                $entry->refresh();
                $this->cache->put($this->cache_key . $entry->token, $entry->url);
                return $entry;
            }
        }
        return null;
    }
}

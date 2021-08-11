<?php

namespace App\Domain\URLRedirect\Exceptions;

use Exception;

class URLDeletedException extends Exception
{
    /**
     * Status code
     */
    protected int $status;

    /**
     * Message
     */
    protected $message;

    /**
     * Constructor
     *
     * @param integer $status
     */
    public function __construct(
        string $message = "The URL has been deleted",
        int $status = 400
    ) {
        $this->message = $message;
        $this->status = $status;
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function report(): void
    {
    }

    /**
     * Render as json
     *
     * @return \Illuminate\Http\JsonResponse Error message as json
     */
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => $this->getMessage()], $this->status);
    }
}

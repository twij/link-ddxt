<?php

namespace Tests\Unit\Domain\URLRedirect\DataTransferObjects;

use App\Domain\URLRedirect\DataTransferObjects\URLRedirectDTO;
use Tests\TestCase;

class URLRedirectDTOTest extends TestCase
{
    /**
     * Test DTO attributes are set correctly
     *
     * @return void
     */
    public function test_dto()
    {
        $payload = [
            'url' => 'https://ddxt.cc',
            'delete_at' => '2021-12-12',
            'check_url' => true
        ];

        $dto = new URLRedirectDTO($payload);

        $this->assertEquals($dto->url, $payload['url']);
        $this->assertEquals($dto->delete_at, $payload['delete_at']);
        $this->assertEquals($dto->check_url, $payload['check_url']);
    }
}

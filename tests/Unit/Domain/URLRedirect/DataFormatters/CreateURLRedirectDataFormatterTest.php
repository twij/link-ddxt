<?php

namespace Tests\Unit\Domain\URLRedirect\DataFormatters;

use App\Domain\URLRedirect\DataFormatters\CreateURLRedirectDataFormatter;
use App\Domain\URLRedirect\DataTransferObjects\URLRedirectDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateURLRedirectDataFormatterTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test data formatter
     *
     * @return void
     */
    public function test_data_formatter()
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

        $dto->token = 'test';

        $formatted = $dto->applyFormatter(new CreateURLRedirectDataFormatter());

        $this->assertEquals($dto->url, $formatted['url']);
        $this->assertEquals($dto->token, $formatted['token']);
        $this->assertEquals($dto->delete_at, $formatted['delete_at']);
        $this->assertArrayNotHasKey('check_url', $formatted);
    }
}

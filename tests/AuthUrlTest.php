<?php
namespace Patreon\Tests;

use Patreon\AuthUrl;
use PHPUnit\Framework\TestCase;

class AuthUrlTest extends TestCase
{
    public function testBasics()
    {
        $url = new AuthUrl('EXAMPLE');
        $clone = $url->withClientId('DIFFERENT');
        $this->assertNotEquals($url->buildUrl(), $clone->buildUrl());

        $full = (new AuthUrl('exampleClientId', 'http://localhost'))
            ->withAddedScope('identity')
            ->withAddedScope('identity[email]')
            ->withState(['secret' => 'agent man'])
            ->with('fursona', 'dhole');

        // @codingStandardsIgnoreStart
        $this->assertSame(
            'https://www.patreon.com/oauth2/authorize?response_type=code&client_id=exampleClientId&redirect_uri=http%3A%2F%2Flocalhost&state=eyJzZWNyZXQiOiJhZ2VudCBtYW4iLCJmdXJzb25hIjoiZGhvbGUifQ%3D%3D&scope=identity+identity%5Bemail%5D',
            // @codingStandardsIgnoreEnd
            (string) $full
        );
    }
}

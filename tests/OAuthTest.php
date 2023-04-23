<?php
namespace Patreon\Tests;

use Patreon\OAuth;
use PHPUnit\Framework\TestCase;

/**
 * Class OAuthTest
 * @package Patreon\Tests
 */
class OAuthTest extends TestCase
{
    public function testOAuthConstructor()
    {
        $this->assertInstanceOf(
            OAuth::class,
            new OAuth('a', 'b')
        );

        $this->assertInstanceOf(
            OAuth::class,
            new OAuth('a', 'b')
        );
    }
}

<?php
namespace Patreon\Tests;

use Patreon\API;
use PHPUnit\Framework\TestCase;

/**
 * Class APITest
 * @package Patreon\Tests
 */
class APITest extends TestCase
{
    public function testOAuthConstructor()
    {
        $this->assertInstanceOf(
            API::class,
            new API('test')
        );
    }
}

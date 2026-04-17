<?php

namespace Softspring\Component\FilterAttackVectors\Tests;

use PHPUnit\Framework\TestCase;

class FilterScriptTest extends TestCase
{
    public function testShouldBlockWordPressPaths(): void
    {
        self::assertTrue(softspring_filter_attack_vectors_should_block('/wp-admin/install.php'));
    }

    public function testShouldBlockPhpRequests(): void
    {
        self::assertTrue(softspring_filter_attack_vectors_should_block('/index.php'));
    }

    public function testShouldBlockEnvInjectionRequests(): void
    {
        self::assertTrue(softspring_filter_attack_vectors_should_block('/?foo=bar+--env=prod'));
    }

    public function testShouldAllowSafeRequests(): void
    {
        self::assertFalse(softspring_filter_attack_vectors_should_block('/articles/hello-world'));
    }

    public function testShouldAllowWhenRequestUriIsMissing(): void
    {
        self::assertFalse(softspring_filter_attack_vectors_should_block(null));
    }

    public function testBlocksWordPressPaths(): void
    {
        [$exitCode, $output] = $this->runScript('/wp-admin/install.php');

        self::assertSame(0, $exitCode);
        self::assertSame('Not Found', $output);
    }

    public function testBlocksPhpRequests(): void
    {
        [$exitCode, $output] = $this->runScript('/index.php');

        self::assertSame(0, $exitCode);
        self::assertSame('Not Found', $output);
    }

    public function testBlocksEnvInjectionRequests(): void
    {
        [$exitCode, $output] = $this->runScript('/?foo=bar+--env=prod');

        self::assertSame(0, $exitCode);
        self::assertSame('Not Found', $output);
    }

    public function testAllowsSafeRequests(): void
    {
        [$exitCode, $output] = $this->runScript('/articles/hello-world');

        self::assertSame(0, $exitCode);
        self::assertSame('ALLOWED', $output);
    }

    /**
     * @return array{0:int,1:string}
     */
    private function runScript(string $requestUri): array
    {
        $phpCode = \sprintf(
            '$_SERVER["REQUEST_URI"] = %s; require %s; echo "ALLOWED";',
            var_export($requestUri, true),
            var_export(\dirname(__DIR__).'/scripts/filter.php', true)
        );

        $command = \sprintf('php -r %s', escapeshellarg($phpCode));

        exec($command, $output, $exitCode);

        return [$exitCode, implode("\n", $output)];
    }
}

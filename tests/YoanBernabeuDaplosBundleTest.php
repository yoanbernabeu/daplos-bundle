<?php

namespace YoanBernabeu\DaplosBundle\Tests;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\DaplosBundle\YoanBernabeuDaplosBundle;

class YoanBernabeuDaplosBundleTest extends TestCase
{
    public function testBundleCanBeInstantiated(): void
    {
        $bundle = new YoanBernabeuDaplosBundle();
        $this->assertInstanceOf(YoanBernabeuDaplosBundle::class, $bundle);
    }

    public function testGetPath(): void
    {
        $bundle = new YoanBernabeuDaplosBundle();
        $path = $bundle->getPath();

        $this->assertDirectoryExists($path);
    }
}


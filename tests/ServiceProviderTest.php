<?php

/*
 * This file is part of Laravel Exceptions.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CristianVuolo\Tests\Exceptions;

use CristianVuolo\Exceptions\Displayers\DebugDisplayer;
use CristianVuolo\Exceptions\Displayers\HtmlDisplayer;
use CristianVuolo\Exceptions\Displayers\JsonApiDisplayer;
use CristianVuolo\Exceptions\Displayers\JsonDisplayer;
use CristianVuolo\Exceptions\ExceptionHandler;
use CristianVuolo\Exceptions\Filters\CanDisplayFilter;
use CristianVuolo\Exceptions\Filters\ContentTypeFilter;
use CristianVuolo\Exceptions\Filters\VerboseFilter;
use CristianVuolo\Exceptions\NewExceptionHandler;
use CristianVuolo\TestBenchCore\ServiceProviderTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testExceptionHandlerIsInjectable()
    {
        $this->assertIsInjectable($this->getHandlerClass());
    }

    protected function getHandlerClass()
    {
        $app = $this->app;

        if (version_compare($app::VERSION, '5.3') < 0) {
            return ExceptionHandler::class;
        }

        return NewExceptionHandler::class;
    }

    public function testJsonApiDisplayerIsInjectable()
    {
        $this->assertIsInjectable(JsonApiDisplayer::class);
    }

    public function testJsonDisplayerIsInjectable()
    {
        $this->assertIsInjectable(JsonDisplayer::class);
    }

    public function testDebugDisplayerIsInjectable()
    {
        $this->assertIsInjectable(DebugDisplayer::class);
    }

    public function testHtmlDisplayerIsInjectable()
    {
        $this->assertIsInjectable(HtmlDisplayer::class);
    }

    public function testCanDisplayFilterIsInjectable()
    {
        $this->assertIsInjectable(CanDisplayFilter::class);
    }

    public function testContentTypeFilterIsInjectable()
    {
        $this->assertIsInjectable(ContentTypeFilter::class);
    }

    public function testVerboseFilterIsInjectable()
    {
        $this->assertIsInjectable(VerboseFilter::class);
    }

    public function testDisplayerConfig()
    {
        $displayers = $this->app->config->get('exceptions.displayers');

        $this->assertInternalType('array', $displayers);
        $this->assertCount(5, $displayers);

        foreach ($displayers as $displayer) {
            $this->assertTrue(starts_with($displayer, 'CristianVuolo\Exceptions\Displayers'));
        }
    }

    public function testFilterConfig()
    {
        $filters = $this->app->config->get('exceptions.filters');

        $this->assertInternalType('array', $filters);
        $this->assertCount(3, $filters);

        foreach ($filters as $filter) {
            $this->assertTrue(starts_with($filter, 'CristianVuolo\Exceptions\Filters'));
        }
    }
}

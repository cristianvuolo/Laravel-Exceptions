<?php

/*
 * This file is part of Laravel Exceptions.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CristianVuolo\Tests\Exceptions\Filters;

use Exception;
use CristianVuolo\Exceptions\Displayers\DebugDisplayer;
use CristianVuolo\Exceptions\Displayers\HtmlDisplayer;
use CristianVuolo\Exceptions\Displayers\JsonDisplayer;
use CristianVuolo\Exceptions\ExceptionInfo;
use CristianVuolo\Exceptions\Filters\VerboseFilter;
use CristianVuolo\TestBench\AbstractTestCase;
use Illuminate\Http\Request;
use Mockery;

/**
 * This is the verbose filter test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class VerboseFilterTest extends AbstractTestCase
{
    public function testDebugStaysOnTop()
    {
        $request = Mockery::mock(Request::class);
        $exception = new Exception();
        $verbose = new DebugDisplayer();
        $standard = new JsonDisplayer(new ExceptionInfo('foo'));

        $displayers = (new VerboseFilter(true))->filter([$verbose, $standard], $request, $exception, $exception, 500);

        $this->assertSame([$verbose, $standard], $displayers);
    }

    public function testDebugIsRemoved()
    {
        $request = Mockery::mock(Request::class);
        $exception = new Exception();
        $verbose = new DebugDisplayer();
        $standard = new JsonDisplayer(new ExceptionInfo('foo'));

        $displayers = (new VerboseFilter(false))->filter([$verbose, $standard], $request, $exception, $exception, 500);

        $this->assertSame([$standard], $displayers);
    }

    public function testNoChangeInDebugMode()
    {
        $request = Mockery::mock(Request::class);
        $exception = new Exception();

        $assets = function ($path) {
            return 'https://example.com/'.ltrim($path, '/');
        };

        $json = new JsonDisplayer(new ExceptionInfo('foo'));
        $html = new HtmlDisplayer(new ExceptionInfo('foo'), $assets, 'foo');

        $displayers = (new VerboseFilter(true))->filter([$json, $html], $request, $exception, $exception, 500);

        $this->assertSame([$json, $html], $displayers);
    }

    public function testNoChangeNotInDebugMode()
    {
        $request = Mockery::mock(Request::class);
        $exception = new Exception();
        $json = new JsonDisplayer(new ExceptionInfo('foo'));

        $displayers = (new VerboseFilter(false))->filter([$json], $request, $exception, $exception, 500);

        $this->assertSame([$json], $displayers);
    }
}

<?php

/*
 * This file is part of Laravel Exceptions.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CristianVuolo\Exceptions\Displayers;

use Exception;
use CristianVuolo\Exceptions\ExceptionInfo;
use Illuminate\Contracts\View\Factory;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is the view displayer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ViewDisplayer implements DisplayerInterface
{
    /**
     * The exception info instance.
     *
     * @var \CristianVuolo\Exceptions\ExceptionInfo
     */
    protected $info;

    /**
     * The view factory instance.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $factory;

    /**
     * Create a new view displayer instance.
     *
     * @param \CristianVuolo\Exceptions\ExceptionInfo $info
     * @param \Illuminate\Contracts\View\Factory       $factory
     *
     * @return void
     */
    public function __construct(ExceptionInfo $info, Factory $factory)
    {
        $this->info = $info;
        $this->factory = $factory;
    }

    /**
     * Get the error response associated with the given exception.
     *
     * @param \Exception $exception
     * @param string     $id
     * @param int        $code
     * @param string[]   $headers
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function display(Exception $exception, $id, $code, array $headers)
    {
        $info = $this->info->generate($exception, $id, $code);

        return new Response($this->factory->make("errors.{$code}", $info), $code, array_merge($headers, ['Content-Type' => $this->contentType()]));
    }

    /**
     * Get the supported content type.
     *
     * @return string
     */
    public function contentType()
    {
        return 'text/html';
    }

    /**
     * Can we display the exception?
     *
     * @param \Exception $original
     * @param \Exception $transformed
     * @param int        $code
     *
     * @return bool
     */
    public function canDisplay(Exception $original, Exception $transformed, $code)
    {
        return $this->factory->exists("errors.{$code}");
    }

    /**
     * Do we provide verbose information about the exception?
     *
     * @return bool
     */
    public function isVerbose()
    {
        return false;
    }
}

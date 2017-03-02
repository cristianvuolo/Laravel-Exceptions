<?php

/*
 * This file is part of Laravel Exceptions.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CristianVuolo\Exceptions\Filters;

use Exception;
use Illuminate\Http\Request;

/**
 * This is the filter interface.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
interface FilterInterface
{
    /**
     * Filter and return the displayers.
     *
     * @param \CristianVuolo\Exceptions\Displayers\DisplayerInterface[] $displayers
     * @param \Illuminate\Http\Request                                   $request
     * @param \Exception                                                 $original
     * @param \Exception                                                 $transformed
     * @param int                                                        $code
     *
     * @return \CristianVuolo\Exceptions\Displayers\DisplayerInterface[]
     */
    public function filter(array $displayers, Request $request, Exception $original, Exception $transformed, $code);
}

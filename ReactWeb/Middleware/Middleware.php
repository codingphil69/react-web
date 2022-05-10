<?php

declare(strict_types=1);

namespace ReactWeb\Middleware;

use ReactWeb\Enum\BasicActionEnum;
use ReactWeb\HTTP\Response;
use ReactWeb\HTTP\Request;

/**
 * Middleware
 *
 * @package ReactWeb\Middleware
 * @author Philipp Lohmann <philipp.lohmann@check24.de>
 * @copyright CHECK24 GmbH
 */
abstract class Middleware
{
    private readonly Request $request;

    public function createInstance(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    abstract public function evaluate(): BasicActionEnum|Response;
}
<?php

declare(strict_types=1);

namespace ReactMvc\Middleware;

use ReactMvc\Enum\BasicActionEnum;
use ReactMvc\Mvc\Http\AbstractResponse;
use ReactMvc\Mvc\Http\Request;

/**
 * Middleware
 *
 * @package ReactMvc\Middleware
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

    abstract public function run(): BasicActionEnum|AbstractResponse;
}
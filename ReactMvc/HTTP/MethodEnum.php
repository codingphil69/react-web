<?php

namespace ReactMvc\HTTP;

/**
 * MethodEnum
 *
 * @package ReactMvc\HTTP
 * @author Philipp Lohmann <philipp.lohmann@check24.de>
 * @copyright CHECK24 GmbH
 */
enum MethodEnum: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case OPTIONS = 'OPTION';
}
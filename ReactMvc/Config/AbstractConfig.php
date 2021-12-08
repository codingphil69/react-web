<?php

namespace ReactMvc\Config;

use ReactMvc\Config\Exception\ConfigFileNotFoundException;
use ReactMvc\Config\Exception\ConfigFileNotInterpretableException;
use ReactMvc\Config\Exception\ConfigTypeNotSupportedException;
use ReactMvc\Config\Exception\UnableToCreateConfigException;
use ReactMvc\Enum\BasicActionEnum;

/**
 * AbstractConfig
 *
 * @package ReactMvc\App\Exception\Config
 * @author Philipp Lohmann <philipp.lohmann@check24.de>
 * @copyright CHECK24 GmbH
 */
abstract class AbstractConfig
{
    private array $data = [];

    private const HIERARCHY_OPERATOR = '::';

    /**
     * @throws ConfigFileNotFoundException
     * @throws ConfigFileNotInterpretableException
     */
    public function __construct(private string $configFile)
    {
        if (!file_exists($this->configFile)) {
            throw new ConfigFileNotFoundException(sprintf('Configurationfile %s not found', $this->configFile));
        }

        try {
            $this->data = $this->interpretConfig();
        } catch (ConfigTypeNotSupportedException|UnableToCreateConfigException) {
            throw new ConfigFileNotInterpretableException(sprintf('Configurationfile %s is not interpretable', $this->configFile));
        }
    }

    /**
     * @param string|null $configFile
     * @throws Exception\ConfigTypeNotSupportedException
     * @throws Exception\UnableToCreateConfigException
     */
    private function interpretConfig(string $configFile = null): array
    {
        $configFile = $configFile ?? $this->configFile;
        $explodedConfigFile = explode('.', strtolower($configFile));
        $fileEnding = end($explodedConfigFile);

        $configType = ConfigType::getByString($fileEnding);
        $interpreter = $configType->getInterpreter();

        $data = $interpreter->fromFile($configFile);

        return $data;
    }

    /**
     * @param string $node
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $node, mixed $default = null): mixed
    {
        if (str_contains($node, self::HIERARCHY_OPERATOR)) {
            $data = $this->data;
            $nodes = explode(self::HIERARCHY_OPERATOR, $node);

            foreach ($nodes as $node) {
                $data = $data[$node] ?? $default;
            }
        } else {
            $data = $this->data[$node] ?? $default;
        }

        return $data;
    }

    /**
     * @param string $separator
     * @param array $nodes
     * @return string
     */
    public function implode(string $separator, array $nodes): string
    {
        $data = [];

        foreach ($nodes as $node) {
            $data[] = $this->get($node);
        }

        return implode($separator, $data);
    }
}
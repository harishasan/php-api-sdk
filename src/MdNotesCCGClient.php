<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib;

use MdNotesCCGLib\Controllers;
use MdNotesCCGLib\Http\HttpCallBack;

/**
 * MdNotesCCGLib client class
 */
class MdNotesCCGClient implements ConfigurationInterface
{
    private OAuthManager $oAuthManager;
    private array $authManagers;

    private $user;
    private $service;
    private $oAuthAuthorization;

    private $timeout = ConfigurationDefaults::TIMEOUT;
    private $oAuthClientId = ConfigurationDefaults::O_AUTH_CLIENT_ID;
    private $oAuthClientSecret = ConfigurationDefaults::O_AUTH_CLIENT_SECRET;
    private $oAuthToken = ConfigurationDefaults::OAUTH_TOKEN;
    private $environment = ConfigurationDefaults::ENVIRONMENT;

    public function __construct(array $configOptions = null)
    {
        $oAuthClientId = null;
        $oAuthClientSecret = null;
        $oAuthToken = null;

        if (isset($configOptions['oAuthClientId'])) {
            $oAuthClientId = $configOptions['oAuthClientId'];
        }
        if (isset($configOptions['oAuthClientSecret'])) {
            $oAuthClientSecret = $configOptions['oAuthClientSecret'];
        }
        if (isset($configOptions['oAuthToken'])) {
            $oAuthToken = clone $configOptions['oAuthToken'];
        }
        if (isset($configOptions['timeout'])) {
            $this->timeout = $configOptions['timeout'];
        }
        if (isset($configOptions['environment'])) {
            $this->environment = $configOptions['environment'];
        }

        if(isset($this->authManagers['global'])) {
            $this->oAuthManager = $this->authManagers['global'];
        }
        if(!isset($this->authManagers['global']) || !$this->getOAuthCredentials()->equals($oAuthClientId, $oAuthClientSecret)) {
            $this->oAuthManager = new OAuthManager($oAuthClientId, $oAuthClientSecret, $oAuthToken, $this);
            $this->authManagers['global'] = $this->oAuthManager;
        }
    }

    /**
     * Get the client configuration as an associative array
     */
    public function getConfiguration(): array
    {
        $configMap = [];

        if ($this->getOAuthCredentials()->getOAuthClientId() !== null) {
            $configMap['oAuthClientId'] = $this->getOAuthCredentials()->getOAuthClientId();
        }
        if ($this->getOAuthCredentials()->getOAuthClientSecret() !== null) {
            $configMap['oAuthClientSecret'] = $this->getOAuthCredentials()->getOAuthClientSecret();
        }
        if ($this->getOAuthCredentials()->getOAuthToken() !== null) {
            $configMap['oAuthToken'] = clone $this->getOAuthCredentials()->getOAuthToken();
        }
        if (isset($this->timeout)) {
            $configMap['timeout'] = $this->timeout;
        }
        if (isset($this->environment)) {
            $configMap['environment'] = $this->environment;
        }

        return $configMap;
    }

    /**
     * Clone this client and override given configuration options
     */
    public function withConfiguration(array $configOptions): self
    {
        return new self(\array_merge($this->getConfiguration(), $configOptions));
    }

    public function getOAuthCredentials(): OAuthCredentials
    {
        return $this->oAuthManager;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * Get the base uri for a given server in the current environment
     *
     * @param  string $server Server name
     *
     * @return string         Base URI
     */
    public function getBaseUri(string $server = Server::DEFAULT_): string
    {
        return static::ENVIRONMENT_MAP[$this->environment][$server];
    }

    /**
     * Returns User Controller
     */
    public function getUserController(?HttpCallBack $httpCallBack = null): Controllers\UserController
    {
        if ($this->user == null) {
            $this->user = new Controllers\UserController($this, $this->authManagers, $httpCallBack);
        }
        return $this->user;
    }

    /**
     * Returns Service Controller
     */
    public function getServiceController(?HttpCallBack $httpCallBack = null): Controllers\ServiceController
    {
        if ($this->service == null) {
            $this->service = new Controllers\ServiceController($this, $this->authManagers, $httpCallBack);
        }
        return $this->service;
    }

    /**
     * Returns O Auth Authorization Controller
     */
    public function getOAuthAuthorizationController(?HttpCallBack $httpCallBack = null): Controllers\OAuthAuthorizationController
    {
        if ($this->oAuthAuthorization == null) {
            $this->oAuthAuthorization = new Controllers\OAuthAuthorizationController($this, $this->authManagers, $httpCallBack);
        }
        return $this->oAuthAuthorization;
    }

    /**
     * A map of all baseurls used in different environments and servers
     *
     * @var array
     */
    private const ENVIRONMENT_MAP = [
        Environment::PRODUCTION => [
            Server::DEFAULT_ => 'http://localhost:3000/oauth2/non-auth-server',
            Server::AUTH => 'http://localhost:3000/oauth2/auth-server',
        ],
    ];
}

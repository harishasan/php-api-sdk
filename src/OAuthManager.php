<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib;

use MdNotesCCGLib\Controllers\OAuthAuthorizationController;
use MdNotesCCGLib\Http\HttpRequest;
use MdNotesCCGLib\Models\OAuthToken;

/**
 * Utility class for OAuth 2 authorization and token management
 */
class OAuthManager implements AuthManager, OAuthCredentials
{
    /**
     * Singleton instance of OAuth 2 API controller
     * @var OAuthAuthorizationController
     */
    private $oAuthApi;

    private ?string $oAuthClientId;

    private ?string $oAuthClientSecret;

    private ?OAuthToken $oAuthToken;

    /**
     * Returns an instance of this class.
     */
    public function __construct(?string $oAuthClientId, ?string $oAuthClientSecret, ?OAuthToken $oAuthToken, $config, $oAuthApi = null)
    {
        $this->oAuthClientId = $oAuthClientId;
        $this->oAuthClientSecret = $oAuthClientSecret;
        $this->oAuthToken = $oAuthToken;
        if (isset($oAuthApi)) {
            $this->oAuthApi = $oAuthApi;
        } else {
            $this->oAuthApi = new OAuthAuthorizationController($config, null);
        }
    }

    public function getOAuthClientId(): ?string
    {
        return $this->oAuthClientId;
    }

    public function getOAuthClientSecret(): ?string
    {
        return $this->oAuthClientSecret;
    }

    public function getOAuthToken(): ?OAuthToken
    {
        return $this->oAuthToken;
    }

    public function equals(?string $oAuthClientId, ?string $oAuthClientSecret): bool
    {
        return $this->oAuthClientId == $oAuthClientId
                && $this->oAuthClientSecret == $oAuthClientSecret;
    }

    /**
     * Authorize the client with the OAuth provider
     * @param  array|string|null $scope             List of scopes needed.
     * @param  array|null        $additionalParams  Additional parameters to send during authorization
     */
    private function authorize($scope = null, ?array $additionalParams = null): Models\OAuthToken
    {
        //send request for access token
        $oAuthToken = $this->oAuthApi->requestToken(
            $this->buildBasicHeader(),
            is_array($scope) ? implode(' ', $scope) : $scope,
            $additionalParams
        );
        
        //add expiry
        if ($oAuthToken->getExpiresIn() != null && $oAuthToken->getExpiresIn() != 0) {
            $oAuthToken->setExpiry(time() + $oAuthToken->getExpiresIn());
        }

        $this->oAuthToken = $oAuthToken;
        return $oAuthToken;
    }

    /**
     * Has the OAuth token expired?
     */
    public function isTokenExpired(): bool
    {
        return null !== $this->getOAuthToken()->getExpiry() &&
            $this->getOAuthToken()->getExpiry() < time();
    }

    /**
     * Check if client is authorized, else attempt to get token
     */
    private function isAuthorized(): bool
    {
        return $this->getOAuthToken() != null && !$this->isTokenExpired();
    }

    /**
     * Build authorization header value for basic auth
     */
    private function buildBasicHeader(): string
    {
        return 'Basic ' . base64_encode(
            $this->getOAuthClientId() . ':' . $this->getOAuthClientSecret()
        );
    }

    private function getAuthorizationHeader(): string
    {
        return 'Bearer ' . $this->getOAuthToken()->getAccessToken();
    }

    public function apply(HttpRequest $httpRequest): HttpRequest
    {
        if(!$this->isAuthorized())
        {
            $this->authorize();
        }
        print('-----header: '. $this->getAuthorizationHeader());
        $headers = $httpRequest->getHeaders();
        $headers['Authorization'] = $this->getAuthorizationHeader();
        $httpRequest->setHeaders($headers);
        return $httpRequest;
    }
}

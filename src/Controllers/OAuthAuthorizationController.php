<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib\Controllers;

use MdNotesCCGLib\Exceptions\ApiException;
use MdNotesCCGLib\ApiHelper;
use MdNotesCCGLib\ConfigurationInterface;
use MdNotesCCGLib\Http\HttpRequest;
use MdNotesCCGLib\Http\HttpResponse;
use MdNotesCCGLib\Http\HttpMethod;
use MdNotesCCGLib\Http\HttpContext;
use MdNotesCCGLib\Http\HttpCallBack;
use MdNotesCCGLib\Server;
use Unirest\Request;

class OAuthAuthorizationController extends BaseController
{
    public function __construct(ConfigurationInterface $config, ?array $authManagers, ?HttpCallBack $httpCallBack = null)
    {
        parent::__construct($config, $authManagers, $httpCallBack);
    }

    /**
     * Create a new OAuth 2 token.
     *
     * @param string $authorization Authorization header in Basic auth format
     * @param string|null $scope Requested scopes as a space-delimited list.
     * @param array|null $fieldParameters Additional optional form parameters are supported by
     *                                    this endpoint
     *
     * @return \MdNotesCCGLib\Models\OAuthToken Response from the API call
     *
     * @throws ApiException Thrown if API call fails
     */
    public function requestToken(
        string $authorization,
        ?string $scope = null,
        array $fieldParameters = null
    ): \MdNotesCCGLib\Models\OAuthToken {
        //prepare query string for API call
        $_queryBuilder = '/request_token';

        //validate and preprocess url
        $_queryUrl = ApiHelper::cleanUrl($this->config->getBaseUri(Server::AUTH) . $_queryBuilder);

        //prepare headers
        $_headers = [
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json',
            'Authorization'   => $authorization
        ];

        //prepare parameters
        $_parameters = [
            'grant_type'    => 'client_credentials',
            'scope'         => $scope
        ];
        if (isset($fieldParameters)) {
            $_parameters = array_merge($_parameters, $fieldParameters);
        }

        $_httpRequest = new HttpRequest(HttpMethod::POST, $_headers, $_queryUrl, $_parameters);

        //call on-before Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }
        // Set request timeout
        Request::timeout($this->config->getTimeout());

        // and invoke the API call request to fetch the response
        try {
            $response = Request::post($_queryUrl, $_headers, Request\Body::Form($_parameters));
        } catch (\Unirest\Exception $ex) {
            throw new ApiException($ex->getMessage(), $_httpRequest);
        }

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw $this->createExceptionFromJson(
                '\\MdNotesCCGLib\\Exceptions\\OAuthProviderException',
                'OAuth 2 provider returned an error.',
                $_httpRequest,
                $_httpResponse
            );
        }

        if ($response->code == 401) {
            throw $this->createExceptionFromJson(
                '\\MdNotesCCGLib\\Exceptions\\OAuthProviderException',
                'OAuth 2 provider says client authentication failed.',
                $_httpRequest,
                $_httpResponse
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpRequest);
        $mapper = $this->getJsonMapper();
        return $mapper->mapClass($response->body, 'MdNotesCCGLib\\Models\\OAuthToken');
    }
}

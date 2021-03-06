<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib\Controllers;

use MdNotesCCGLib\Http\HttpCallBack;
use MdNotesCCGLib\Http\HttpResponse;
use MdNotesCCGLib\Http\HttpRequest;
use MdNotesCCGLib\Exceptions\ApiException;
use MdNotesCCGLib\ConfigurationInterface;
use apimatic\jsonmapper\JsonMapper;

/**
 * Base controller
 */
class BaseController
{
    /**
     * User-agent to be sent with API calls
     *
     * @var string
     */
    protected const USER_AGENT = 'APIMATIC 2.0';

    /**
     * HttpCallBack instance associated with this controller
     *
     * @var HttpCallBack|null
     */
    private $httpCallBack = null;

    /**
     * Configuration instance
     *
     * @var ConfigurationInterface
     */
    protected $config;

    /**
     * Authorization managers
     */
    protected ?array $authManagers;

    /**
     * Constructor that sets the timeout of requests
     */
    protected function __construct(ConfigurationInterface $config, ?array $authManagers, ?HttpCallBack $httpCallBack = null)
    {
        $this->config = $config;
        $this->authManagers = $authManagers;

        if (isset($httpCallBack)) {
            $this->httpCallBack = $httpCallBack;
        }
    }

    /**
     * Get HttpCallBack for this controller
     *
     * @return HttpCallBack|null The HttpCallBack object set for this controller
     */
    public function getHttpCallBack(): ?HttpCallBack
    {
        return $this->httpCallBack;
    }

    /**
     * Get a new JsonMapper instance for mapping objects
     *
     * @return \apimatic\jsonmapper\JsonMapper JsonMapper instance
     */
    protected function getJsonMapper(): JsonMapper
    {
        $mapper = new JsonMapper();
        $mapper->sAdditionalPropertiesCollectionMethod = 'addAdditionalProperty';
        return $mapper;
    }

    /**
     * Validate response or throw exception based on the status code
     */
    protected function validateResponse(HttpResponse $response, HttpRequest $request): void
    {
        if (($response->getStatusCode() < 200) || ($response->getStatusCode() > 208)) { //[200,208] = HTTP OK
            throw new ApiException('HTTP Response Not OK', $request, $response);
        }
    }

    /**
     * Create and get ApiException-derived exception instance
     */
    protected function createExceptionFromJson(
        string $type,
        string $reason,
        HttpRequest $request,
        HttpResponse $response
    ) {
        $body = json_decode($response->getRawBody());

        if ($body === null) {
            return new ApiException($reason, $request, $response);
        } else {
            $body->reason = $reason;
            $body->request = $request;
            $body->response = $response;
        }

        return $this->getJsonMapper()->mapClass($body, $type);
    }
}

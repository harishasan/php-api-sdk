<?php
/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib\Tests;

use MdNotesCCGLib\Http\HttpCallBack;

/**
 * An HTTPCallBack that captures the request and response for use later
 */
class HttpCallBackCatcher extends HttpCallBack
{
    /**
     * Http request
     * @var MdNotesCCGLib\Http\HttpRequest
     */
    private $request;

    /**
     * Http Response
     * @var MdNotesCCGLib\Http\HttpResponse
     */
    private $response;

    /**
     * Create instance
     */
    public function __construct()
    {
        $instance = $this;
        parent::__construct(null, function ($httpContext) use ($instance) {
            $instance->request = $httpContext->getRequest();
            $instance->response = $httpContext->getResponse();
        });
    }

    /**
     * Get the HTTP Request object associated with this API call
     * @return MdNotesCCGLib\Http\HttpRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the HTTP Response object associated with this API call
     * @return MdNotesCCGLib\Http\HttpResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}

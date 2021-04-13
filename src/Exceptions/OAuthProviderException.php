<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib\Exceptions;

/**
 * OAuth 2 Authorization endpoint exception
 */
class OAuthProviderException extends \MdNotesCCGLib\Exceptions\ApiException
{
    /**
     * @var string
     */
    private $error;

    /**
     * @var string|null
     */
    private $errorDescription;

    /**
     * @var string|null
     */
    private $errorUri;

    /**
     * @param string $reason
     * @param \MdNotesCCGLib\Http\HttpRequest $request
     * @param \MdNotesCCGLib\Http\HttpResponse $response
     * @param string $error
     */
    public function __construct(
        string $reason,
        \MdNotesCCGLib\Http\HttpRequest $request,
        \MdNotesCCGLib\Http\HttpResponse $response,
        string $error
    ) {
        parent::__construct($reason, $request, $response);
        $this->error = $error;
    }

    /**
     * Returns Error.
     *
     * Error code
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * Sets Error.
     *
     * Error code
     *
     * @required
     * @maps error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * Returns Error Description.
     *
     * Human-readable text providing additional information on error.
     * Used to assist the client developer in understanding the error that occurred.
     */
    public function getErrorDescription(): ?string
    {
        return $this->errorDescription;
    }

    /**
     * Sets Error Description.
     *
     * Human-readable text providing additional information on error.
     * Used to assist the client developer in understanding the error that occurred.
     *
     * @maps error_description
     */
    public function setErrorDescription(?string $errorDescription): void
    {
        $this->errorDescription = $errorDescription;
    }

    /**
     * Returns Error Uri.
     *
     * A URI identifying a human-readable web page with information about the error, used to provide the
     * client developer with additional information about the error
     */
    public function getErrorUri(): ?string
    {
        return $this->errorUri;
    }

    /**
     * Sets Error Uri.
     *
     * A URI identifying a human-readable web page with information about the error, used to provide the
     * client developer with additional information about the error
     *
     * @maps error_uri
     */
    public function setErrorUri(?string $errorUri): void
    {
        $this->errorUri = $errorUri;
    }

    private $additionalProperties = [];

    /**
     * Add an additional property to this model.
     *
     * @param string $name Name of property
     * @param mixed $value Value of property
     */
    public function addAdditionalProperty(string $name, $value)
    {
        $this->additionalProperties[$name] = $value;
    }
}

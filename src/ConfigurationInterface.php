<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib;

/**
 * An interface for all configuration parameters required by the SDK.
 */
interface ConfigurationInterface
{
    public function getOAuthCredentials(): OAuthCredentials;

    /**
     * Get timeout for API calls
     */
    public function getTimeout(): int;

    /**
     * Get current API environment
     */
    public function getEnvironment(): string;

    /**
     * Get the base uri for a given server in the current environment
     *
     * @param string $server Server name
     *
     * @return string Base URI
     */
    public function getBaseUri(string $server = Server::DEFAULT_): string;
}

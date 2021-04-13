<?php

declare(strict_types=1);

namespace MdNotesCCGLib;

use MdNotesCCGLib\Models\OAuthToken;

interface OAuthCredentials
{
    /**
     * String value for oAuthClientId
     */
    public function getOAuthClientId(): ?string;

    /**
     * String value for oAuthClientSecret
     */
    public function getOAuthClientSecret(): ?string;

    /**
     * OAuthToken value for oAuthToken
     */
    public function getOAuthToken(): ?OAuthToken;

    /**
     * Checks if provided credentials matched with existing ones.
     */
    public function equals(?string $oAuthClientId, ?string $oAuthClientSecret): bool;
}
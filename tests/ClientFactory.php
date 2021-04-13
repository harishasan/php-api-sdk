<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib\Tests;

class ClientFactory
{
    public static function create(): \MdNotesCCGLib\MdNotesCCGClient
    {
        return (new \MdNotesCCGLib\MdNotesCCGClient(static::getConfigurationFromEnvironment()))
            ->withConfiguration(static::getTestConfiguration());
    }

    public static function getTestConfiguration(): array
    {
        return ['oAuthClientId' => '23', 'oAuthClientSecret' => 'tQNSqQlXBIwZcY9auoujQ57ckDcoh3t8UPbBRkSF'];
    }

    public static function getConfigurationFromEnvironment(): array
    {
        $config = [];
        $timeout = getenv('MD_NOTES_CCG_LIB_TIMEOUT');
        $oAuthClientId = getenv('MD_NOTES_CCG_LIB_O_AUTH_CLIENT_ID');
        $oAuthClientSecret = getenv('MD_NOTES_CCG_LIB_O_AUTH_CLIENT_SECRET');
        $environment = getenv('MD_NOTES_CCG_LIB_ENVIRONMENT');

        if ($timeout !== false && \is_numeric($timeout)) {
            $config['timeout'] = intval($timeout);
        }

        if ($oAuthClientId !== false) {
            $config['oAuthClientId'] = $oAuthClientId;
        }

        if ($oAuthClientSecret !== false) {
            $config['oAuthClientSecret'] = $oAuthClientSecret;
        }

        if ($environment !== false) {
            $config['environment'] = $environment;
        }

        return $config;
    }
}

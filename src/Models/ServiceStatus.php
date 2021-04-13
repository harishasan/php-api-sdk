<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib\Models;

class ServiceStatus implements \JsonSerializable
{
    /**
     * @var string
     */
    private $app;

    /**
     * @var string
     */
    private $moto;

    /**
     * @var int
     */
    private $notes;

    /**
     * @var int
     */
    private $users;

    /**
     * @var string
     */
    private $time;

    /**
     * @var string
     */
    private $os;

    /**
     * @var string
     */
    private $phpVersion;

    /**
     * @var string
     */
    private $status;

    /**
     * @param string $app
     * @param string $moto
     * @param int $notes
     * @param int $users
     * @param string $time
     * @param string $os
     * @param string $phpVersion
     * @param string $status
     */
    public function __construct(
        string $app,
        string $moto,
        int $notes,
        int $users,
        string $time,
        string $os,
        string $phpVersion,
        string $status
    ) {
        $this->app = $app;
        $this->moto = $moto;
        $this->notes = $notes;
        $this->users = $users;
        $this->time = $time;
        $this->os = $os;
        $this->phpVersion = $phpVersion;
        $this->status = $status;
    }

    /**
     * Returns App.
     */
    public function getApp(): string
    {
        return $this->app;
    }

    /**
     * Sets App.
     *
     * @required
     * @maps app
     */
    public function setApp(string $app): void
    {
        $this->app = $app;
    }

    /**
     * Returns Moto.
     */
    public function getMoto(): string
    {
        return $this->moto;
    }

    /**
     * Sets Moto.
     *
     * @required
     * @maps moto
     */
    public function setMoto(string $moto): void
    {
        $this->moto = $moto;
    }

    /**
     * Returns Notes.
     */
    public function getNotes(): int
    {
        return $this->notes;
    }

    /**
     * Sets Notes.
     *
     * @required
     * @maps notes
     */
    public function setNotes(int $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * Returns Users.
     */
    public function getUsers(): int
    {
        return $this->users;
    }

    /**
     * Sets Users.
     *
     * @required
     * @maps users
     */
    public function setUsers(int $users): void
    {
        $this->users = $users;
    }

    /**
     * Returns Time.
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * Sets Time.
     *
     * @required
     * @maps time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    /**
     * Returns Os.
     */
    public function getOs(): string
    {
        return $this->os;
    }

    /**
     * Sets Os.
     *
     * @required
     * @maps os
     */
    public function setOs(string $os): void
    {
        $this->os = $os;
    }

    /**
     * Returns Php Version.
     */
    public function getPhpVersion(): string
    {
        return $this->phpVersion;
    }

    /**
     * Sets Php Version.
     *
     * @required
     * @maps php_version
     */
    public function setPhpVersion(string $phpVersion): void
    {
        $this->phpVersion = $phpVersion;
    }

    /**
     * Returns Status.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     *
     * @required
     * @maps status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
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

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['app']        = $this->app;
        $json['moto']       = $this->moto;
        $json['notes']      = $this->notes;
        $json['users']      = $this->users;
        $json['time']       = $this->time;
        $json['os']         = $this->os;
        $json['php_version'] = $this->phpVersion;
        $json['status']     = $this->status;

        return array_merge($json, $this->additionalProperties);
    }
}

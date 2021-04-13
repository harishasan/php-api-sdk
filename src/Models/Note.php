<?php

declare(strict_types=1);

/*
 * MdNotesCCGLib
 *
 * 
 */

namespace MdNotesCCGLib\Models;

class Note implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @param int $id
     * @param string $title
     * @param string $body
     * @param int $userId
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(int $id, string $title, string $body, int $userId, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * @required
     * @maps id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets Title.
     *
     * @required
     * @maps title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns Body.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Sets Body.
     *
     * @required
     * @maps body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * Returns User Id.
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Sets User Id.
     *
     * @required
     * @maps user_id
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Returns Created At.
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * @required
     * @maps created_at
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     *
     * @required
     * @maps updated_at
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
        $json['id']        = $this->id;
        $json['title']     = $this->title;
        $json['body']      = $this->body;
        $json['user_id']   = $this->userId;
        $json['created_at'] = $this->createdAt;
        $json['updated_at'] = $this->updatedAt;

        return array_merge($json, $this->additionalProperties);
    }
}

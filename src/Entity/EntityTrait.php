<?php

namespace App\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Exception;

trait EntityTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={
     *     "default":"CURRENT_TIMESTAMP"
     * })
     */
    private $createdAt;

    /**
     * @return DateTime
     * @throws Exception
     */
    private function now(): DateTime
    {
        return new DateTime(null, new DateTimeZone('UTC'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    private function getFormattedCreated(): string
    {
        return $this->createdAt->format(
            'Y-m-d H:i:s'
        );
    }
}

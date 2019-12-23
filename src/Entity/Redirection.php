<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table as Table;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RedirectionRepository")
 * @Table(name="redirection",uniqueConstraints={@UniqueConstraint(name="uniqe_fromPath", columns={"from_path"})})
 * TODO: unique $fromPath
 */
class Redirection
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fromPath;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $toPath;

    /**
     * @ORM\Column(type="integer")
     */
    private $statusCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromPath(): ?string
    {
        return $this->fromPath;
    }

    public function setFromPath(string $fromPath): self
    {
        $this->fromPath = $this->normalizePath($fromPath);

        return $this;
    }

    public function getToPath(): ?string
    {
        return $this->toPath;
    }

    public function setToPath(string $toPath): self
    {
        $this->toPath = $this->normalizePath($toPath);

        return $this;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    private function normalizePath(string $path): string
    {
        $path = ltrim($path, '/');

        return '/'.urlencode($path);
    }
}

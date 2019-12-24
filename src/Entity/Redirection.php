<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table as Table;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RedirectionRepository")
 * @Table(name="redirection",uniqueConstraints={@UniqueConstraint(name="uniqe_fromPath", columns={"from_path"})})
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFromPath(): string
    {
        return $this->fromPath;
    }

    /**
     * @param string $fromPath
     * @return $this
     */
    public function setFromPath(string $fromPath): self
    {
        $this->fromPath = $this->normalizePath($fromPath);

        return $this;
    }

    /**
     * @return string
     */
    public function getToPath(): string
    {
        return $this->toPath;
    }

    /**
     * @param string $toPath
     * @return $this
     */
    public function setToPath(string $toPath): self
    {
        $this->toPath = $this->normalizePath($toPath);

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Do not urlencode trailing slash
     * @param string $path
     * @return string
     */
    private function normalizePath(string $path): string
    {
        $path = ltrim($path, '/');

        return '/'.urlencode($path);
    }
}

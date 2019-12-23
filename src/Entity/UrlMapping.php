<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UrlMappingRepository")
 * @Table(name="url_mapping",uniqueConstraints={@UniqueConstraint(name="unique_path", columns={"path"})})

 * TODO: unique $path
 */
class UrlMapping
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
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $controller;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $method;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $identifier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->decodePath($this->path);
    }

    public function setPath(string $path): self
    {
        $this->path = $this->encodePath($path);

        return $this;
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getIdentifier(): ?int
    {
        return $this->identifier;
    }

    public function setIdentifier(?int $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    private function encodePath(string $path): string
    {
        $path = ltrim($path, '/');

        return '/'.urlencode($path);
    }

    private function decodePath(string $path): string
    {
        $path = ltrim($path, '/');

        return '/'.urldecode($path);
    }
}

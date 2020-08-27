<?php

namespace App\Entity;

use App\Repository\Model3DRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Model3DRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Model3D
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, options={"default"="path-to-file.zip"})
     */
    private $file_path = "path-to-file.zip";

    /**
     * @ORM\Column(type="string", length=255, options={"default"="path-to-image.png"})
     */
    private $preview_path = "path-to-preview.png";

    /**
     * @ORM\Column(type="json", length=255)
     */
    private $rotations = [
        "alpha" => 0,
        "theta" => 0
    ];

    /**
     * @ORM\Column(type="string", length=10, options={"default"="gltf"})
     */
    private $type = "gltf";

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(string $file_path): self
    {
        $this->file_path = $file_path;

        return $this;
    }

    public function getPreviewPath(): ?string
    {
        return $this->preview_path;
    }

    public function setPreviewPath(string $preview_path): self
    {
        $this->preview_path = $preview_path;

        return $this;
    }

    public function getRotations(): ?array
    {
        return $this->rotations;
    }

    public function setRotations(string $rotations): self
    {
        $this->rotations = $rotations;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}

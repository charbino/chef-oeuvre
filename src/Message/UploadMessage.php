<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\HttpFoundation\File\File;

class UploadMessage
{
    private File $upload;
    private string $user;

    public function __construct(File $upload, string $user)
    {
        $this->upload = $upload;
        $this->user = $user;
    }

    public function getUpload(): File
    {
        return $this->upload;
    }

    public function setUpload(File $upload): void
    {
        $this->upload = $upload;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }
}

<?php

declare(strict_types=1);

namespace App\Message;

class UploadMessage
{
    private string $upload;
    private string $user;

    public function __construct(string $upload, string $user)
    {
        $this->upload = $upload;
        $this->user = $user;
    }

    public function getUpload(): string
    {
        return $this->upload;
    }

    public function setUpload(string $upload): void
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

<?php
declare(strict_types=1);

namespace App\Message;

use App\Entity\Upload;
use App\Entity\User;

/**
 * Class UploadMessage
 * @package App\Message
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
class UploadMessage
{

    private string $upload;
    private string $user;

    /**
     * @param string $upload
     * @param string $user
     */
    public function __construct(string $upload, string $user)
    {
        $this->upload = $upload;
        $this->user = $user;
    }


    /**
     * @return string
     */
    public function getUpload(): string
    {
        return $this->upload;
    }

    /**
     * @param string $upload
     */
    public function setUpload(string $upload): void
    {
        $this->upload = $upload;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }



}

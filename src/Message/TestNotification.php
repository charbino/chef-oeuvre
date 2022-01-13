<?php
declare(strict_types=1);

namespace App\Message;

/**
 * Class TestNotification
 * @package App\Message
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
class TestNotification
{
    private string $test;

    public function __construct(string $test)
    {
        $this->test = $test;
    }


    public function getTest(): string
    {
        return $this->test;
    }


    public function setTest(string $test): void
    {
        $this->test = $test;
    }


}

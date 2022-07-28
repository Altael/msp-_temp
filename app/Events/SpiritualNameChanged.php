<?php

namespace App\Events;


class SpiritualNameChanged
{
    public $userId;
    public $spiritualName;

    public function __construct($userId, $spiritualName)
    {
        $this->userId = $userId;
        $this->spiritualName = $spiritualName;
    }
}

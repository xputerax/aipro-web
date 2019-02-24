<?php

namespace App\Tools;

use Illuminate\Hashing\HashManager;

class MyHashManager extends HashManager
{
    public function createPlaintextDriver()
    {
        return new PlaintextHasher();
    }
}
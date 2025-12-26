<?php

namespace App\Services;

use Jackiedo\DotenvEditor\DotenvEditor as BaseDotenvEditor;

class SafeDotenvEditor extends BaseDotenvEditor
{
    public function save()
    {
        // Do nothing to prevent .env modification
        \Log::info('Prevented DotenvEditor save attempt.');
        return $this;
    }
}

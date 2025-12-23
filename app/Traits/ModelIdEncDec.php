<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait ModelIdEncDec
{
    public function getEncIdAttribute()
    {
        return Crypt::encrypt($this->id);
    }

    public function getDecIdAttribute()
    {
        return Crypt::decrypt($this->id);
    }
}

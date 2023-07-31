<?php

namespace App\Services;



class ActivationCodeService
{
    public function generateActivationCode()
    {
        return random_int(1000,999);
    }
}
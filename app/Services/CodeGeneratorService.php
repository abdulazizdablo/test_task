<?php


use App\Services;





class CodeGeneratorService
{

    protected $verfication_code;

    public function codeGenerate()
    {


        return  $this->verfication_code =  mt_rand(1000, 9999);
    }
}

<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function mostrarLogin(): string
    {
        return view('login');
    }
}

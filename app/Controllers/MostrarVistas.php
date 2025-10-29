<?php

namespace App\Controllers;


class MostrarVistas extends BaseController
{
    public function mostrarLogin(): string
    {
        return view('login');
    }
    public function mostrarVentas(): string
    {
        return view('ventas');
    }
    public function mostrarProduccion(): string
    {
        return view('produccion');
    }
    public function mostrarHome(): string
    {
        return view('home');
    }
    public function mostrarReportes(): string
    {
        return view('reportes');
    }
}
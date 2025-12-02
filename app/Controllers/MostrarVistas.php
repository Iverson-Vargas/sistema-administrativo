<?php

namespace App\Controllers;


class MostrarVistas extends BaseController
{
    public function mostrarLogin(): string
    {
        return view('login');
    }

    public function mostrarGenerarVenta(): string
    {
        return view('generarVenta');
    }
    
    public function mostrarGenerarCompra(): string
    {
        return view('generarCompra');
    }

    public function mostrarHome(): string
    {
        return view('home');
    }

    public function mostrarReportes(): string
    {
        return view('reportes');
    }

    public function mostrarReporteVentas(): string
    {
        return view('reporteVentas');
    }

    public function mostrarReporteCompras(): string
    {
        return view('reporteCompras');
    }

    public function mostrarCrearLote(): string
    {
        return view('crearLote');
    }

    public function mostrarProducto(): string
    {
        return view('producto');
    }

    public function mostrarUsuario(): string
    {
        return view('usuario');
    }

    public function mostrarCosturero(): string
    {
        return view('costurero');
    }

    public function mostrarPersonal(): string
    {
        return view('personal');
    }
}
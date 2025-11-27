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

    public function mostrarCrearProducto(): string
    {
        return view('crearProducto');
    }

    public function mostrarCrearUsuario(): string
    {
        return view('crearUsuario');
    }

    public function mostrarCrearCosturero(): string
    {
        return view('crearCosturero');
    }
}
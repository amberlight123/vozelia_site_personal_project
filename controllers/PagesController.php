<?php

class PagesController
{
    public function home(): void
    {
        require __DIR__ . '/../views/pages/home.php';
    }

    public function servicios(): void
    {
        require __DIR__ . '/../views/pages/servicios.php';
    }

    public function tarifas(): void
    {
        require __DIR__ . '/../views/pages/tarifas.php';
    }

    public function numeracion(): void
    {
        require __DIR__ . '/../views/pages/numeracion.php';
    }

    public function contacto(): void
    {
        require __DIR__ . '/../views/pages/contacto.php';
    }

    public function privacidad(): void
    {
        require __DIR__ . '/../views/pages/privacidad.php';
    }

    public function terminos(): void
    {
        require __DIR__ . '/../views/pages/terminos.php';
    }
}

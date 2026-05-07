<?php



// app/Controllers/HomeController.php
class HomeController
{
    public function index()
    {
        // Lógica de negócios pode vir aqui
        require_once '../app/Views/home.php';
    }
}

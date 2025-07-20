<?php

namespace Controllers\Funciones;

use Controllers\PrivateController;
use Dao\Funciones\Funciones as FuncionesDao;
use Views\Renderer;

class Funciones extends PrivateController
{
    private array $viewData;
    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "funciones" => []
        ];
    }
    public function run(): void
    {
        $this->viewData["funciones"] = FuncionesDao::getFunciones();
        Renderer::render("Funciones/Funciones", $this->viewData);
    }
}

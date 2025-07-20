<?php

namespace Controllers\Usuarios;

use Controllers\PrivateController;
use Dao\Usuarios\Usuarios as UsuariosDao;
use Views\Renderer;

class Usuarios extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "usuarios" => []
        ];
    }

    public function run(): void
    {

        $this->viewData["usuarios"] = UsuariosDao::getUsuarios();


        Renderer::render("Usuarios/Usuarios", $this->viewData);
    }
}

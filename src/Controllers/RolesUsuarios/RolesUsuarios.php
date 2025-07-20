<?php

namespace Controllers\RolesUsuarios;

use Controllers\PrivateController;
use Dao\RolesUsuarios\RolesUsuarios as RolesUsuariosDao;
use Views\Renderer;

class RolesUsuarios extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "roles_usuarios" => []
        ];
    }

    public function run(): void
    {
        // Obtener todas las relaciones entre roles y usuarios
        $this->viewData["roles_usuarios"] = RolesUsuariosDao::obtenerTodo();

        // Renderizar la vista RolesUsuarios/RolesUsuarios.tpl o .view.twig
        Renderer::render("RolesUsuarios/RolesUsuarios", $this->viewData);
    }
}

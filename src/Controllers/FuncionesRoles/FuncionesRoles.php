<?php

namespace Controllers\FuncionesRoles;

use Controllers\PrivateController;
use Dao\FuncionesRoles\FuncionesRoles as FuncionesRolesDao;
use Views\Renderer;

class FuncionesRoles extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "funciones_roles" => []
        ];
    }

    public function run(): void
    {
        // Obtener todas las relaciones de funciones con roles
        $this->viewData["funciones_roles"] = FuncionesRolesDao::getFuncionesRoles();

        // Renderizar la vista FuncionesRoles/FuncionesRoles.tpl (o .view.twig, según tu motor)
        Renderer::render("FuncionesRoles/FuncionesRoles", $this->viewData);
    }
}

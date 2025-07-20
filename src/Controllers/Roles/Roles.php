<?php

namespace Controllers\Roles;

use Controllers\PrivateController;
use Dao\Roles\Roles as RolesDao;
use Views\Renderer;

class Roles extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "roles" => []
        ];
    }

    public function run(): void
    {
        parent::__construct();
        $this->viewData["roles"] = RolesDao::getRoles();
        Renderer::render("Roles/Roles", $this->viewData);
    }
}

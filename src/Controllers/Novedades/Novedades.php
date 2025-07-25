<?php

namespace Controllers\Novedades;

use Controllers\PrivateController;
use Dao\Novedades\Novedades as NovedadesDao;
use Views\Renderer;

class Novedades extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "novedades" => []
        ];
    }

    public function run(): void
    {
        $this->viewData["novedades"] = NovedadesDao::getNovedades();

        Renderer::render("novedades/novedades", $this->viewData);
    }
}

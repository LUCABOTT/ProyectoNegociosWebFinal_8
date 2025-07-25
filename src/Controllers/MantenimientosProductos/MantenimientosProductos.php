<?php

namespace Controllers\MantenimientosProductos;

use Controllers\PrivateController;
use Dao\MantenimientoProductos\MantenimientoProductos as ProductosDao;
use Views\Renderer;

class MantenimientosProductos extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "products" => []
        ];
    }

    public function run(): void
    {
        $this->viewData["productos"] = ProductosDao::getProductos();

        Renderer::render("mantenimientosproductos/mantenimientosproductos", $this->viewData);
    }
}

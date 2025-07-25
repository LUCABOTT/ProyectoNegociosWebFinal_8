<?php

namespace Controllers\Sales;

use Controllers\PrivateController;
use Dao\Sales\Sales as SalesDao;
use Views\Renderer;

class Sales extends PrivateController
{
    private array $viewData;

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [
            "ventas" => []
        ];
    }

    public function run(): void
    {
        $this->viewData["ventas"] = SalesDao::getSales();

        Renderer::render("sales/sales", $this->viewData);
    }
}

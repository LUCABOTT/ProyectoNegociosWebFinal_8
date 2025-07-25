<?php

namespace Controllers\Sales;

use Controllers\PrivateController;
use Dao\Sales\Sales as SalesDao;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

const LIST_URL = "index.php?page=Sales-Sales";
const XSR_KEY = "xsrToken_venta";

class Sal extends PrivateController
{
    private array $viewData;
    private array $modes;

    public function __construct()
    {
        $this->modes = [
            "INS" => 'Creando nueva venta',
            "UPD" => 'Modificando venta %s',
            "DEL" => 'Eliminando venta %s',
            "DSP" => 'Mostrando venta %s'
        ];

        $this->viewData = [
            "saleId"     => 0,
            "productId"  => 0,
            "salePrice"  => 0.00,
            "saleStart"  => "",
            "saleEnd"    => "",

            "mode"      => "",
            "modeDsc"   => "",
            "errores"   => [],
            "readonly"  => "",
            "showAction" => true,
            "xsrToken"  => ""
        ];
    }

    public function run(): void
    {
        $this->capturarModoPantalla();
        $this->datosDeDao();

        if ($this->isPostBack()) {
            $this->datosFormulario();
            $this->validarDatos();
            if (count($this->viewData["errores"]) === 0) {
                $this->procesarDatos();
            }
        }

        $this->prepararVista();
        Renderer::render("Sales/Sal", $this->viewData);
    }

    private function throwError(string $message)
    {
        Site::redirectToWithMsg(LIST_URL, $message);
    }

    private function capturarModoPantalla()
    {
        if (isset($_GET["mode"])) {
            $this->viewData["mode"] = $_GET["mode"];
            if (!isset($this->modes[$this->viewData["mode"]])) {
                $this->throwError("BAD REQUEST: Modo no válido.");
            }
        }
    }

    private function datosDeDao()
    {
        if ($this->viewData["mode"] !== "INS") {
            if (isset($_GET["id"])) {
                $this->viewData["saleId"] = intval($_GET["id"]);
                $venta = SalesDao::getSaleById($this->viewData["saleId"]);
                if (is_array($venta)) {
                    foreach ($this->viewData as $key => $value) {
                        if (isset($venta[$key])) {
                            $this->viewData[$key] = $venta[$key];
                        }
                    }
                } else {
                    $this->throwError("La venta no existe.");
                }
            } else {
                $this->throwError("No se proporcionó ID para consultar.");
            }
        }
    }

    private function datosFormulario()
    {
        foreach ($this->viewData as $key => $value) {
            if (isset($_POST[$key])) {
                if (in_array($key, ["salePrice"])) {
                    $this->viewData[$key] = floatval($_POST[$key]);
                } elseif (in_array($key, ["saleId", "productId"])) {
                    $this->viewData[$key] = intval($_POST[$key]);
                } else {
                    $this->viewData[$key] = trim($_POST[$key]);
                }
            }
        }
    }

    private function validarDatos()
    {
        if ($this->viewData["productId"] <= 0) {
            $this->viewData["errores"]["productId"] = "El ID del producto es obligatorio y debe ser válido.";
        }
        if (!is_numeric($this->viewData["salePrice"]) || $this->viewData["salePrice"] < 0) {
            $this->viewData["errores"]["salePrice"] = "El precio de venta debe ser un número positivo.";
        }
        if (Validators::IsEmpty($this->viewData["saleStart"])) {
            $this->viewData["errores"]["saleStart"] = "La fecha de inicio de la venta es obligatoria.";
        }
        if (Validators::IsEmpty($this->viewData["saleEnd"])) {
            $this->viewData["errores"]["saleEnd"] = "La fecha final de la venta es obligatoria.";
        }

        $tmpXsrToken = $_SESSION[XSR_KEY] ?? '';
        if ($this->viewData["xsrToken"] !== $tmpXsrToken) {
            error_log("Intento con token inválido en mantenimiento venta.");
            $this->throwError("Token inválido. Intente de nuevo.");
        }
    }

    private function procesarDatos()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                $result = SalesDao::nuevaVenta(
                    $this->viewData["productId"],
                    $this->viewData["salePrice"],
                    $this->viewData["saleStart"],
                    $this->viewData["saleEnd"]
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Venta creada correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo crear la venta.";
                }
                break;
            case "UPD":
                $result = SalesDao::actualizarVenta(
                    $this->viewData["saleId"],
                    $this->viewData["productId"],
                    $this->viewData["salePrice"],
                    $this->viewData["saleStart"],
                    $this->viewData["saleEnd"]
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Venta actualizada correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo actualizar la venta.";
                }
                break;
            case "DEL":
                $result = SalesDao::eliminarVenta($this->viewData["saleId"]);
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Venta eliminada correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo eliminar la venta.";
                }
                break;
        }
    }

    private function prepararVista()
    {
        $this->viewData["modeDsc"] = sprintf(
            $this->modes[$this->viewData["mode"]],
            $this->viewData["saleId"]
        );

        if (in_array($this->viewData["mode"], ["DEL", "DSP"])) {
            $this->viewData["readonly"] = "readonly";
        }

        if ($this->viewData["mode"] === "DSP") {
            $this->viewData["showAction"] = false;
        }
        $this->viewData["xsrToken"] = hash("sha256", random_int(10000, 99999) . time() . 'venta' . $this->viewData["mode"]);
        $_SESSION[XSR_KEY] = $this->viewData["xsrToken"];
    }
}

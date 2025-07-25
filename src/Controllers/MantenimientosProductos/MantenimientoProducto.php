<?php

namespace Controllers\MantenimientosProductos;

use Controllers\PrivateController;
use Dao\MantenimientoProductos\MantenimientoProductos as ProductosDao;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

const LIST_URL = "index.php?page=MantenimientosProductos-MantenimientosProductos";
const XSR_KEY = "xsrToken_producto";

class MantenimientoProducto extends PrivateController
{
    private array $viewData;
    private array $estados;
    private array $modes;

    public function __construct()
    {
        $this->modes = [
            "INS" => 'Creando nuevo producto',
            "UPD" => 'Modificando producto %s',
            "DEL" => 'Eliminando producto %s',
            "DSP" => 'Mostrando producto %s'
        ];
        $this->estados = ["ACT", "INA", "BLQ"]; // Puedes ajustar estados según tu lógica
        $this->viewData = [
            "productId"          => 0,
            "productName"        => "",
            "productDescription" => "",
            "productPrice"       => 0.00,
            "productStock"       => 0,
            "productImgUrl"      => "",
            "productStatus"      => "ACT",

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
        Renderer::render("MantenimientosProductos/MantenimientoProducto", $this->viewData);
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
                $this->viewData["productId"] = intval($_GET["id"]);
                $producto = ProductosDao::getProductoPorId($this->viewData["productId"]);
                if (is_array($producto)) {
                    foreach ($this->viewData as $key => $value) {
                        if (isset($producto[$key])) {
                            $this->viewData[$key] = $producto[$key];
                        }
                    }
                } else {
                    $this->throwError("El producto no existe.");
                }
            } else {
                $this->throwError("No se proporcionó ID para consultar.");
            }
        }
    }

    private function datosFormulario()
    {
        // Para cada campo definido en viewData, si viene en POST, se actualiza.
        foreach ($this->viewData as $key => $value) {
            if (isset($_POST[$key])) {
                // Cast numéricos si quieres, por ejemplo:
                if (in_array($key, ["productPrice"])) {
                    $this->viewData[$key] = floatval($_POST[$key]);
                } elseif (in_array($key, ["productStock", "productId"])) {
                    $this->viewData[$key] = intval($_POST[$key]);
                } else {
                    $this->viewData[$key] = trim($_POST[$key]);
                }
            }
        }
    }

    private function validarDatos()
    {
        if (Validators::IsEmpty($this->viewData["productName"])) {
            $this->viewData["errores"]["productName"] = "El nombre del producto es obligatorio.";
        }
        if (Validators::IsEmpty($this->viewData["productDescription"])) {
            $this->viewData["errores"]["productDescription"] = "La descripción es obligatoria.";
        }
        if (!is_numeric($this->viewData["productPrice"]) || $this->viewData["productPrice"] < 0) {
            $this->viewData["errores"]["productPrice"] = "El precio debe ser un número positivo.";
        }
        if (!is_int($this->viewData["productStock"]) || $this->viewData["productStock"] < 0) {
            $this->viewData["errores"]["productStock"] = "El stock debe ser un número entero positivo.";
        }
        if (Validators::IsEmpty($this->viewData["productImgUrl"])) {
            $this->viewData["errores"]["productImgUrl"] = "La URL de la imagen es obligatoria.";
        }
        if (!in_array($this->viewData["productStatus"], $this->estados)) {
            $this->viewData["errores"]["productStatus"] = "Estado no válido.";
        }

        $tmpXsrToken = $_SESSION[XSR_KEY] ?? '';
        if ($this->viewData["xsrToken"] !== $tmpXsrToken) {
            error_log("Intento con token inválido en mantenimiento producto.");
            $this->throwError("Token inválido. Intente de nuevo.");
        }
    }

    private function procesarDatos()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                $result = ProductosDao::nuevoProducto(
                    $this->viewData["productName"],
                    $this->viewData["productDescription"],
                    $this->viewData["productPrice"],
                    $this->viewData["productStock"],
                    $this->viewData["productImgUrl"],
                    $this->viewData["productStatus"]
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Producto creado correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo crear el producto.";
                }
                break;
            case "UPD":
                $result = ProductosDao::actualizarProducto(
                    $this->viewData["productId"],
                    $this->viewData["productName"],
                    $this->viewData["productDescription"],
                    $this->viewData["productPrice"],
                    $this->viewData["productStock"],
                    $this->viewData["productImgUrl"],
                    $this->viewData["productStatus"]
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Producto actualizado correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo actualizar el producto.";
                }
                break;
            case "DEL":
                $result = ProductosDao::eliminarProducto($this->viewData["productId"]);
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Producto eliminado correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo eliminar el producto.";
                }
                break;
        }
    }

    private function prepararVista()
    {
        $this->viewData["modeDsc"] = sprintf(
            $this->modes[$this->viewData["mode"]],
            $this->viewData["productId"]
        );

        // Estados seleccionados en combo
        foreach ($this->estados as $estado) {
            $this->viewData["estado" . $estado] = ($this->viewData["productStatus"] === $estado) ? "selected" : "";
        }

        // Errores
        if (count($this->viewData["errores"]) > 0) {
            foreach ($this->viewData["errores"] as $campo => $error) {
                $this->viewData["error_" . $campo] = $error;
            }
        }

        if (in_array($this->viewData["mode"], ["DEL", "DSP"])) {
            $this->viewData["readonly"] = "readonly";
        }

        if ($this->viewData["mode"] === "DSP") {
            $this->viewData["showAction"] = false;
        }

        $this->viewData["xsrToken"] = hash("sha256", random_int(10000, 99999) . time() . 'producto' . $this->viewData["mode"]);
        $_SESSION[XSR_KEY] = $this->viewData["xsrToken"];
    }
}

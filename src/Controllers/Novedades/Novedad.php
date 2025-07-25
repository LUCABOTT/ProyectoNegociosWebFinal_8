<?php

namespace Controllers\Novedades;

use Controllers\PrivateController;
use Dao\Novedades\Novedades as NovedadesDao;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

const LIST_URL = "index.php?page=Novedades-Novedades";
const XSR_KEY = "xsrToken_novedad";

class Novedad extends PrivateController
{
    private array $viewData;
    private array $modes;

    public function __construct()
    {
        $this->modes = [
            "INS" => 'Creando nueva novedad',
            "UPD" => 'Modificando novedad %s',
            "DEL" => 'Eliminando novedad %s',
            "DSP" => 'Mostrando novedad %s'
        ];

        $this->viewData = [
            "highlightId"     => 0,
            "productId"       => 0,
            "highlightStart"  => "",
            "highlightEnd"    => "",

            "mode"           => "",
            "modeDsc"        => "",
            "errores"        => [],
            "readonly"       => "",
            "showAction"     => true,
            "xsrToken"       => ""
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
        Renderer::render("Novedades/Novedad", $this->viewData);
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
                $this->viewData["highlightId"] = intval($_GET["id"]);
                $novedad = NovedadesDao::getNovedadPorId($this->viewData["highlightId"]);
                if (is_array($novedad)) {
                    foreach ($this->viewData as $key => $value) {
                        if (isset($novedad[$key])) {
                            $this->viewData[$key] = $novedad[$key];
                        }
                    }
                } else {
                    $this->throwError("La novedad no existe.");
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
                if (in_array($key, ["highlightId", "productId"])) {
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
        if (Validators::IsEmpty($this->viewData["highlightStart"])) {
            $this->viewData["errores"]["highlightStart"] = "La fecha de inicio de la novedad es obligatoria.";
        }
        if (Validators::IsEmpty($this->viewData["highlightEnd"])) {
            $this->viewData["errores"]["highlightEnd"] = "La fecha final de la novedad es obligatoria.";
        }

        $tmpXsrToken = $_SESSION[XSR_KEY] ?? '';
        if ($this->viewData["xsrToken"] !== $tmpXsrToken) {
            error_log("Intento con token inválido en mantenimiento novedad.");
            $this->throwError("Token inválido. Intente de nuevo.");
        }
    }

    private function procesarDatos()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                $result = NovedadesDao::nuevaNovedad(
                    $this->viewData["productId"],
                    $this->viewData["highlightStart"],
                    $this->viewData["highlightEnd"]
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Novedad creada correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo crear la novedad.";
                }
                break;
            case "UPD":
                $result = NovedadesDao::actualizarNovedad(
                    $this->viewData["highlightId"],
                    $this->viewData["productId"],
                    $this->viewData["highlightStart"],
                    $this->viewData["highlightEnd"]
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Novedad actualizada correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo actualizar la novedad.";
                }
                break;
            case "DEL":
                $result = NovedadesDao::eliminarNovedad($this->viewData["highlightId"]);
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Novedad eliminada correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo eliminar la novedad.";
                }
                break;
        }
    }

    private function prepararVista()
    {
        $this->viewData["modeDsc"] = sprintf(
            $this->modes[$this->viewData["mode"]],
            $this->viewData["highlightId"]
        );

        if (in_array($this->viewData["mode"], ["DEL", "DSP"])) {
            $this->viewData["readonly"] = "readonly";
        }

        if ($this->viewData["mode"] === "DSP") {
            $this->viewData["showAction"] = false;
        }

        $this->viewData["xsrToken"] = hash("sha256", random_int(10000, 99999) . time() . 'novedad' . $this->viewData["mode"]);
        $_SESSION[XSR_KEY] = $this->viewData["xsrToken"];
    }
}

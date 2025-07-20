<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Dao\Funciones\Funciones as FuncionesDao;
use Error;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

const LIST_URL = "index.php?page=Funciones-Funciones";
const XSR_KEY = "xsrToken_categorias";

class Funcion extends PublicController
{

    private array $viewData;
    private array $estados; // para validar modos de estado , udp ins etc
    private array $modes;
    private array $tipos;
    public function __construct()
    {
        $this->modes = [
            "INS" => 'Creando nueva funcion',
            "UPD" => 'Modificando funcion %s %s',
            "DEL" => 'Eliminado funcion %s %s',
            "DSP" => 'Mostrando funcion de %s %s'
        ];
        $this->estados = ["ACT", "INA", "BLQ", "SUS"];
        $this->tipos = ["ADM", "AUD", "PBL"];
        $this->viewData = [
            "fncod" => 0,
            "fndsc" => "",
            "fnest" => "ACT",
            "fntyp" => "ADM",
            "mode" => "",
            "modeDsc" => "",
            "estadoACT" => "",
            "estadoINA" => "",
            "estadoRTR" => "",
            "tipoADM" => "",
            "tipoREP" => "",
            "tipoCLI" => "",
            "errores" => [],
            "readonly" => "",
            "showAction" => true,
            "xsrToken" => ""
        ];
    }
    public function run(): void
    {
        /*
        1. Capturamos el Modo del Formuario
        2. Capturar la Data de la DB si no es INS
        3. Si es un Postback 
            3.1 Capturar la Data del Formulario
            3.2 Validar la informacion del Formulario
            3.3 Segun el modo llamar la función del DAO
            3.4 Enviar a Listado
        4. Prepara los datos de la vista
        5. Renderizar la vista.
        */
        $this->capturarModoPantalla();
        $this->datosDeDao();
        if ($this->isPostBack()) {  // funcion para capturar atos del formulario
            $this->datosFormulario();
            $this->validarDatos();
            if (count($this->viewData["errores"]) === 0) {
                $this->procesarDatos();
            }
        }

        $this->prepararVista();
        Renderer::render("Funciones/Funcion", $this->viewData);
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
                $this->throwError("BAD REQUEST: No se puede procesar su solicitud.");
            }
        }
    }
    private function datosDeDao()
    {
        if ($this->viewData["mode"] != "INS") {
            if (isset($_GET["id"])) {
                $this->viewData["fncod"] = ($_GET["id"]);
                $funcion = FuncionesDao::getFuncionesById($this->viewData["fncod"]);
                if (is_array($funcion)) {
                    $this->viewData["fncod"] = $funcion["fncod"];
                    $this->viewData["fndsc"] = $funcion["fndsc"];
                    $this->viewData["fnest"] = $funcion["fnest"];
                    $this->viewData["fntyp"] = $funcion["fntyp"];
                } else {
                    $this->throwError("BAD REQUEST: No existe registro en la DB");
                }
            } else {
                $this->throwError("BAD REQUEST: No se puede extraer el registro de la DB");
            }
        }
    }
    private function datosFormulario()
    {
        if (isset($_POST["fncod"])) {
            $tmpfncod = $_POST["fncod"];  // el nombre del imput de la vista de categoria
            $this->viewData["fncod"] = $tmpfncod;
        }
        if (isset($_POST["fndsc"])) {
            $tmpfndsc = $_POST["fndsc"];
            $this->viewData["fndsc"] = $tmpfndsc;
        }
        if (isset($_POST["fnest"])) {
            $tmpfnest = $_POST["fnest"];
            $this->viewData["fnest"] = $tmpfnest;
        }
        if (isset($_POST["fntyp"])) {
            $tmpfntyp = $_POST["fntyp"];
            $this->viewData["fntyp"] = $tmpfntyp;
        }
        if (isset($_POST["xsrToken"])) {
            $tmpXsrToken = $_POST["xsrToken"];
            $this->viewData["xsrToken"] = $tmpXsrToken;
        }
    }
    private function validarDatos()
    {
        if (Validators::IsEmpty($this->viewData["fncod"])) {
            $this->viewData["errores"]["fncod"] = "codigo es requerida";
        }
        if (Validators::IsEmpty($this->viewData["fndsc"])) {
            $this->viewData["errores"]["fndsc"] = "descripcion reqerida";
        }
        if (Validators::IsEmpty($this->viewData["fntyp"])) {
            $this->viewData["errores"]["fntyp"] = "tipo es requerida";
        }
        if (!in_array($this->viewData["fnest"], $this->estados)) { // in_aray para ver si ese esado esta dentro de un arreglo
            $this->viewData["errores"]["fnest"] = "El valor del estado no es correcto";
        }
        $tmpXsrToken = $_SESSION[XSR_KEY];  // EXTRAE TEMPERALMENTE EL "TOKEN"
        if ($this->viewData["xsrToken"] !== $tmpXsrToken) {
            error_log("Intento ingresar con un token inválido.");
            $this->throwError("Algo sucedió que impidio procesar la solicitud. Intente de nuevo!!");
        }
    }

    private function procesarDatos()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                if (
                    FuncionesDao::nuevaFuncion(
                        $this->viewData["fncod"],
                        $this->viewData["fndsc"],
                        $this->viewData["fnest"],
                        $this->viewData["fntyp"]
                    ) > 0
                ) {
                    Site::redirectToWithMsg(LIST_URL, "funcion agregada existosamente.");
                } else {
                    if (isset($this->viewData["errores"]["global"])) {
                        $this->viewData["errores"]["global"][] = "Error al crear nueva funcion.";
                    } else {
                        $this->viewData["errores"]["global"] = ["Error al crear nueva funcion."];
                    }
                }
                break;
            case "UPD":
                if (
                    FuncionesDao::actualizarfuncion(
                        $this->viewData["fncod"],
                        $this->viewData["fndsc"],
                        $this->viewData["fnest"],
                        $this->viewData["fntyp"]
                    )
                ) {
                    Site::redirectToWithMsg(LIST_URL, "Categoría actualizada existosamente.");
                } else {
                    $this->viewData["errores"]["global"] = ["Error al actualizar la categoría."];
                }
                break;
            case "DEL":
                if (
                    FuncionesDao::eliminarfuncion(
                        $this->viewData["fncod"]
                    )
                ) {
                    Site::redirectToWithMsg(LIST_URL, "Categoría eliminada existosamente.");
                } else {
                    $this->viewData["errores"]["global"] = ["Error al eliminar la categoría."];
                }
                break;
        }
    }
    private function prepararVista()
    {
        $this->viewData["modeDsc"] = sprintf(
            $this->modes[$this->viewData["mode"]],
            $this->viewData["fncod"],
            $this->viewData["fndsc"],
            $this->viewData["fndest"],
            $this->viewData["fntyp"]
        );
        $this->viewData["fnest" . $this->viewData["fnest"]] = 'selected';
        if (count($this->viewData["errores"]) > 0) {
            foreach ($this->viewData["errores"] as $campo => $error) {
                $this->viewData['error_' . $campo] = $error;
            }
        }
        // Elementos visuales
        if ($this->viewData["mode"] === "DEL" ||  $this->viewData["mode"] === "DSP") {
            $this->viewData["readonly"] = "readonly"; // aca para que si es eliminar o ver NOOO se pueda modificar
        }
        if ($this->viewData["mode"] === "DSP") {
            $this->viewData["showAction"] = false;
        }

        $this->viewData["xsrToken"] = hash("sha256", random_int(0, 1000000) . time() . 'categoria' . $this->viewData["mode"]);
        $_SESSION[XSR_KEY] = $this->viewData["xsrToken"]; // ESTO CADA VEZ QUE SE PREPARE LA VISTA GENERA UN VALOR ALEATORIO
    }
}

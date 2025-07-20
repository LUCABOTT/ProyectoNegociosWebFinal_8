<section class="container-m row px-4 py-4">
  <h1>{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=Funciones-Funcion&mode={{mode}}&id={{fncod}}" method="POST" class="col-12 col-m-8 offset-m-2">
    
   <div class="row my-2 align-center">
  <label class="col-12 col-m-3" for="fncod">Código</label>
  <input class="col-12 col-m-9"  type="text" name="fncod" id="fncod" placeholder="Código" value="{{fncod}}" {{readonly}} />
  <input type="hidden" name="mode" value="{{mode}}" />
  <input type="hidden" name="xsrToken" value="{{xsrToken}}" />
  {{if error_fncod}}
  <div class="col-12 col-m-9 offset-m-3 error">{{error_fncod}}</div>
  {{endif error_fncod}}
</div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="fndsc">Descripción</label>
      <input class="col-12 col-m-9" {{readonly}} type="text" name="fndsc" id="fndsc" placeholder="Descripción de la función" value="{{fndsc}}" />
      {{if error_fndsc}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_fndsc}}</div>
      {{endif error_fndsc}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="fntyp">Tipo</label>
      <select class="col-12 col-m-9" name="fntyp" id="fntyp" {{readonly}}>
        <option value="ADM" {{tipoADM}}>Administrador</option>
        <option value="AUD" {{tipoREP}}>Auditor</option>
        <option value="PBL" {{tipoCLI}}>Publico</option>
      </select>
      {{if error_fntyp}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_fntyp}}</div>
      {{endif error_fntyp}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="fnest">Estado</label>
      <select class="col-12 col-m-9" name="fnest" id="fnest" {{readonly}}>
        <option value="ACT" {{estadoACT}}>Activo</option>
        <option value="INA" {{estadoINA}}>Inactivo</option>
        <option value="BLOQ" {{estadoRTR}}>Bloqueado</option>
        <option value="SUS" {{estadoRTR}}>Suspendido</option>
      </select>
      {{if error_fnest}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_fnest}}</div>
      {{endif error_fnest}}
    </div>

    <div class="row my-4 align-center flex-end">
      {{if showAction}}
      <button class="primary col-12 col-m-2" type="submit" name="btnConfirmar">Confirmar</button>
      &nbsp;
      {{endif showAction}}
      <button class="col-12 col-m-2" type="button" id="btnCancelar">
        {{if showAction}}Cancelar{{endif showAction}}
        {{ifnot showAction}}Regresar{{endifnot showAction}}
      </button>
    </div>

  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=Funciones-Funciones");
    });
  });
</script>
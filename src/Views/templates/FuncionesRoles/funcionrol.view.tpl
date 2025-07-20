<section class="container-m row px-4 py-4">
  <h1>{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=FuncionesRoles-FuncionRol&mode={{mode}}&rolescod={{rolescod}}&fncod={{fncod}}" method="POST" class="col-12 col-m-8 offset-m-2">

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolescod">Código Rol</label>
      <select class="col-12 col-m-9" name="rolescod" id="rolescod" {{readonly}}>
        <option value="ADM" {{rolescod_ADM}}>Administrador</option>
        <option value="AUD" {{rolescod_AUD}}>Auditor</option>
        <option value="PBL" {{rolescod_PBL}}>Publico</option>
       
      </select>
      {{if error_rolescod}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_rolescod}}</div>
      {{endif error_rolescod}}
    </div>

    <div class="row my-2 align-center">
     <label class="col-12 col-m-3" for="fncod">Código Función</label>
  <input class="col-12 col-m-9" type="text" name="fncod" id="fncod" value="{{fncod}}" {{readonly}} />

      {{if error_fncod}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_fncod}}</div>
      {{endif error_fncod}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="fnrolest">Estado</label>
      <select class="col-12 col-m-9" name="fnrolest" id="fnrolest" {{readonly}}>
        <option value="ACT" {{fnrolest_ACT}}>Activo</option>
        <option value="INA" {{fnrolest_INA}}>Inactivo</option>
        <option value="BLQ" {{fnrolest_BLQ}}>Bloqueado</option>
        <option value="SUS" {{fnrolest_SUS}}>Suspendido</option>
      </select>
      {{if error_fnrolest}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_fnrolest}}</div>
      {{endif error_fnrolest}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="fnexp">Fecha Expiración</label>
      <input class="col-12 col-m-9" type="date" name="fnexp" id="fnexp" value="{{fnexp}}" {{readonly}} />
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

    <input type="hidden" name="mode" value="{{mode}}" />
    <input type="hidden" name="xsrToken" value="{{xsrToken}}" />
    <input type="hidden" name="original_rolescod" value="{{original_rolescod}}" />
<input type="hidden" name="original_fncod" value="{{original_fncod}}" />

  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=FuncionesRoles-FuncionesRoles");
    });
  });
</script>
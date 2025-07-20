<section class="container-m row px-4 py-4">
  <h1>{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=RolesUsuarios-RolUsuario&mode={{mode}}&usercod={{usercod}}&rolescod={{rolescod}}" method="POST" class="col-12 col-m-8 offset-m-2">

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usercod">Código Usuario</label>
      <input class="col-12 col-m-9" type="number" name="usercod" id="usercod" placeholder="Código Usuario" value="{{usercod}}" {{readonly}} />
      {{if error_usercod}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_usercod}}</div>
      {{endif error_usercod}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolescod">Código Rol</label>
      <select class="col-12 col-m-9" name="rolescod" id="rolescod" {{readonly}}>
        <option value="ADM" {{rolescodACT}}>Administrador</option>
        <option value="AUD" {{rolescodAUD}}>Auditor</option>
       <option value="PBL" {{rolescodPBL}}>Publico</option>
       
      </select>
      {{if error_rolescod}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_rolescod}}</div>
      {{endif error_rolescod}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="roleuserest">Estado</label>
      <select class="col-12 col-m-9" name="roleuserest" id="roleuserest" {{readonly}}>
        <option value="ACT" {{roleuserest_ACT}}>Activo</option>
        <option value="INA" {{roleuserest_INA}}>Inactivo</option>
        <option value="BLQ" {{roleuserest_BLQ}}>Bloqueado</option>
        <option value="SUS" {{roleuserest_SUS}}>Suspendido</option>
      </select>
      {{if error_roleuserest}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_roleuserest}}</div>
      {{endif error_roleuserest}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="roleuserfch">Fecha</label>
      <input class="col-12 col-m-9" type="date" name="roleuserfch" id="roleuserfch" value="{{roleuserfch}}" {{readonly}} />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="roleuserexp">Fecha Expiración</label>
      <input class="col-12 col-m-9" type="date" name="roleuserexp" id="roleuserexp" value="{{roleuserexp}}" {{readonly}} />
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
    <input type="hidden" name="oldUsercod" value="{{usercod}}" />
  <input type="hidden" name="oldRolescod" value="{{rolescod}}" />

  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=RolesUsuarios-RolesUsuarios");
    });
  });
</script>
<section class="container-m row px-4 py-4">
  <h1>{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=Roles-Rol&mode={{mode}}&id={{rolescod}}" method="POST" class="col-12 col-m-8 offset-m-2">
    
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolescod">Código</label>
     <input class="col-12 col-m-9"  type="text" name="rolescod" id="rolescod" placeholder="Código" value="{{rolescod}}" />
      <input type="hidden" name="mode" value="{{mode}}" />
      <input type="hidden" name="xsrToken" value="{{xsrToken}}" />
      {{if error_rolescod}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_rolescod}}</div>
      {{endif error_rolescod}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolesdsc">Descripción</label>
      <input class="col-12 col-m-9" {{readonly}} type="text" name="rolesdsc" id="rolesdsc" placeholder="Descripción del rol" value="{{rolesdsc}}" />
      {{if error_rolesdsc}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_rolesdsc}}</div>
      {{endif error_rolesdsc}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="rolesest">Estado</label>
      <select class="col-12 col-m-9" name="rolesest" id="rolesest" {{readonly}}>
        <option value="ACT" {{estadoACT}}>Activo</option>
        <option value="INA" {{estadoINA}}>Inactivo</option>
        <option value="BLOQ" {{estadoBLOQ}}>Bloqueado</option>
        <option value="SUS" {{estadoSUS}}>Suspendido</option>
      </select>
      {{if error_rolesest}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_rolesest}}</div>
      {{endif error_rolesest}}
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
      window.location.assign("index.php?page=Roles-Roles");
    });
  });
</script>
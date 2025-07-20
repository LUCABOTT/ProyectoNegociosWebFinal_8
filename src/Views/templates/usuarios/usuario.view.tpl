<section class="container-m row px-4 py-4">
  <h1>{{modeDsc}}</h1>
</section>

<section class="container-m row px-4 py-4">
  <form action="index.php?page=Usuarios-Usuario&mode={{mode}}&id={{usercod}}" method="POST" class="col-12 col-m-8 offset-m-2">
    
   
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usercod">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="usercod" id="usercod" value="{{usercod}}" {{readonly}} />
      <input type="hidden" name="mode" value="{{mode}}" />
      <input type="hidden" name="xsrToken" value="{{xsrToken}}" />
      {{if error_usercod}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_usercod}}</div>
      {{endif error_usercod}}
    </div>

   
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="useremail">Correo</label>
      <input class="col-12 col-m-9" {{readonly}} type="email" name="useremail" id="useremail" value="{{useremail}}" />
      {{if error_useremail}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_useremail}}</div>
      {{endif error_useremail}}
    </div>

    <!-- Nombre -->
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="username">Nombre</label>
      <input class="col-12 col-m-9" {{readonly}} type="text" name="username" id="username" value="{{username}}" />
      {{if error_username}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_username}}</div>
      {{endif error_username}}
    </div>

    <!-- Contraseña -->
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="userpswd">Contraseña</label>
      <input class="col-12 col-m-9" {{readonly}} type="password" name="userpswd" id="userpswd" value="{{userpswd}}" />
      {{if error_userpswd}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_userpswd}}</div>
      {{endif error_userpswd}}
    </div>

    
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="userpswdest">Estado Contraseña</label>
      <input class="col-12 col-m-9" {{readonly}} type="text" name="userpswdest" id="userpswdest" value="{{userpswdest}}" />
      {{if error_userpswdest}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_userpswdest}}</div>
      {{endif error_userpswdest}}
    </div>

 
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="userpswdexp">Expira Contraseña</label>
      <input class="col-12 col-m-9" {{readonly}} type="datetime-local" name="userpswdexp" id="userpswdexp" value="{{userpswdexp}}" />
      {{if error_userpswdexp}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_userpswdexp}}</div>
      {{endif error_userpswdexp}}
    </div>

   
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="userest">Estado</label>
      <select class="col-12 col-m-9" name="userest" id="userest" {{readonly}}>
        <option value="ACT" {{estadoACT}}>Activo</option>
        <option value="INA" {{estadoINA}}>Inactivo</option>
        <option value="BLQ" {{estadoBLQ}}>Bloqueado</option>
      </select>
      {{if error_userest}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_userest}}</div>
      {{endif error_userest}}
    </div>

    
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="useractcod">Código Activación</label>
      <input class="col-12 col-m-9" {{readonly}} type="text" name="useractcod" id="useractcod" value="{{useractcod}}" />
      {{if error_useractcod}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_useractcod}}</div>
      {{endif error_useractcod}}
    </div>

    
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="userpswdchg">Cambio Clave</label>
      <input class="col-12 col-m-9" {{readonly}} type="text" name="userpswdchg" id="userpswdchg" value="{{userpswdchg}}" />
      {{if error_userpswdchg}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_userpswdchg}}</div>
      {{endif error_userpswdchg}}
    </div>

  
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="usertipo">Tipo Usuario</label>
      <select class="col-12 col-m-9" name="usertipo" id="usertipo" {{readonly}}>
        <option value="PBL" {{tipoPBL}}>Publico</option>
        <option value="ADM" {{tipoADM}}>Administrador</option>
        <option value="AUD" {{tipoAUD}}>Auditor</option>
      </select>
      {{if error_usertipo}}
      <div class="col-12 col-m-9 offset-m-3 error">{{error_usertipo}}</div>
      {{endif error_usertipo}}
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
      window.location.assign("index.php?page=Usuarios-Usuarios");
    });
  });
</script>
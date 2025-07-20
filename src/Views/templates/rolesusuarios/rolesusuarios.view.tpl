<h1>Relaciones Rol-Usuario</h1>

<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <input type="hidden" name="page" value="RolesUsuarios-RolesUsuarios" />
        <!-- Puedes agregar filtros si quieres -->
        <div class="col-4 align-end">
          <a href="index.php?page=RolesUsuarios-RolUsuario&mode=INS">Nueva relación</a>
        </div>
      </div>
    </form>
  </div>
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código Usuario</th>
        <th>Código Rol</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Expiración</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach roles_usuarios}}
      <tr>
        <td>{{usercod}}</td>
        <td>{{rolescod}}</td>
        <td>{{roleuserest}}</td>
        <td>{{roleuserfch}}</td>
        <td>{{roleuserexp}}</td>
        <td>
          <a href="index.php?page=RolesUsuarios-RolUsuario&mode=UPD&usercod={{usercod}}&rolescod={{rolescod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=RolesUsuarios-RolUsuario&mode=DEL&usercod={{usercod}}&rolescod={{rolescod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor roles_usuarios}}
    </tbody>
  </table>
  {{pagination}}
</section>
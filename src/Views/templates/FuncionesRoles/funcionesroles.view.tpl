<h1>Relaciones Función-Rol</h1>

<section class="grid">
  <div class="row">
    <form class="col-12 col-m-8" action="index.php" method="get">
      <div class="flex align-center">
        <input type="hidden" name="page" value="FuncionesRoles-FuncionesRoles" />
        <!-- Puedes agregar filtros si quieres -->
        <div class="col-4 align-end">
          <a href="index.php?page=FuncionesRoles-FuncionRol&mode=INS">Nueva relación</a>
        </div>
      </div>
    </form>
  </div>
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código Rol</th>
        <th>Código Función</th>
        <th>Estado</th>
        <th>Expiración</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach funciones_roles}}
      <tr>
        <td>{{rolescod}}</td>
        <td>{{fncod}}</td>
        <td>{{fnrolest}}</td>
        <td>{{fnexp}}</td>
        <td>
          <a href="index.php?page=FuncionesRoles-FuncionRol&mode=UPD&rolescod={{rolescod}}&fncod={{fncod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=FuncionesRoles-FuncionRol&mode=DEL&rolescod={{rolescod}}&fncod={{fncod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor funciones_roles}}
    </tbody>
  </table>
  {{pagination}}
</section>
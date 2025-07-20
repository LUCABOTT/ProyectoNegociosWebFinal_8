<h1>Trabajar con Roles</h1>


<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>
          {{ifnot OrderByRolescod}}
          <a href="index.php?page=Roles-Roles&orderBy=rolescod&orderDescending=0">Código <i class="fas fa-sort"></i></a>
          {{endifnot OrderByRolescod}}
          {{if OrderRolescodDesc}}
          <a href="index.php?page=Roles-Roles&orderBy=clear&orderDescending=0">Código <i class="fas fa-sort-down"></i></a>
          {{endif OrderRolescodDesc}}
          {{if OrderRolescod}}
          <a href="index.php?page=Roles-Roles&orderBy=rolescod&orderDescending=1">Código <i class="fas fa-sort-up"></i></a>
          {{endif OrderRolescod}}
        </th>
        <th class="left">
          {{ifnot OrderByRolesdsc}}
          <a href="index.php?page=Roles-Roles&orderBy=rolesdsc&orderDescending=0">Descripción <i class="fas fa-sort"></i></a>
          {{endifnot OrderByRolesdsc}}
          {{if OrderRolesdscDesc}}
          <a href="index.php?page=Roles-Roles&orderBy=clear&orderDescending=0">Descripción <i class="fas fa-sort-down"></i></a>
          {{endif OrderRolesdscDesc}}
          {{if OrderRolesdsc}}
          <a href="index.php?page=Roles-Roles&orderBy=rolesdsc&orderDescending=1">Descripción <i class="fas fa-sort-up"></i></a>
          {{endif OrderRolesdsc}}
        </th>
        <th>Estado</th>
        <th><a href="index.php?page=Roles-Rol&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach roles}}
      <tr>
        <td>{{rolescod}}</td>
        <td>
          <a class="link" href="index.php?page=Roles-Rol&mode=DSP&id={{rolescod}}">{{rolesdsc}}</a>
        </td>
        <td class="center">{{rolesest}}</td>
        <td class="center">
          <a href="index.php?page=Roles-Rol&mode=UPD&id={{rolescod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Roles-Rol&mode=DEL&id={{rolescod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor roles}}
    </tbody>
  </table>
  {{pagination}}
</section>
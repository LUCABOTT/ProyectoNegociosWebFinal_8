<h1>Trabajar con Usuarios</h1>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>
          {{ifnot OrderByUsercod}}
          <a href="index.php?page=Usuarios-Usuarios&orderBy=usercod&orderDescending=0">Código <i class="fas fa-sort"></i></a>
          {{endifnot OrderByUsercod}}
          {{if OrderUsercodDesc}}
          <a href="index.php?page=Usuarios-Usuarios&orderBy=clear&orderDescending=0">Código <i class="fas fa-sort-down"></i></a>
          {{endif OrderUsercodDesc}}
          {{if OrderUsercod}}
          <a href="index.php?page=Usuarios-Usuarios&orderBy=usercod&orderDescending=1">Código <i class="fas fa-sort-up"></i></a>
          {{endif OrderUsercod}}
        </th>
        <th class="left">Correo</th>
        <th class="left">Nombre</th>
        <th>Estado</th>
        <th><a href="index.php?page=Usuarios-Usuario&mode=INS">Nuevo</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach usuarios}}
      <tr>
        <td>{{usercod}}</td>
        <td>
          <a class="link" href="index.php?page=Usuarios-Usuario&mode=DSP&id={{usercod}}">{{useremail}}</a>
        </td>
        <td>{{username}}</td>
        <td class="center">{{userest}}</td>
        <td class="center">
          <a href="index.php?page=Usuarios-Usuario&mode=UPD&id={{usercod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Usuarios-Usuario&mode=DEL&id={{usercod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor usuarios}}
    </tbody>
  </table>
  {{pagination}}
</section>
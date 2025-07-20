<h1>Trabajar con Funciones</h1>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>
          {{ifnot OrderByFncod}}
          <a href="index.php?page=Funciones-Funciones&orderBy=fncod&orderDescending=0">Código <i class="fas fa-sort"></i></a>
          {{endifnot OrderByFncod}}
          {{if OrderFncodDesc}}
          <a href="index.php?page=Funciones-Funciones&orderBy=clear&orderDescending=0">Código <i class="fas fa-sort-down"></i></a>
          {{endif OrderFncodDesc}}
          {{if OrderFncod}}
          <a href="index.php?page=Funciones-Funciones&orderBy=fncod&orderDescending=1">Código <i class="fas fa-sort-up"></i></a>
          {{endif OrderFncod}}
        </th>
        <th class="left">
          {{ifnot OrderByFndsc}}
          <a href="index.php?page=Funciones-Funciones&orderBy=fndsc&orderDescending=0">Descripción <i class="fas fa-sort"></i></a>
          {{endifnot OrderByFndsc}}
          {{if OrderFndscDesc}}
          <a href="index.php?page=Funciones-Funciones&orderBy=clear&orderDescending=0">Descripción <i class="fas fa-sort-down"></i></a>
          {{endif OrderFndscDesc}}
          {{if OrderFndsc}}
          <a href="index.php?page=Funciones-Funciones&orderBy=fndsc&orderDescending=1">Descripción <i class="fas fa-sort-up"></i></a>
          {{endif OrderFndsc}}
        </th>
        <th>Tipo</th>
        <th>Estado</th>
        <th><a href="index.php?page=Funciones-Funcion&mode=INS">Nueva</a></th>
      </tr>
    </thead>
    <tbody>
      {{foreach funciones}}
      <tr>
        <td>{{fncod}}</td>
        <td>
          <a class="link" href="index.php?page=Funciones-Funcion&mode=DSP&id={{fncod}}">{{fndsc}}</a>
        </td>
        <td class="center">{{fntyp}}</td>
        <td class="center">{{fnest}}</td>
        <td class="center">
          <a href="index.php?page=Funciones-Funcion&mode=UPD&id={{fncod}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Funciones-Funcion&mode=DEL&id={{fncod}}">Eliminar</a>
        </td>
      </tr>
      {{endfor funciones}}
    </tbody>
  </table>
  {{pagination}}
</section> 
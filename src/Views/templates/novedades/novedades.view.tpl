<h1>Listado de Novedades</h1>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>
          {{ifnot OrderByHighlightId}}
          <a href="index.php?page=Novedades-Novedades&orderBy=highlightId&orderDescending=0">
            ID Novedad <i class="fas fa-sort"></i>
          </a>
          {{endifnot OrderByHighlightId}}
          {{if OrderHighlightIdDesc}}
          <a href="index.php?page=Novedades-Novedades&orderBy=clear&orderDescending=0">
            ID Novedad <i class="fas fa-sort-down"></i>
          </a>
          {{endif OrderHighlightIdDesc}}
          {{if OrderHighlightId}}
          <a href="index.php?page=Novedades-Novedades&orderBy=highlightId&orderDescending=1">
            ID Novedad <i class="fas fa-sort-up"></i>
          </a>
          {{endif OrderHighlightId}}
        </th>
        <th class="left">Producto (ID)</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>
          <a href="index.php?page=Novedades-Novedad&mode=INS">Nueva Novedad</a>
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach novedades}}
      <tr>
        <td>{{highlightId}}</td>
        <td>
          <a class="link" href="index.php?page=Novedades-Novedad&mode=DSP&id={{highlightId}}">
            {{productId}}
          </a>
        </td>
        <td class="center">{{highlightStart}}</td>
        <td class="center">{{highlightEnd}}</td>
        <td class="center">
          <a href="index.php?page=Novedades-Novedad&mode=UPD&id={{highlightId}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Novedades-Novedad&mode=DEL&id={{highlightId}}">Eliminar</a>
        </td>
      </tr>
      {{endfor novedades}}
    </tbody>
  </table>
  {{pagination}}
</section>
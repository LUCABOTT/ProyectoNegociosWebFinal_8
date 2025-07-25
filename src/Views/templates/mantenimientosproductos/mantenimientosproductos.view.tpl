<h1>Trabajar con Productos</h1>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>
          {{ifnot OrderByProductId}}
          <a href="index.php?page=MantenimientosProductos-MantenimientosProductos&orderBy=productId&orderDescending=0">
            Código <i class="fas fa-sort"></i>
          </a>
          {{endifnot OrderByProductId}}
          {{if OrderProductIdDesc}}
          <a href="index.php?page=MantenimientosProductos-MantenimientosProductos&orderBy=clear&orderDescending=0">
            Código <i class="fas fa-sort-down"></i>
          </a>
          {{endif OrderProductIdDesc}}
          {{if OrderProductId}}
          <a href="index.php?page=MantenimientosProductos-MantenimientosProductos&orderBy=productId&orderDescending=1">
            Código <i class="fas fa-sort-up"></i>
          </a>
          {{endif OrderProductId}}
        </th>
        <th class="left">Nombre</th>
        <th class="left">Descripción</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Estado</th>
        <th>
          <a href="index.php?page=MantenimientosProductos-MantenimientoProducto&mode=INS">Nuevo</a>
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach productos}}
      <tr>
        <td>{{productId}}</td>
        <td>
          <a class="link" href="index.php?page=MantenimientosProductos-MantenimientoProducto&mode=DSP&id={{productId}}">
            {{productName}}
          </a>
        </td>
        <td>{{productDescription}}</td>
        <td class="right">{{productPrice}}</td>
        <td class="center">{{productStock}}</td>
        <td class="center">{{productStatus}}</td>
        <td class="center">
          <a href="index.php?page=MantenimientosProductos-MantenimientoProducto&mode=UPD&id={{productId}}">Editar</a>
          &nbsp;
          <a href="index.php?page=MantenimientosProductos-MantenimientoProducto&mode=DEL&id={{productId}}">Eliminar</a>
        </td>
      </tr>
      {{endfor productos}}
    </tbody>
  </table>
  {{pagination}}
</section>
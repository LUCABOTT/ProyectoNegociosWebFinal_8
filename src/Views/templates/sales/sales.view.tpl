<h1>Listado de Promociones</h1>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>
          {{ifnot OrderBySaleId}}
          <a href="index.php?page=Sales-Sales&orderBy=saleId&orderDescending=0">
            ID Venta <i class="fas fa-sort"></i>
          </a>
          {{endifnot OrderBySaleId}}
          {{if OrderSaleIdDesc}}
          <a href="index.php?page=Sales-Sales&orderBy=clear&orderDescending=0">
            ID Venta <i class="fas fa-sort-down"></i>
          </a>
          {{endif OrderSaleIdDesc}}
          {{if OrderSaleId}}
          <a href="index.php?page=Sales-Sales&orderBy=saleId&orderDescending=1">
            ID Venta <i class="fas fa-sort-up"></i>
          </a>
          {{endif OrderSaleId}}
        </th>
        <th class="left">Producto</th>
        <th>Precio de Venta</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>
          <a href="index.php?page=Sales-Sal&mode=INS">Nueva Venta</a>
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach ventas}}
      <tr>
        <td>{{saleId}}</td>
        <td>
          <a class="link" href="index.php?page=Sales-Sal&mode=DSP&id={{saleId}}">
            {{productId}}
          </a>
        </td>
        <td class="right">{{salePrice}}</td>
        <td class="center">{{saleStart}}</td>
        <td class="center">{{saleEnd}}</td>
        <td class="center">
          <a href="index.php?page=Sales-Sal&mode=UPD&id={{saleId}}">Editar</a>
          &nbsp;
          <a href="index.php?page=Sales-Sal&mode=DEL&id={{saleId}}">Eliminar</a>
        </td>
      </tr>
      {{endfor ventas}}
    </tbody>
  </table>
  {{pagination}}
</section>s
INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (1, 'Negocios Web Intro', 'Libro de Introducción a los Negocios Web 70 pg', 200, 'https://i.postimg.cc/VkPGQcpb/fcc1c604486e02a295ad1e18ad9367e3.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (2, 'Negocios Web 2', 'Libro de Negocios Web 2 POO 120 pg', 300, 'https://i.postimg.cc/j5GxR5zb/2.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (3, 'Negocios Web Advance', 'Libro de Negocios Web Ingreso Pasivo 170 pg', 700, 'https://i.postimg.cc/d0fv91Ny/3.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (4, 'Negocios Web Full', 'Libro de Negocios Web Full Stack 220 pg', 1000, 'https://i.postimg.cc/wBn8mr35/4.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (5, 'Negocios Web Master', 'Libro de Negocios Web Master 300 pg', 1500, 'https://i.postimg.cc/ry3gxtGk/5.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (6, 'Negocios Web Expert', 'Libro de Negocios Web Expert 400 pg', 2000, 'https://i.postimg.cc/FR1gJ97z/6.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (7, 'Negocios Web Guru', 'Libro de Negocios Web Guru 500 pg', 2500, 'https://i.postimg.cc/8zt6d286/7.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (8, 'Negocios Web Master Ninha', 'Libro de Negocios Web Master Ninja 300 pg', 1500, 'https://i.postimg.cc/3J9Rz2LM/8.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (9, 'Negocios Web Expert Ninja', 'Libro de Negocios Web Expert Ninja 400 pg', 2000, 'https://i.postimg.cc/9MjCDfxt/9.jpg','ACT');

  INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
  (10, 'Negocios Web Guru Ninja', 'Libro de Negocios Web Guru Ninja 500 pg', 2500, 'https://i.postimg.cc/bwDhLnW9/10.jpg','ACT');

  INSERT INTO `sales` (`saleId`, `productId`, `salePrice`, `saleStart`, `saleEnd`) VALUES
  (1, 3, 500, '2025-08-01 00:00:00', '2025-10-31 23:59:59');

  INSERT INTO `sales` (`saleId`, `productId`, `salePrice`, `saleStart`, `saleEnd`) VALUES
  (2, 5, 750, '2025-08-01 00:00:00', '2025-10-31 23:59:59');

  INSERT INTO `sales` (`saleId`, `productId`, `salePrice`, `saleStart`, `saleEnd`) VALUES
  (3, 7, 1500, '2025-08-01 00:00:00', '2025-10-31 23:59:59');

  INSERT INTO `highlights` ( `highlightId`, `productId`, `highlightStart`, `highlightEnd`) VALUES
  (1, 1, '2025-08-01 00:00:00', '2025-10-31 23:59:59');

  INSERT INTO `highlights` ( `highlightId`, `productId`, `highlightStart`, `highlightEnd`) VALUES
  (2, 4, '2025-08-01 00:00:00', '2025-10-31 23:59:59');
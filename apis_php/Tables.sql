CREATE TABLE `Users` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(30) NOT NULL,
  `shipping_address` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(4000) NOT NULL,
  `image` varchar(500) NOT NULL,
  `price` bigint(20) NOT NULL DEFAULT 0,
  `shipping_cost` bigint(20) NOT NULL,
  `name` varchar(500) NOT NULL,
  `brand` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `image` varchar(500) NOT NULL,
  `text` varchar(4000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_product` (`product`),
  KEY `comment_user` (`user`),
  CONSTRAINT `comment_product` FOREIGN KEY (`product`) REFERENCES `product` (`id`),
  CONSTRAINT `comment_user` FOREIGN KEY (`user`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Cart` (
  `product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`product`,`user`),
  KEY `cart_user` (`user`),
  CONSTRAINT `cart_product` FOREIGN KEY (`product`) REFERENCES `Product` (`id`),
  CONSTRAINT `cart_user` FOREIGN KEY (`user`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Sale` (
  `id` int(11) NOT NULL,
  `sale_product` int(11) NOT NULL,
  `sub_total` bigint(20) NOT NULL,
  `calc_tax` bigint(20) NOT NULL,
  `shipping_total` bigint(20) NOT NULL,
  `total` bigint(20) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_user` (`user`),
  CONSTRAINT `sale_user` FOREIGN KEY (`user`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Sale_Product` (
  `sale` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sub_total` bigint(20) NOT NULL,
  `shipping_cost` bigint(20) NOT NULL,
  `taxes` bigint(20) NOT NULL,
  `total` bigint(20) NOT NULL,
  PRIMARY KEY (`sale`,`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
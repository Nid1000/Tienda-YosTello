-- Importa este archivo dentro de la base de datos que selecciones en phpMyAdmin.
-- Incluye estructura y datos base para login, panel admin, categorias, catalogo, descuentos, ganancia, pedidos y detalle de pedidos.

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) NOT NULL,
  `sizes` json NOT NULL,
  `colors` json NOT NULL,
  `stock` int unsigned NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `customer_first_name` varchar(255) NOT NULL,
  `customer_last_name` varchar(255) NOT NULL,
  `document_type` varchar(10) NOT NULL,
  `document_number` varchar(20) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_reference` varchar(255) DEFAULT NULL,
  `delivery_method` varchar(255) NOT NULL DEFAULT 'domicilio',
  `department` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pendiente',
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int unsigned NOT NULL,
  `selected_size` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_04_16_000000_create_products_table', 1),
(2, '2026_04_16_000001_create_users_table', 1),
(3, '2026_04_16_000002_create_orders_table', 1),
(4, '2026_04_16_000003_create_order_items_table', 1),
(5, '2026_04_18_000004_create_categories_table', 1),
(6, '2026_04_18_000005_add_category_id_to_products_table', 1),
(7, '2026_04_18_000006_add_pricing_columns_to_products_table', 1);

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador YO-TELLO', 'admin@novawear.test', NULL, '$2y$12$pbSnQoIYTWJQUveuGy8tMONzSVN/wWXZRKCO.uMa1Aj.BVsrToWbq', 'admin', NULL, '2026-04-18 18:14:52', '2026-04-18 18:14:52'),
(2, 'Cliente Demo', 'cliente@novawear.test', NULL, '$2y$12$PNUOwCAPgvXww/7bjetHa.LGr4Cpuh5vYbP/62H8bN.eH52bsaSUy', 'customer', NULL, '2026-04-18 18:14:52', '2026-04-18 18:14:52');

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Ropa', 'ropa', 'Prendas urbanas, buzos, chaquetas y piezas para uso diario.', 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80', 1, 1, '2026-04-18 18:14:52', '2026-04-18 18:14:52'),
(2, 'Zapatillas', 'zapatillas', 'Modelos casuales, deportivos y retro para completar tu look.', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80', 2, 1, '2026-04-18 18:14:52', '2026-04-18 18:14:52'),
(3, 'Pantalones', 'pantalones', 'Jeans, joggers y pantalones con silueta relajada y moderna.', 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=900&q=80', 3, 1, '2026-04-18 18:14:52', '2026-04-18 18:14:52');

INSERT INTO `products` (`id`, `name`, `slug`, `category_id`, `category`, `description`, `price`, `cost_price`, `discount_percent`, `image`, `sizes`, `colors`, `stock`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Chaqueta Urbana Classic', 'chaqueta-urbana-classic', 1, 'Ropa', 'Chaqueta ligera para uso diario con corte moderno y tejido resistente.', 189900.00, 98000.00, 10.00, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80', '["S","M","L","XL"]', '["Negro","Beige"]', 12, 1, '2026-04-18 18:14:52', '2026-04-18 18:14:52'),
(2, 'Zapatillas Runner Flex', 'zapatillas-runner-flex', 2, 'Zapatillas', 'Amortiguacion suave, suela flexible y estilo deportivo para todo el dia.', 249900.00, 145000.00, 12.00, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80', '["38","39","40","41","42"]', '["Blanco","Rojo"]', 18, 1, '2026-04-18 18:14:52', '2026-04-18 18:14:52'),
(3, 'Pantalon Denim Straight', 'pantalon-denim-straight', 3, 'Pantalones', 'Jean recto de tiro medio con acabado limpio y ajuste comodo.', 159900.00, 82000.00, 0.00, 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=900&q=80', '["30","32","34","36"]', '["Azul","Gris"]', 22, 1, '2026-04-18 18:14:52', '2026-04-18 18:14:52'),
(4, 'Buzo Minimal Soft', 'buzo-minimal-soft', 1, 'Ropa', 'Buzo suave con interior afelpado ideal para climas frescos.', 129900.00, 64000.00, 8.00, 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=900&q=80', '["S","M","L"]', '["Crema","Verde oliva"]', 14, 0, '2026-04-18 18:14:52', '2026-04-18 18:14:52'),
(5, 'Jogger Street Move', 'jogger-street-move', 3, 'Pantalones', 'Jogger urbano con cintura elastica y caida relajada.', 119900.00, 58000.00, 5.00, 'https://images.unsplash.com/photo-1506629905607-bb5f7dd4f34f?auto=format&fit=crop&w=900&q=80', '["S","M","L","XL"]', '["Negro","Gris oscuro"]', 16, 0, '2026-04-18 18:14:52', '2026-04-18 18:14:52'),
(6, 'Zapatillas Retro Pulse', 'zapatillas-retro-pulse', 2, 'Zapatillas', 'Silueta retro con materiales mixtos para un look autentico.', 279900.00, 170000.00, 15.00, 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=900&q=80', '["39","40","41","42","43"]', '["Azul","Blanco"]', 10, 1, '2026-04-18 18:14:52', '2026-04-18 18:14:52');

INSERT INTO `orders` (`id`, `user_id`, `customer_first_name`, `customer_last_name`, `document_type`, `document_number`, `customer_name`, `customer_phone`, `shipping_address`, `shipping_reference`, `delivery_method`, `department`, `province`, `district`, `payment_method`, `status`, `total`, `created_at`, `updated_at`) VALUES
(1, 2, 'Cliente', 'Demo', 'DNI', '12345678', 'Cliente Demo', '3000000000', 'Av. Principal 123, Bogota', 'Frente al parque central', 'domicilio', 'Cundinamarca', 'Bogota', 'Chapinero', 'tarjeta', 'pendiente', 408918.00, '2026-04-18 18:20:00', '2026-04-18 18:20:00'),
(2, 2, 'Cliente', 'Demo', 'DNI', '12345678', 'Cliente Demo', '3000000000', 'Calle 45 # 12-34, Bogota', 'Apto 302', 'domicilio', 'Cundinamarca', 'Bogota', 'Teusaquillo', 'yape', 'entregado', 119508.00, '2026-04-18 18:35:00', '2026-04-18 18:35:00');

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `selected_size`, `subtotal`) VALUES
(1, 1, 1, 'Chaqueta Urbana Classic', 170910.00, 1, 'M', 170910.00),
(2, 1, 2, 'Zapatillas Runner Flex', 219912.00, 1, '40', 219912.00),
(3, 2, 4, 'Buzo Minimal Soft', 119508.00, 1, 'L', 119508.00);

SET FOREIGN_KEY_CHECKS = 1;

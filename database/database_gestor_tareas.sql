--
-- Base de datos: `gestor_tareas`
--
CREATE DATABASE IF NOT EXISTS `gestor_tareas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestor_tareas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitation`
--

CREATE TABLE `invitation` (
  `id` int(11) NOT NULL,
  `emisor_id` int(11) NOT NULL,
  `receptor_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `state` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `invitation`
--

INSERT INTO `invitation` (`id`, `emisor_id`, `receptor_id`, `project_id`, `state`) VALUES
(1, 1, 2, 7, 'aceptada'),
(2, 1, 3, 7, 'aceptada'),
(3, 1, 4, 7, 'aceptada'),
(4, 1, 5, 7, 'aceptada'),
(5, 1, 2, 8, NULL),
(6, 1, 3, 8, 'aceptada'),
(7, 1, 4, 8, 'aceptada'),
(8, 1, 5, 8, 'rechazada'),
(9, 1, 2, 9, 'aceptada'),
(10, 1, 5, 9, 'aceptada'),
(11, 1, 3, 10, NULL),
(12, 1, 4, 10, 'rechazada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `scope` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `project`
--

INSERT INTO `project` (`id`, `name`, `scope`) VALUES
(1, 'Proyecto personal de admin', 'personal'),
(2, 'Proyecto personal de jorge', 'personal'),
(3, 'Proyecto personal de laura', 'personal'),
(4, 'Proyecto personal de lola', 'personal'),
(5, 'Proyecto personal de juan', 'personal'),
(6, 'Proyecto personal de pepa', 'personal'),
(7, 'Sitio web del IES H. Lanz', 'colectivo'),
(8, 'Sección de calzado de Zara', 'colectivo'),
(9, 'Aplicación móvil Granada CF', 'colectivo'),
(10, 'Landing page de Lefties', 'colectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_user`
--

CREATE TABLE `project_user` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `relation_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `project_user`
--

INSERT INTO `project_user` (`id`, `project_id`, `user_id`, `relation_type`) VALUES
(1, 1, 1, 'creador'),
(2, 2, 2, 'creador'),
(3, 3, 3, 'creador'),
(4, 4, 4, 'creador'),
(5, 5, 5, 'creador'),
(6, 6, 6, 'creador'),
(7, 7, 1, 'creador'),
(8, 8, 1, 'creador'),
(9, 9, 1, 'creador'),
(10, 10, 1, 'creador'),
(11, 9, 5, 'invitado'),
(12, 7, 5, 'invitado'),
(13, 8, 4, 'invitado'),
(14, 7, 4, 'invitado'),
(15, 7, 3, 'invitado'),
(16, 8, 3, 'invitado'),
(17, 7, 2, 'invitado'),
(18, 9, 2, 'invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `assigned_id` int(11) DEFAULT NULL,
  `finisher_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `limit_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `task`
--

INSERT INTO `task` (`id`, `project_id`, `creator_id`, `assigned_id`, `finisher_id`, `description`, `limit_date`, `end_date`) VALUES
(1, 1, 1, 1, NULL, 'Campaña de publicidad', '2025-03-07 14:52:00', NULL),
(2, 2, 2, 2, 2, 'Imprimir documentos', '2025-03-03 14:55:00', '2025-03-01 14:56:10'),
(3, 2, 2, 2, 2, 'Comprar disco duro', '2025-03-05 14:57:00', '2025-03-01 14:57:39'),
(4, 3, 3, 3, 3, 'Arreglar la impresora', '2025-03-03 14:58:00', '2025-03-01 14:58:45'),
(5, 3, 3, 3, NULL, 'Hacer pedido de folios', '2025-03-12 14:59:00', NULL),
(6, 7, 1, 2, 2, 'Vistas con Tailwind css', '2025-03-07 20:16:00', '2025-03-01 20:27:40'),
(7, 8, 1, NULL, NULL, 'Funciones Wordpress', '2025-03-07 20:21:00', NULL),
(8, 9, 1, 5, 2, 'Diseño adaptativo', '2025-03-07 20:22:00', '2025-03-01 20:28:21'),
(9, 10, 1, NULL, NULL, 'Crear landing page', '2025-03-07 20:23:00', NULL),
(10, 7, 2, 4, NULL, 'React-router-dom', '2025-03-12 20:26:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'admin', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$wco7K2t2SFsWSMqZGEl4Yu99gkYdq4n763HHK1plUfEg6smw5/RAi'),
(2, 'jorge', '[]', '$2y$13$1oN9gej5Zf.Qc7d/V0sMyOj9btdVag4kr32ZQAquQ1CGVw7WPlS1.'),
(3, 'laura', '[]', '$2y$13$btJpZQWSOh5u0xcHe4xYtOv0lDfGDJmM4b5A4m6zOIsYOV7eCpafm'),
(4, 'lola', '[]', '$2y$13$wqdWktyo1gMd0pRjlA06.uKuLIZw7Z4LblyxoS6.Dub6NGYr/cJim'),
(5, 'juan', '[]', '$2y$13$BF2ychTN3YSfGeu3c6w.Q.cpNMvK2UpH3BRX6.CiHSHhwWdPO2SVm'),
(6, 'pepa', '[]', '$2y$13$T3/PaIFuawQ77HIYKkgVv.Dq8elcgKu7E6k/nrF6AhYMA82hhq8yu');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `invitation`
--
ALTER TABLE `invitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F11D61A26BDF87DF` (`emisor_id`),
  ADD KEY `IDX_F11D61A2386D8D01` (`receptor_id`),
  ADD KEY `IDX_F11D61A2166D1F9C` (`project_id`);

--
-- Indices de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indices de la tabla `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `project_user`
--
ALTER TABLE `project_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B4021E51166D1F9C` (`project_id`),
  ADD KEY `IDX_B4021E51A76ED395` (`user_id`);

--
-- Indices de la tabla `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_527EDB25166D1F9C` (`project_id`),
  ADD KEY `IDX_527EDB2561220EA6` (`creator_id`),
  ADD KEY `IDX_527EDB25E1501A05` (`assigned_id`),
  ADD KEY `IDX_527EDB2595D2E802` (`finisher_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `invitation`
--
ALTER TABLE `invitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `project_user`
--
ALTER TABLE `project_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `invitation`
--
ALTER TABLE `invitation`
  ADD CONSTRAINT `FK_F11D61A2166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `FK_F11D61A2386D8D01` FOREIGN KEY (`receptor_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F11D61A26BDF87DF` FOREIGN KEY (`emisor_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `project_user`
--
ALTER TABLE `project_user`
  ADD CONSTRAINT `FK_B4021E51166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `FK_B4021E51A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB25166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `FK_527EDB2561220EA6` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_527EDB2595D2E802` FOREIGN KEY (`finisher_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_527EDB25E1501A05` FOREIGN KEY (`assigned_id`) REFERENCES `user` (`id`);

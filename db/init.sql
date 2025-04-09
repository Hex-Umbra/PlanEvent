USE gestion_events;

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id_event` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `time` text NOT NULL,
  `date` text NOT NULL,
  `places_available` int NOT NULL,
  `price` int NOT NULL,
  `location` varchar(50) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `id_org` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id_event`, `name`, `description`, `time`, `date`, `places_available`, `price`, `location`, `image_url`, `id_org`) VALUES
(16, 'Circus', 'BLABLALABLABLAB', '08:30', '2025-04-24', 200, 25, 'Bordères', 'https://plus.unsplash.com/premium_photo-1714618937899-86c698f792a3?q=80&w=2009&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 1),
(17, 'SportAutoMobile', 'azhdoiadmoiandkjzandoimdnmkjzaaandkjandljakjdznalkndlkajndkj jkndkjanzkjdnzdlkjzandlkzandakjdbnzlkjdbakjdnlkjnza lkjandzkjandklazjndkjndaldjk nzaaibkjznd iazjdlknajdnkjzand likjndalkjd aiundjlkzand iuazn kjzandiazu ndlkzjndiuzad nzaldaiuz hdinzakjdn aizud nzadliuza ndlizaud nzalidu haziud nzaiud nzadkj naziud nzalidkh zalikj nazidu nzaliu hzaindali.', '16:30', '2025-04-24', 100, 75, 'Lacombe', 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=1966&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inscrire`
--

CREATE TABLE `inscrire` (
  `id_event` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `id_org` int NOT NULL,
  `nom_org` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tel` varchar(50) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`id_org`, `nom_org`, `tel`, `email`) VALUES
(1, 'Kunde, Grant and Durgan', '604-174-1844', 'abert0@ft.com'),
(2, 'Swift Inc', '118-258-8502', 'jhartburn1@ow.ly'),
(3, 'Ryan, Stiedemann and Stokes', '199-870-8423', 'lpoints2@admin.ch'),
(4, 'Russel and Sons', '239-101-6537', 'rbrattan3@unicef.org'),
(6, 'Bercouli&amp;Co', '00000000', 'BerCo@company.com'),
(7, 'SportAutoMobile', '+33 03 03 03 03', 'AutoMobile@sport.fr'),
(8, 'Malicia', '06 06 06 06', 'Malice@gogole.mechant');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `password`, `role`) VALUES
(1, 'Jobi', 'Jobi@joba.com', '$2y$10$IWUCVIYHXrG38rN49iic8e8Ca.BkVKw9PbKyP.Gq1wlJavBSYJADu', 'admin'),
(11, 'SkyrimEnjoyer', 'admin@admin.com', '$2y$10$V1VxCi1vprKMYfW4C9HGQuSY1R4OBHkquih90idTZM3yM6nI7WAka', 'user'),
(20, 'dodo', 'dodo@hotmail.com', '$2y$10$3dDlzdm/XTEOAgZlfu74I.Ezjhg4JefhVv08AQUdsfqSwHX2D2SXi', 'user'),
(25, 'Something', 'Some@thing.mail', '$2y$10$SiaNLs/AJNPv.Asvt7tQzeNH.5rFG7TquaYfxcB2jFSqIs2cuokVW', 'user'),
(26, 'Goulag', 'job@ggs.fr', '$2y$10$RjRZ7/84y4qUOSntdqrUE.8oNSz9OVkNL0T74d3VoDss9lRDbzDvG', 'user'),
(27, 'Monkey', 'monk@gmail.com', '$2y$10$LcGlZ7XC0/blWF6A.FvdxuCbiKZqz7lIhRIUV3Q.wcVcteqV3Zkei', 'user'),
(28, 'Something', 'Thing@thing.mail', '$2y$10$pTzsfN/VvFlqDcOs5OkiruePpPLwE4KY5SXjz1IN2zmBZSbTOqS5i', 'admin'),
(30, 'JonathanFoot', 'joeLovesAudreysFeet@eww.rat', '$2y$10$MZGb.kRrl2EH5yjPPEHK4ugJTHUcopbUTPC2ypjhURcGXTYAZTULC', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `events_organisation_FK` (`id_org`);

--
-- Indexes for table `inscrire`
--
ALTER TABLE `inscrire`
  ADD PRIMARY KEY (`id_event`,`id_user`),
  ADD KEY `inscrire_user0_FK` (`id_user`);

--
-- Indexes for table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`id_org`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `id_org` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_organisation_FK` FOREIGN KEY (`id_org`) REFERENCES `organisation` (`id_org`);

--
-- Constraints for table `inscrire`
--
ALTER TABLE `inscrire`
  ADD CONSTRAINT `inscrire_events_FK` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`),
  ADD CONSTRAINT `inscrire_user0_FK` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

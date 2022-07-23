DROP DATABASE IF EXISTS `sentiment_pf`;
CREATE DATABASE `sentiment_pf` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure table from `figure`
--

CREATE TABLE `figure` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data from table  `figure`
--

INSERT INTO `figure` (`id`, `name`) VALUES
(1, 'ariana grande'),
(2, 'avicii'),
(3, 'angelina jolie'),
(4, 'albert enstein'),
(5, 'anya taylor-joy'),
(6, 'amber heard'),
(7, 'aaron rodgers'),
(8, 'angela merkel'),
(9, 'anthony joshua'),
(10, 'abraham lincoln'),
(11, 'andy murray'),
(12, 'audrey hepburn'),
(13, 'alfred molina'),
(14, 'adam sandler'),
(15, 'asa butterfiled'),
(16, 'anne hathaway'),
(17, 'adam driver'),
(18, 'adam peaty'),
(19, 'antoine griezmann'),
(20, 'andrew garfield'),
(21, 'alexandria ocasio-cortez'),
(22, 'avril lavigne'),
(23, 'amitabh bachchan'),
(24, 'alan turing'),
(25, 'adele'),
(26, 'alex ferguson'),
(27, 'andy warhol'),
(28, 'agatha christie'),
(29, 'adam levine'),
(30, 'axl rose'),
(31, 'alvaro morata'),
(32, 'angel di maria'),
(33, 'asap rocky'),
(34, 'alex antetokounmpo'),
(35, 'anthony mackie'),
(36, 'andres iniesta'),
(37, 'allen iverson'),
(38, 'antonio conte'),
(39, 'anthony martial'),
(40, 'anthony davis'),
(41, 'andrea pirlo'),
(42, 'ben affleck'),
(43, 'billie ellish'),
(44, 'barack obama'),
(45, 'brendan fraser'),
(46, 'bob ross'),
(47, 'bruce lee'),
(48, 'bradd pitt'),
(49, 'boris johnson'),
(50, 'billie cosby'),
(51, 'beyonce'),
(52, 'bill gates'),
(53, 'bill clinton'),
(54, 'bnedict cumberbatch'),
(55, 'bruno mars'),
(56, 'brie larson'),
(57, 'bella hadid'),
(58, 'blake griffin'),
(59, 'ben stiller'),
(60, 'ben simmons'),
(61, 'brook lopez'),
(62, 'brian ortega'),
(63, 'big show'),
(64, 'bad bunny'),
(65, 'bebe rexha'),
(66, 'bae suzy'),
(67, 'cristiano ronaldo'),
(68, 'conor mcgregor'),
(69, 'chris pratt'),
(70, 'camila cabello'),
(71, 'chadwick boseman'),
(72, 'chris hemsworth'),
(73, 'chris paul'),
(74, 'cillian murphy'),
(75, 'chris evans'),
(76, 'cardi b'),
(77, 'cameron diaz'),
(78, 'courteney cox'),
(79, 'christopher nolan'),
(80, 'carrie fisher'),
(81, 'chris martin'),
(82, 'chloer grace moretz'),
(83, 'cara delevingne'),
(84, 'carmelo anthony'),
(85, 'celine dion'),
(86, 'chris brown'),
(87, 'coco gauff'),
(88, 'christian eriksen'),
(89, 'charles barkley'),
(90, 'charlie puth'),
(91, 'dwayne johnson'),
(92, 'donald trump'),
(93, 'dua lipa'),
(94, 'daniel craig'),
(95, 'doja cat'),
(96, 'drake'),
(97, 'devin booker'),
(98, 'david beckham'),
(99, 'david bowie'),
(100, 'daniel radcliffe'),
(101, 'dakota johnson'),
(102, 'demi lovato'),
(103, 'diego maradona'),
(104, 'dave grohl'),
(105, 'david schwimmer'),
(106, 'dennis rodman'),
(107, 'donald glover'),
(108, 'dwayne wade'),
(109, 'elon musk'),
(110, 'emily blunt'),
(111, 'eminem'),
(112, 'ed sheeran'),
(113, 'elliot page'),
(114, 'emma watson'),
(115, 'emma stone'),
(116, 'ernest hemingway'),
(117, 'elizabeth olson'),
(118, 'eric clapton'),
(119, 'emma mackey'),
(120, 'edward snowden'),
(121, 'edison cavani'),
(122, 'freddie mercury'),
(123, 'floyd mayweather jr.'),
(124, 'frank ocean'),
(125, 'giannis antetokounmpo'),
(126, 'george w. bush'),
(127, 'gigi hadid'),
(128, 'gordon ramsey'),
(129, 'gemma chan'),
(130, 'gal gadot'),
(131, 'george clooney'),
(132, 'gerard pique'),
(133, 'greta thunberg'),
(134, 'gong yoo'),
(135, 'guy fieri'),
(136, 'gerard way'),
(137, 'harry kane'),
(138, 'halsey'),
(139, 'harry styles'),
(140, 'harrsion ford'),
(141, 'henry cavill'),
(142, 'hugh jackman'),
(143, 'hillary clinton'),
(144, 'hanz zimmer'),
(145, 'jeff bezos'),
(146, 'joe biden'),
(147, 'jason momoa'),
(148, 'jennifer lopez'),
(149, 'john cena'),
(150, 'jennifer aniston'),
(151, 'johnny depp'),
(152, 'justin bieber'),
(153, 'jake paul'),
(154, 'jackie chan'),
(155, 'julia roberts'),
(156, 'joaquin phoenix'),
(157, 'jim carrey'),
(158, 'jay z'),
(159, 'james franco'),
(160, 'jack black'),
(161, 'j. k. rowling'),
(162, 'jared leto'),
(163, 'lanye west'),
(164, 'keanu reeves'),
(165, 'kim kardashian'),
(166, 'kylie jenner'),
(167, 'khabib nurmagomedov'),
(168, 'kobe bryant'),
(169, 'kristen stewart'),
(170, 'kylian mbappe'),
(171, 'kurt cobain'),
(172, 'kamala harris'),
(173, 'kevin durant'),
(174, 'kendall jenner'),
(175, 'kevin hart'),
(176, 'katy perry'),
(177, 'lionnel messi'),
(178, 'lebron james'),
(179, 'lewis hamilton'),
(180, 'lady gaga'),
(181, 'lorde'),
(182, 'lisa blackpink'),
(183, 'luke shaw'),
(184, 'lonzo ball'),
(185, 'lamelo ball'),
(186, 'lindsay lohan'),
(187, 'luis suarez'),
(188, 'lana del ray'),
(189, 'lisa kudrow'),
(190, 'lucy liu'),
(191, 'liam gallagher'),
(192, 'michael phelps'),
(193, 'muhammad ali'),
(194, 'mark zuckerberg'),
(195, 'michael jackson'),
(196, 'michael jordan'),
(197, 'megan fox'),
(198, 'margot robbie'),
(199, 'mike tayson'),
(200, 'mick jagger'),
(201, 'megan rapinoe'),
(202, 'naomi osaka'),
(203, 'nora lum'),
(204, 'neymar jr.'),
(205, 'nicki minaj'),
(206, 'neil patrick harris'),
(207, 'olivia rodrigo'),
(208, 'owen wilson'),
(209, 'oprah winfrey'),
(210, 'priyanka chopra'),
(211, 'paris hilton'),
(212, 'paul rudd'),
(213, 'prince william'),
(214, 'paul pogba'),
(215, 'post malone'),
(216, 'ryan renolds'),
(217, 'rihanna'),
(218, 'rafael nadal'),
(219, 'robert pattinson'),
(220, 'rami malek'),
(221, 'rowen atkinson'),
(222, 'simu liu'),
(223, 'steve jobs'),
(224, 'selena gomes'),
(225, 'shohei ohtani'),
(226, 'salma hayek'),
(227, 'sue bird'),
(228, 'zach lavine');

-- --------------------------------------------------------

--
-- Structure table from `sentiment`
--

CREATE TABLE `sentiment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `figure_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure table from `tweet`
--

CREATE TABLE `tweet` (
  `sentiment_id` int(11) NOT NULL,
  `sentiment` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `subjectivity` varchar(20) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure table from `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `picture` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks for table `figure`
--
ALTER TABLE `figure`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for table `sentiment`
--
ALTER TABLE `sentiment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sentiment_figure` (`figure_id`),
  ADD KEY `sentiment_user` (`user_id`);

--
-- Indeks for table `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tweet_sentiment` (`sentiment_id`);

--
-- Indeks for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table throw away
--

--
-- AUTO_INCREMENT for table `figure`
--
ALTER TABLE `figure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sentiment`
--
ALTER TABLE `sentiment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tweet`
--
ALTER TABLE `tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraint for table pelimpahan (Dumped Tables)
--

--
-- Constraint for table `sentiment`
--
ALTER TABLE `sentiment`
  ADD CONSTRAINT `sentiment_figure` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sentiment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraint for table `tweet`
--
ALTER TABLE `tweet`
  ADD CONSTRAINT `tweet_sentiment` FOREIGN KEY (`sentiment_id`) REFERENCES `sentiment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



--
-- Table structure for table `roo_operator_circle`
--

CREATE TABLE `roo_operator_circle` (
  `id` int(11) NOT NULL,
  `circle_code` int(11) NOT NULL,
  `circle_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roo_operator_circle`
--

INSERT INTO `roo_operator_circle` (`id`, `circle_code`, `circle_name`, `status`) VALUES
(1, 1, 'Delhi/NCR', 0),
(2, 2, 'Mumbai', 0),
(3, 3, 'Kolkatta', 0),
(4, 4, 'Maharashtra', 0),
(5, 5, 'Andhra Pradesh', 0),
(6, 6, 'Tamil Nadu', 0),
(7, 7, 'Karnataka', 0),
(8, 8, 'Gujarat', 0),
(9, 9, 'Uttar Pradesh East', 0),
(10, 10, 'Madhya Pradesh', 0),
(11, 11, 'Uttar Pradesh West', 0),
(12, 12, 'West Bengal', 0),
(13, 13, 'Rajasthan', 0),
(14, 14, 'Kerala', 0),
(15, 15, 'Punjab', 0),
(16, 16, 'Haryana', 0),
(17, 17, 'Bihar and Jharkhand', 0),
(18, 18, 'Orissa', 0),
(19, 19, 'Assam', 0),
(20, 20, 'North East', 0),
(21, 21, 'Himachal Pradesh', 0),
(22, 22, 'Jammu and kashmir', 0),
(23, 23, 'Chennai', 0),
(24, 0, 'None', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roo_operator_circle`
--
ALTER TABLE `roo_operator_circle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roo_operator_circle`
--
ALTER TABLE `roo_operator_circle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

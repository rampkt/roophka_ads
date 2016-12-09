
CREATE TABLE `roo_operator_circle` (
  `id` int(11) NOT NULL,
  `circle_code` int(11) NOT NULL,
  `circle_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE `roo_operator_circle` ADD PRIMARY KEY (`id`);
ALTER TABLE `roo_operator_circle` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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

CREATE TABLE IF NOT EXISTS `roo_contactus` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `reply_msg` longtext,
  `reply_date` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipaddr` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
ALTER TABLE `roo_contactus` ADD PRIMARY KEY (`id`);
ALTER TABLE `roo_contactus` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;

CREATE TABLE IF NOT EXISTS `roo_mobile_operator` (
`id` int(11) NOT NULL,
  `operator_code` int(11) NOT NULL,
  `operator_shortname` varchar(10) NOT NULL,
  `operator_name` varchar(255) NOT NULL,
  `operator_image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;
ALTER TABLE `roo_mobile_operator` ADD PRIMARY KEY (`id`);
ALTER TABLE `roo_mobile_operator` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;

INSERT INTO `roo_mobile_operator` (`id`, `operator_code`, `operator_shortname`, `operator_name`, `operator_image`, `status`) VALUES
(1, 28, 'AT', 'AIRTEL', 'NULL', 0),
(2, 1, 'AL', 'AIRCEL', 'NULL', 0),
(3, 3, 'BS', 'BSNL', 'NULL', 0),
(4, 22, 'VF', 'VODAFONE', 'NULL', 0),
(5, 17, 'TD', 'TATA DOCOMO GSM', 'NULL', 0),
(6, 18, 'TI', 'TATA DOCOMO CDMA', 'NULL', 0),
(7, 13, 'RG', 'RELIANCE GSM', 'NULL', 0),
(8, 12, 'RL', 'RELIANCE CDMA', 'NULL', 0),
(9, 10, 'MS', 'MTS', 'NULL', 0),
(10, 19, 'UN', 'UNINOR', 'NULL', 0),
(12, 5, 'VD', 'VIDEOCON', 'NULL', 0),
(13, 6, 'MTM', 'MTNL MUMBAI', 'NULL', 0),
(14, 20, 'MTD', 'MTNL DELHI', 'NULL', 0),
(15, 0, 'NONE', 'NONE', 'NULL', 0),
(16, 8, 'IDX', 'IDEA', 'NULL', 0),
(17, 17, 'T24', 'T24', 'NULL', 0),
(18, 17, 'VG', 'VIRGIN GSM', 'NULL', 0),
(19, 18, 'VC', 'VIRGIN CDMA', 'NULL', 0);

CREATE TABLE IF NOT EXISTS `roo_recharge` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `apiorder_id` varchar(255) DEFAULT NULL,
  `recharge_status` varchar(255) NOT NULL,
  `operator` varchar(255) NOT NULL,
  `myorder_id` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
ALTER TABLE `roo_recharge` ADD PRIMARY KEY (`id`);
ALTER TABLE `roo_recharge` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;

CREATE TABLE IF NOT EXISTS `roo_advertise_request` (
`id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `address1` longtext NOT NULL,
  `address2` longtext NOT NULL,
  `country` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `pincode` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ipaddr` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=approve,0=pending'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
ALTER TABLE `roo_advertise_request` ADD PRIMARY KEY (`id`);
ALTER TABLE `roo_advertise_request` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;


CREATE TABLE `roo_cms` (
  `id` int(11) NOT NULL,
  `aboutus` longtext NOT NULL,
  `privacy` longtext NOT NULL,
  `terms` longtext NOT NULL,
  `howitworks` longtext NOT NULL,
  `scrolling_content` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




CREATE TABLE `roo_recharge` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `apiorder_id` varchar(255) DEFAULT NULL,
  `recharge_status` varchar(255) NOT NULL,
  `operator` varchar(255) NOT NULL,
  `myorder_id` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE  `roo_ads` CHANGE  `type`  `type` ENUM(  'video',  'image',  'text',  'scroll' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
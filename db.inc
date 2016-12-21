
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


CREATE TABLE `roo_email_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `roo_email_template` (
  `id` int(11) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `template_content` longtext NOT NULL,
  `template_image` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `roo_sent_emails` (
  `id` int(11) NOT NULL,
  `subject` longtext NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT 'text=1,image=2,template=3',
  `message` longtext NOT NULL,
  `subscribe` int(11) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `roo_emails` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `date_added` timestamp NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `roo_settings` (
  `id` int(11) NOT NULL,
  `sitename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `email` varchar(255) NOT NULL,
  `weburl` varchar(255) NOT NULL,
  `upload_image` varchar(255) NOT NULL,
  `filehash` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


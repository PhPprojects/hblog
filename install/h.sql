-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 12 月 09 日 09:58
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `h`
--

-- --------------------------------------------------------

--
-- 表的结构 `h_admin`
--

CREATE TABLE IF NOT EXISTS `h_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `add_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  `last_login` int(11) DEFAULT NULL,
  `login_ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='admin table' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `h_admin`
--

INSERT INTO `h_admin` (`id`, `author`, `username`, `password`, `email`, `add_time`, `modify_time`, `last_login`, `login_ip`) VALUES
(1, '', 'allen', 'a859c6dde3857a1041837fa138924d1d8454346a', 'cs@hmvc.cn', 0, 0, 1418102440, '127.0.0.1');

-- --------------------------------------------------------

--
-- 表的结构 `h_blog_category`
--

CREATE TABLE IF NOT EXISTS `h_blog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `level` tinyint(4) DEFAULT '0',
  `path` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` varchar(256) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `path` (`path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Resources' AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `h_blog_category`
--

INSERT INTO `h_blog_category` (`id`, `parent`, `sort_order`, `level`, `path`, `name`, `description`) VALUES
(22, 0, 1, 0, '0', '默认分类', '');

-- --------------------------------------------------------

--
-- 表的结构 `h_blog_posts`
--

CREATE TABLE IF NOT EXISTS `h_blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` text COLLATE utf8_bin NOT NULL,
  `post_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `content` longtext COLLATE utf8_bin NOT NULL,
  `post_status` enum('publish','draft','private') COLLATE utf8_bin NOT NULL DEFAULT 'publish',
  `comment_status` enum('open','closed') COLLATE utf8_bin NOT NULL DEFAULT 'open',
  `post_date` int(11) NOT NULL,
  `post_modifyed` int(11) DEFAULT NULL,
  `comment_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `post_name` (`post_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `h_blog_posts`
--

INSERT INTO `h_blog_posts` (`id`, `author`, `title`, `post_name`, `content`, `post_status`, `comment_status`, `post_date`, `post_modifyed`, `comment_count`) VALUES
(10, 1, '欢迎使用HBlog', '欢迎使用HBlog', '<p>欢迎使用HBlog1.2</p><p>第一篇博客从此开始</p><p><br/></p>', 'publish', 'open', 1417792972, 1418052408, 0);

-- --------------------------------------------------------

--
-- 表的结构 `h_blog_tags`
--

CREATE TABLE IF NOT EXISTS `h_blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- 表的结构 `h_blog_tags_to_post`
--

CREATE TABLE IF NOT EXISTS `h_blog_tags_to_post` (
  `tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  UNIQUE KEY `tag_id` (`tag_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `h_blog_tags_to_post`
--

INSERT INTO `h_blog_tags_to_post` (`tag_id`, `post_id`) VALUES
(12, 5),
(18, 5),
(18, 9);

-- --------------------------------------------------------

--
-- 表的结构 `h_blog_to_category`
--

CREATE TABLE IF NOT EXISTS `h_blog_to_category` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `h_blog_to_category`
--

INSERT INTO `h_blog_to_category` (`post_id`, `category_id`) VALUES
(1, 22),
(3, 30),
(4, 22),
(4, 26),
(4, 30),
(4, 32),
(5, 26),
(5, 30),
(5, 32),
(8, 26),
(8, 30),
(9, 22),
(9, 32),
(9, 33),
(10, 22);

-- --------------------------------------------------------

--
-- 表的结构 `h_group`
--

CREATE TABLE IF NOT EXISTS `h_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `h_group`
--

INSERT INTO `h_group` (`id`, `name`, `description`) VALUES
(1, '管理员', '');

-- --------------------------------------------------------

--
-- 表的结构 `h_lang`
--

CREATE TABLE IF NOT EXISTS `h_lang` (
  `id_lang` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `default_lang` tinyint(4) NOT NULL DEFAULT '0',
  `iso_code` char(2) NOT NULL,
  `language_code` char(5) NOT NULL,
  `directory` varchar(128) DEFAULT NULL,
  `is_rtl` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_lang`),
  KEY `lang_iso_code` (`iso_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `h_lang`
--

INSERT INTO `h_lang` (`id_lang`, `name`, `active`, `default_lang`, `iso_code`, `language_code`, `directory`, `is_rtl`) VALUES
(1, '中文简体 (Simplified Chinese)', 1, 0, 'zh', 'zh-cn', 'chinese', 0),
(2, 'English', 1, 1, 'en', 'en-us', 'english', 0);

-- --------------------------------------------------------

--
-- 表的结构 `h_layouts`
--

CREATE TABLE IF NOT EXISTS `h_layouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '显示名称',
  `description` varchar(255) DEFAULT NULL,
  `filename` varchar(255) NOT NULL COMMENT '文件名',
  `theme` varchar(255) NOT NULL COMMENT '模版名称',
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='布局' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `h_layouts`
--

INSERT INTO `h_layouts` (`id`, `title`, `description`, `filename`, `theme`, `modify_time`) VALUES
(2, '首页', '首页测试', 'index', 'default', 1418037065);

-- --------------------------------------------------------

--
-- 表的结构 `h_menu`
--

CREATE TABLE IF NOT EXISTS `h_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `level` tinyint(4) DEFAULT '0',
  `path` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` varchar(256) COLLATE utf8_bin NOT NULL,
  `menu_type` enum('url','innerurl') COLLATE utf8_bin DEFAULT 'url',
  `menu_value` text COLLATE utf8_bin,
  `target` varchar(30) COLLATE utf8_bin DEFAULT '_blank',
  PRIMARY KEY (`id`),
  KEY `path` (`path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Menu' AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `h_menu`
--

INSERT INTO `h_menu` (`id`, `parent`, `sort_order`, `level`, `path`, `name`, `description`, `menu_type`, `menu_value`, `target`) VALUES
(22, 0, 1, 0, '0', '主菜单', 'test', 'url', 'http://baidu.com', '_blank'),
(38, 22, 1, 1, '0-22', 'test', '', 'url', 'http://www.baidu.com', '_blank');

-- --------------------------------------------------------

--
-- 表的结构 `h_pages`
--

CREATE TABLE IF NOT EXISTS `h_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` text,
  `content` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `modify_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='单页' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `h_pages`
--

INSERT INTO `h_pages` (`page_id`, `title`, `keywords`, `description`, `content`, `created_at`, `modify_at`) VALUES
(1, 'test', '', 'test', '', 1418039962, 1418039962),
(2, 'test', 'test', 'tset', '<p>20:08:45asdfaf</p>', 1418040511, 1418040527);

-- --------------------------------------------------------

--
-- 表的结构 `h_resources`
--

CREATE TABLE IF NOT EXISTS `h_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `level` tinyint(4) DEFAULT '0',
  `path` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `namespace` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` varchar(256) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `path` (`path`),
  KEY `namespace` (`namespace`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Resources' AUTO_INCREMENT=48 ;

--
-- 转存表中的数据 `h_resources`
--

INSERT INTO `h_resources` (`id`, `parent`, `sort_order`, `level`, `path`, `name`, `namespace`, `description`) VALUES
(26, 24, 1, 2, '0-18-24', '删除资源\r', 'Apps\\Backend\\Controller\\Auth::delrsAction', '\r'),
(25, 24, 1, 2, '0-18-24', '资源列表\r', 'Apps\\Backend\\Controller\\Auth::resourcesAction', '资源列表\r'),
(23, 22, 1, 2, '0-18-22', '', 'Apps\\Backend\\Controller\\AdminController::indexAction', ''),
(24, 18, 1, 1, '0-18', '授权管理\r', 'Apps\\Backend\\Controller\\Auth', '统一授权管理解决方案\r'),
(21, 19, 1, 2, '0-18-19', '', 'Apps\\Backend\\Controller\\Account::settingAction', ''),
(22, 18, 1, 1, '0-18', 'Apps\\Backend\\Controller\\AdminController', 'Apps\\Backend\\Controller\\AdminController', ''),
(20, 19, 1, 2, '0-18-19', '', 'Apps\\Backend\\Controller\\Account::indexAction', ''),
(19, 18, 1, 1, '0-18', 'Apps\\Backend\\Controller\\Account', 'Apps\\Backend\\Controller\\Account', ''),
(18, 0, 1, 0, '0', '模块', 'Apps\\Backend\\Controller', ''),
(27, 24, 1, 2, '0-18-24', '修改资源\r', 'Apps\\Backend\\Controller\\Auth::editrsAction', '\r'),
(28, 24, 1, 2, '0-18-24', '添加资源\r', 'Apps\\Backend\\Controller\\Auth::addrsAction', 'AJAX添加\r'),
(29, 24, 1, 2, '0-18-24', '', 'Apps\\Backend\\Controller\\Auth::groupAction', ''),
(30, 24, 1, 2, '0-18-24', '', 'Apps\\Backend\\Controller\\Auth::addGroupAction', ''),
(31, 24, 1, 2, '0-18-24', '', 'Apps\\Backend\\Controller\\Auth::modifyGroupAction', ''),
(32, 24, 1, 2, '0-18-24', '', 'Apps\\Backend\\Controller\\Auth::deleteGroupAction', ''),
(33, 24, 1, 2, '0-18-24', '', 'Apps\\Backend\\Controller\\Auth::indexAction', ''),
(34, 18, 1, 1, '0-18', 'Apps\\Backend\\Controller\\Blog', 'Apps\\Backend\\Controller\\Blog', ''),
(35, 34, 1, 2, '0-18-34', '', 'Apps\\Backend\\Controller\\Blog::indexAction', ''),
(36, 34, 1, 2, '0-18-34', '', 'Apps\\Backend\\Controller\\Blog::writeAction', ''),
(37, 34, 1, 2, '0-18-34', '', 'Apps\\Backend\\Controller\\Blog::editAction', ''),
(38, 34, 1, 2, '0-18-34', '', 'Apps\\Backend\\Controller\\Blog::categoryAction', ''),
(39, 34, 1, 2, '0-18-34', '', 'Apps\\Backend\\Controller\\Blog::addcategoryAction', ''),
(40, 34, 1, 2, '0-18-34', '', 'Apps\\Backend\\Controller\\Blog::editcategoryAction', ''),
(41, 34, 1, 2, '0-18-34', '', 'Apps\\Backend\\Controller\\Blog::rmcategoryAction', ''),
(42, 18, 1, 1, '0-18', '后台主页\r', 'Apps\\Backend\\Controller\\Index', '后台主页 登录 退出\r'),
(43, 42, 1, 2, '0-18-42', '', 'Apps\\Backend\\Controller\\Index::indexAction', ''),
(44, 18, 1, 1, '0-18', 'Apps\\Backend\\Controller\\Page', 'Apps\\Backend\\Controller\\Page', ''),
(45, 44, 1, 2, '0-18-44', '', 'Apps\\Backend\\Controller\\Page::indexAction', ''),
(46, 44, 1, 2, '0-18-44', '', 'Apps\\Backend\\Controller\\Page::addAction', ''),
(47, 44, 1, 2, '0-18-44', '', 'Apps\\Backend\\Controller\\Page::editAction', '');

-- --------------------------------------------------------

--
-- 表的结构 `h_setting`
--

CREATE TABLE IF NOT EXISTS `h_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(32) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`setting_id`),
  KEY `group` (`group`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `h_setting`
--

INSERT INTO `h_setting` (`setting_id`, `group`, `key`, `value`, `serialized`) VALUES
(1, 'system', 'usessl', '0', 0),
(2, 'system', 'store_name', 'You Store', 0),
(7, 'system', 'address', '上海市闵行区七宝', 0),
(6, 'system', 'store_owner', 'H1Cart Ltd.', 0),
(8, 'system', 'email', 'cs@hmvc.cn', 0),
(9, 'system', 'telephone', '15216688667', 0),
(10, 'system', 'fax', '', 0),
(11, 'system', 'meta_tag_keywords', 'HBlog', 0),
(12, 'system', 'meta_tag_description', 'HBlog ', 0),
(13, 'system', 'theme', 'default', 0),
(14, 'system', 'language', '2', 0),
(15, 'system', 'admin_language', '2', 0),
(16, 'system', 'item_pre_page', '20', 0),
(17, 'system', 'admin_item_pre_page', '20', 0),
(18, 'system', 'allow_reviews', '1', 0),
(19, 'system', 'store_logo', 'http://127.0.0.1/h1cart/upload/logo/logo.jpg', 0),
(20, 'system', 'store_icon', 'http://127.0.0.1/h1cart/upload/logo-icon.png', 0),
(21, 'mail', 'mail_protocol', 'MAIL', 0),
(22, 'mail', 'smtp_host', '127.0.0.1', 0),
(23, 'mail', 'smtp_username', '', 0),
(24, 'mail', 'smtp_password', '', 0),
(25, 'mail', 'smtp_port', '25', 0),
(26, 'mail', 'smtp_timeout', '10', 0),
(27, 'mail', 'new_order_alert', '0', 0),
(28, 'system', 'currency', '2', 0),
(29, 'Hello', 'name', 'Test1', 0),
(30, 'system', 'site_title', 'HBlog', 0),
(31, 'system', 'site_subtitle', 'HBlog v1.2', 0),
(32, 'system', 'icp', '沪ICP备1110000000号', 0),
(33, 'system', 'time_zone', '-8.0', 0),
(34, 'system', 'analytics', '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

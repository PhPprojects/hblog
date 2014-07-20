-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 07 月 20 日 09:20
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
  `add_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  `last_login` int(11) DEFAULT NULL,
  `login_ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='admin table' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `h_admin`
--

INSERT INTO `h_admin` (`id`, `author`, `username`, `password`, `add_time`, `modify_time`, `last_login`, `login_ip`) VALUES
(1, '', 'allen', 'a859c6dde3857a1041837fa138924d1d8454346a', 0, 0, 1405769562, '127.0.0.1');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Resources' AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `h_blog_category`
--

INSERT INTO `h_blog_category` (`id`, `parent`, `sort_order`, `level`, `path`, `name`, `description`) VALUES
(22, 0, 1, 0, '0', 'Programing', ''),
(32, 22, 1, 1, '0-22', 'Test', ''),
(30, 22, 1, 1, '0-22', 'PHP', ''),
(26, 22, 1, 1, '0-22', 'Java', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `h_blog_posts`
--

INSERT INTO `h_blog_posts` (`id`, `author`, `title`, `post_name`, `content`, `post_status`, `comment_status`, `post_date`, `post_modifyed`, `comment_count`) VALUES
(2, 1, '测试', '测试', '<p><img width="530" height="340" src="http://api.map.baidu.com/staticimage?center=121.361365,31.158883&zoom=16&width=530&height=340&markers=121.361365,31.158883"/></p>', 'publish', 'open', 1405329748, 1405413338, 0),
(3, 1, 'PHP函数测试', 'PHP函数测试', '<pre class="brush:php;toolbar:false">public&nbsp;function&nbsp;indexAction()&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;assign(&#39;menu_blog&#39;,&nbsp;1);\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;saveUrlRef();\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$tbname&nbsp;=&nbsp;$result&nbsp;=&nbsp;$this-&gt;db()-&gt;tb_name(&#39;blog_posts&#39;);\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$params&nbsp;=&nbsp;array();\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$params[&#39;page&#39;]&nbsp;=&nbsp;$this-&gt;get(&#39;page&#39;,&nbsp;0);\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;=&nbsp;$this-&gt;db()-&gt;query(&quot;select&nbsp;*&nbsp;from&nbsp;$tbname&nbsp;WHERE&nbsp;1&nbsp;&quot;);\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$page&nbsp;=&nbsp;new&nbsp;\\H1Soft\\H\\Web\\Page();\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$page-&gt;setCurPage($this-&gt;get(&#39;page&#39;,&nbsp;0))-&gt;setUrl(&#39;blog/index&#39;)-&gt;setParams($params);\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$page-&gt;count(&quot;select&nbsp;count(*)&nbsp;from&nbsp;`$tbname`&quot;);\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;assign(&#39;page&#39;,&nbsp;$page);\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;assign(&#39;list&#39;,&nbsp;$result);\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;render(&#39;admin/blog_index&#39;);\r\n&nbsp;&nbsp;&nbsp;&nbsp;}</pre><p><br/></p>', 'publish', 'open', 1405330175, 1405346193, 0),
(4, 1, 'test', 'test', '<p>test</p>', 'publish', 'open', 1405330199, 1405349062, 0),
(5, 1, '新文章', '新文章', '<p>新文章 欢迎大家阅读</p>', 'publish', 'open', 1405592314, 1405593451, 0);

-- --------------------------------------------------------

--
-- 表的结构 `h_blog_tags`
--

CREATE TABLE IF NOT EXISTS `h_blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `h_blog_tags`
--

INSERT INTO `h_blog_tags` (`id`, `name`) VALUES
(6, 'test');

-- --------------------------------------------------------

--
-- 表的结构 `h_blog_tags_to_post`
--

CREATE TABLE IF NOT EXISTS `h_blog_tags_to_post` (
  `tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
(4, 22),
(4, 26),
(4, 30),
(4, 32),
(5, 30);

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
(5, '管理员', '');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2024 at 09:27 AM
-- Server version: 10.6.18-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `man0warr_cms2`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text DEFAULT NULL,
  `image_filename` varchar(100) DEFAULT NULL,
  `image_alt` varchar(100) DEFAULT NULL,
  `posted_by` varchar(100) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_comments`
--

CREATE TABLE `blog_post_comments` (
  `id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `activation_code` char(32) NOT NULL,
  `activated` enum('NO','YES') NOT NULL DEFAULT 'NO',
  `approved` enum('NO','YES') NOT NULL DEFAULT 'NO',
  `blog_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_fields`
--

CREATE TABLE `content_fields` (
  `id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `content_field_type_id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `short_tag` varchar(50) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `options` text DEFAULT NULL,
  `settings` text DEFAULT NULL,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `content_fields`
--

INSERT INTO `content_fields` (`id`, `content_type_id`, `content_field_type_id`, `label`, `short_tag`, `required`, `options`, `settings`, `sort`) VALUES
(1, 1, 1, 'Left Column', 'left_column', 0, NULL, NULL, 1),
(2, 1, 1, 'Right Column', 'right_column', 0, NULL, NULL, 2),
(3, 2, 1, 'Box One', 'box_one', 1, NULL, NULL, 3),
(4, 2, 1, 'Box Two', 'box_two', 1, NULL, NULL, 4),
(5, 2, 1, 'Box Three', 'box_three', 1, NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `content_field_types`
--

CREATE TABLE `content_field_types` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `datatype` varchar(50) NOT NULL DEFAULT 'text',
  `array_post` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `content_field_types`
--

INSERT INTO `content_field_types` (`id`, `title`, `model_name`, `datatype`, `array_post`) VALUES
(1, 'CKEditor', 'ckeditor', 'text', 0),
(2, 'TinyMCE', 'tinymce', 'text', 0),
(3, 'Text', 'text', 'text', 0),
(4, 'Dropdown', 'dropdown', 'text', 0),
(5, 'Radio', 'radio', 'text', 0),
(6, 'Textarea', 'textarea', 'text', 0),
(7, 'HTML', 'html', 'text', 0),
(8, 'Image', 'image', 'text', 0),
(9, 'File', 'file', 'text', 0),
(10, 'Date', 'date', 'date', 0),
(11, 'Date Time', 'datetime', 'datetime', 0),
(12, 'Page URL', 'page_url', 'text', 0),
(13, 'Gallery', 'gallery_id', 'int', 0),
(14, 'Checkbox', 'checkbox', 'text', 1),
(15, 'Integer', 'text', 'int', 0),
(16, 'Media Box', 'mediabox_id', 'int', 0),
(17, 'Navigation', 'navigation', 'text', 0);

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

CREATE TABLE `content_types` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `layout` text DEFAULT NULL,
  `page_head` text DEFAULT NULL,
  `page_foot` text DEFAULT NULL,
  `theme_layout` varchar(50) DEFAULT NULL,
  `dynamic_route` varchar(255) DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `access` tinyint(1) NOT NULL,
  `restrict_to` text DEFAULT NULL,
  `restrict_admin_access` tinyint(1) NOT NULL DEFAULT 0,
  `enable_versioning` tinyint(1) NOT NULL,
  `max_revisions` int(11) NOT NULL,
  `entries_allowed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`id`, `title`, `short_name`, `layout`, `page_head`, `page_foot`, `theme_layout`, `dynamic_route`, `required`, `access`, `restrict_to`, `restrict_admin_access`, `enable_versioning`, `max_revisions`, `entries_allowed`) VALUES
(1, 'Page', 'page', '<div class=\"row\">\n	<div class=\"col-xs-12 col-sm-8\">\n		<h1>{{ title }}</h1>\n		{{ left_column }}		\n	</div>\n	<div class=\"col-xs-12 col-sm-4\">\n		{{ right_column }}\n	</div>\n</div>', NULL, NULL, 'default', NULL, 0, 0, NULL, 0, 0, 5, NULL),
(2, 'Home Page', 'home_page', '<div class=\"row\">\n	<div class=\"col-xs-12\">\n		\n		<img src=\"{{ theme_url }}/assets/images/header.jpg\" alt=\"Home Page Banner\" class=\"img-responsive\">\n		\n		<div class=\"row\">\n			<div class=\"col-lg-6\">\n				<h2>contact information</h2>\n				<p><a href=\"#\">e-mail</a></p>\n			</div>\n			<div class=\"col-lg-6\">\n				<h2>professional information</h2>\n				<p><a href=\"#\">Resume</a></p>\n				<p><a href=\"#\">LinkedIn</a></p>\n				<p><a href=\"#\">Portfolio</a></p>\n			</div>\n      	</div>		\n		\n	</div>\n</div>', NULL, NULL, 'default', NULL, 0, 0, NULL, 0, 0, 5, 1),
(3, 'Contact Page', 'contact_page', '<!--\n<div class=\"row\">	\n	<div class=\"col-xs-12\">\n		{{ map:googlemaps address={settings:address singleline=\"true\"} width=\"100%\" }}\n	</div>	\n</div>\n-->\n\n<div class=\"row\">\n	\n	<div class=\"col-xs-12 col-sm-8\">		\n		<h1>Get in touch</h1>\n		\n		{{ contact:form required=\"name|email|message\" captcha=\"true\" }}\n		<div class=\"form-group\">\n			<label for=\"name\">Full name</label>\n			<input type=\"text\" name=\"name\" placeholder=\"Name\" class=\"form-control\">\n		</div>\n		<div class=\"form-group\">\n			<label for=\"email\">E-mail address</label>\n			<input type=\"email\" name=\"email\" placeholder=\"Email\" class=\"form-control\">\n		</div>\n		<div class=\"form-group\">\n			<label for=\"phone\">Telephone</label>\n			<input type=\"tel\" name=\"phone\" placeholder=\"Telephone\" class=\"form-control\">\n		</div>\n		<div class=\"form-group\">\n			<label for=\"phone\">Message</label>\n			<textarea name=\"message\" rows=\"3\" placeholder=\"Message\" class=\"form-control\"></textarea>\n		</div>\n		<div class=\"captcha\" style=\"margin: 0 0 15px 0;\">\n			<p>Please enter the characters below:<p>\n			<div>{{ captcha }}</div>\n			<div>{{ captcha_input }}</div>\n		</div>\n		<button type=\"submit\" class=\"btn btn-default\">Submit</button>		\n		{{ /contact:form }}\n	</div>\n	\n	<div class=\"col-xs-12 col-sm-4\">\n		<h1>{{ title }}</h1>\n		<address>\n		  {{ settings:address }}<br>\n		  <abbr title=\"Phone\">P:</abbr> {{ settings:phone }}\n		</address>		\n		<address>\n		  <a href=\"mailto:{{ helper:mung_email email=settings:notification_email }}\">{{ helper:mung_email email=settings:notification_email }}</a>\n		</address>\n	</div>\n	\n</div>', NULL, NULL, 'default', NULL, 0, 0, NULL, 0, 0, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `content_types_admin_groups`
--

CREATE TABLE `content_types_admin_groups` (
  `id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `url_title` varchar(100) DEFAULT NULL,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `content_type_id` int(11) NOT NULL,
  `status` enum('published','draft','disabled') NOT NULL DEFAULT 'published',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `author_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `slug`, `title`, `url_title`, `required`, `content_type_id`, `status`, `meta_title`, `meta_description`, `meta_keywords`, `created_date`, `modified_date`, `author_id`) VALUES
(1, NULL, 'Page Not Found', NULL, 0, 1, 'published', NULL, NULL, NULL, '2012-03-06 22:55:06', '2014-04-02 22:12:41', 1),
(2, NULL, 'Home', NULL, 0, 2, 'published', NULL, NULL, NULL, '2015-11-11 20:50:33', '2015-12-10 22:52:09', 1),
(3, 'about', 'About', NULL, 0, 1, 'published', NULL, NULL, NULL, '2015-11-11 20:51:26', '2015-11-11 20:51:54', 1),
(4, 'contact', 'Contact', NULL, 0, 3, 'disabled', NULL, NULL, NULL, '2015-11-11 20:51:59', '2024-07-02 11:17:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entries_data`
--

CREATE TABLE `entries_data` (
  `id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `field_id_1` text DEFAULT NULL,
  `field_id_2` text DEFAULT NULL,
  `field_id_3` text DEFAULT NULL,
  `field_id_4` text DEFAULT NULL,
  `field_id_5` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `entries_data`
--

INSERT INTO `entries_data` (`id`, `entry_id`, `field_id_1`, `field_id_2`, `field_id_3`, `field_id_4`, `field_id_5`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL),
(2, 2, NULL, NULL, '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>', '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>', '<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>'),
(3, 3, '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\n\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\n\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\n\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>', '<h2>Lorem Ipsum</h2>\n\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>', NULL, NULL, NULL),
(4, 4, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entry_revisions`
--

CREATE TABLE `entry_revisions` (
  `id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `author_name` varchar(150) NOT NULL,
  `revision_date` datetime NOT NULL,
  `revision_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `resize` tinyint(4) NOT NULL,
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL,
  `image_crop` tinyint(4) DEFAULT NULL,
  `thumbs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `text_1` varchar(255) NOT NULL,
  `text_2` varchar(255) NOT NULL,
  `text_3` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `alt` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `target` enum('_blank','_self','_parent','_top') NOT NULL DEFAULT '_self',
  `hide` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `permissions` text DEFAULT NULL,
  `required` tinyint(4) NOT NULL DEFAULT 0,
  `modifiable_permissions` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `type`, `permissions`, `required`, `modifiable_permissions`) VALUES
(1, 'Super Admin', 'super_admin', NULL, 1, 0),
(2, 'Administrator', 'administrator', 'a:1:{s:6:\"access\";a:15:{i:0;s:23:\"sitemin/content/entries\";i:1;s:19:\"sitemin/navigations\";i:2;s:17:\"sitemin/galleries\";i:3;s:18:\"sitemin/mediaboxes\";i:4;s:18:\"sitemin/blog/posts\";i:5;s:20:\"sitemin/testimonials\";i:6;s:13:\"sitemin/users\";i:7;s:28:\"sitemin/users/user-documents\";i:8;s:21:\"sitemin/content/types\";i:9;s:24:\"sitemin/content/snippets\";i:10;s:38:\"sitemin/settings/manage-uploaded-files\";i:11;s:29:\"sitemin/settings/theme-editor\";i:12;s:33:\"sitemin/settings/general-settings\";i:13;s:28:\"sitemin/settings/clear-cache\";i:14;s:28:\"sitemin/settings/server-info\";}}', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mediaboxes`
--

CREATE TABLE `mediaboxes` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mediaboxes`
--

INSERT INTO `mediaboxes` (`id`, `title`) VALUES
(1, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `mediabox_items`
--

CREATE TABLE `mediabox_items` (
  `id` int(11) NOT NULL,
  `mediabox_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `text_1` varchar(255) NOT NULL,
  `text_2` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_alt` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `link_type` enum('NONE','INTERNAL','EXTERNAL','IMAGE','FILE') NOT NULL DEFAULT 'INTERNAL',
  `link_internal` varchar(255) NOT NULL,
  `link_external` varchar(255) NOT NULL,
  `link_file` varchar(255) NOT NULL,
  `link_target` enum('_blank','_self','_parent','_top') NOT NULL DEFAULT '_self',
  `hide` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mediabox_items`
--

INSERT INTO `mediabox_items` (`id`, `mediabox_id`, `title`, `subtitle`, `text_1`, `text_2`, `image_path`, `image_alt`, `description`, `link_type`, `link_internal`, `link_external`, `link_file`, `link_target`, `hide`, `sort`) VALUES
(1, 1, 'Item 1', '', '', '', '', '', NULL, 'NONE', '', '', '', '_self', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_addons`
--

CREATE TABLE `module_addons` (
  `id` int(11) NOT NULL,
  `parent` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL,
  `url` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `module_addons`
--

INSERT INTO `module_addons` (`id`, `parent`, `title`, `url`, `description`) VALUES
(1, 'Content', 'Blog', 'blog/posts', 'A Blog/News module with archives and comments.'),
(2, 'Content', 'Testimonials', 'testimonials', 'A basic Testimonials module.');

-- --------------------------------------------------------

--
-- Table structure for table `module_addons_users`
--

CREATE TABLE `module_addons_users` (
  `module_addon_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE `navigations` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `navigations`
--

INSERT INTO `navigations` (`id`, `title`, `required`) VALUES
(1, 'Main Navigation', 0);

-- --------------------------------------------------------

--
-- Table structure for table `navigation_items`
--

CREATE TABLE `navigation_items` (
  `id` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `entry_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tag_id` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `target` varchar(50) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `navigation_id` int(11) NOT NULL,
  `subnav_visibility` enum('show','current_trail','hide') NOT NULL,
  `hide` tinyint(4) NOT NULL DEFAULT 0,
  `disable_current` tinyint(1) NOT NULL DEFAULT 0,
  `disable_current_trail` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `navigation_items`
--

INSERT INTO `navigation_items` (`id`, `type`, `entry_id`, `title`, `url`, `tag_id`, `class`, `target`, `parent_id`, `navigation_id`, `subnav_visibility`, `hide`, `disable_current`, `disable_current_trail`, `sort`) VALUES
(4, 'page', 2, NULL, NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 4),
(5, 'page', 3, NULL, NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `value` text NOT NULL,
  `module` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `slug`, `value`, `module`) VALUES
(1, 'site_name', 'Canvas Demo', NULL),
(2, 'notification_email', 'jettpinckard@gmail.com', NULL),
(3, 'additional_notification_emails', '', NULL),
(4, 'developers_email', 'admin@einsteinseyes.com', NULL),
(5, 'use_developers_email', '1', NULL),
(6, 'phone', '972-322-7065', NULL),
(7, 'fax', '', NULL),
(8, 'address', '', NULL),
(9, 'site_homepage', '2', 'content'),
(10, 'custom_404', '1', 'content'),
(11, 'theme', 'default', NULL),
(12, 'layout', 'default', NULL),
(13, 'editor_stylesheet', 'assets/css/ckeditor.css', NULL),
(14, 'enable_admin_toolbar', '0', NULL),
(15, 'enable_profiler', '0', NULL),
(16, 'suspend', '0', NULL),
(17, 'cms_version', '2.80', NULL),
(18, 'version_modified', '0', NULL),
(19, 'default_group', '2', 'users'),
(20, 'enable_registration', '1', 'users'),
(21, 'email_activation', '1', 'users'),
(22, 'search_term_padding', '150', NULL),
(23, 'disable_comments', '0', NULL),
(24, 'ga_account_id', '', NULL),
(25, 'ga_email', '', NULL),
(26, 'ga_password', '', NULL),
(27, 'ga_profile_id', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `snippets`
--

CREATE TABLE `snippets` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `snippet` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `quotation` text DEFAULT NULL,
  `by` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(15) NOT NULL,
  `group_id` int(11) NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT 1,
  `activated` tinyint(4) NOT NULL DEFAULT 1,
  `activation_code` varchar(32) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `first_name`, `last_name`, `email`, `phone`, `address`, `address2`, `city`, `state`, `zip`, `group_id`, `enabled`, `activated`, `activation_code`, `last_login`, `created_date`) VALUES
(3, '9fe2c514b5e6239d148bb797f8dc33e6', 'CMS', 'Demo', 'demo@demo.com', '', '', '', '', '', '', 2, 1, 1, NULL, '2024-07-10 09:23:12', '2024-07-10 09:22:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_post_comments`
--
ALTER TABLE `blog_post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_fields`
--
ALTER TABLE `content_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_field_type_id` (`content_field_type_id`),
  ADD KEY `content_type_id` (`content_type_id`);

--
-- Indexes for table `content_field_types`
--
ALTER TABLE `content_field_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_types`
--
ALTER TABLE `content_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `short_name` (`short_name`),
  ADD KEY `dynamic_route` (`dynamic_route`);

--
-- Indexes for table `content_types_admin_groups`
--
ALTER TABLE `content_types_admin_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_type_id` (`content_type_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_type_id` (`content_type_id`),
  ADD KEY `slug` (`slug`),
  ADD KEY `url_title` (`url_title`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `entries_data`
--
ALTER TABLE `entries_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entry_id` (`entry_id`);

--
-- Indexes for table `entry_revisions`
--
ALTER TABLE `entry_revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entry_id` (`entry_id`),
  ADD KEY `content_type_id` (`content_type_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_id` (`gallery_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `mediaboxes`
--
ALTER TABLE `mediaboxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mediabox_items`
--
ALTER TABLE `mediabox_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_id` (`mediabox_id`);

--
-- Indexes for table `module_addons`
--
ALTER TABLE `module_addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_addons_users`
--
ALTER TABLE `module_addons_users`
  ADD PRIMARY KEY (`module_addon_id`,`user_id`);

--
-- Indexes for table `navigations`
--
ALTER TABLE `navigations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation_items`
--
ALTER TABLE `navigation_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snippets`
--
ALTER TABLE `snippets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `short_name` (`short_name`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_post_comments`
--
ALTER TABLE `blog_post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_fields`
--
ALTER TABLE `content_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `content_field_types`
--
ALTER TABLE `content_field_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `content_types`
--
ALTER TABLE `content_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `content_types_admin_groups`
--
ALTER TABLE `content_types_admin_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `entries_data`
--
ALTER TABLE `entries_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `entry_revisions`
--
ALTER TABLE `entry_revisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mediaboxes`
--
ALTER TABLE `mediaboxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mediabox_items`
--
ALTER TABLE `mediabox_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_addons`
--
ALTER TABLE `module_addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `navigations`
--
ALTER TABLE `navigations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `navigation_items`
--
ALTER TABLE `navigation_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `snippets`
--
ALTER TABLE `snippets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

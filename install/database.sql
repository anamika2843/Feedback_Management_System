SET NAMES utf8;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `auth_activation_attempts`;
CREATE TABLE IF NOT EXISTS `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_groups`;
CREATE TABLE IF NOT EXISTS `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(NULL, 'admin', 'admin'),
(NULL, 'employee', 'employee');

DROP TABLE IF EXISTS `auth_groups_permissions`;
CREATE TABLE IF NOT EXISTS `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  KEY `group_id_permission_id` (`group_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 1);

DROP TABLE IF EXISTS `auth_groups_users`;
CREATE TABLE IF NOT EXISTS `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  KEY `group_id_user_id` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 1);

DROP TABLE IF EXISTS `auth_logins`;
CREATE TABLE IF NOT EXISTS `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_permissions`;
CREATE TABLE IF NOT EXISTS `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'admin', 'admin');

DROP TABLE IF EXISTS `auth_reset_attempts`;
CREATE TABLE IF NOT EXISTS `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_tokens_user_id_foreign` (`user_id`),
  KEY `selector` (`selector`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_users_permissions`;
CREATE TABLE IF NOT EXISTS `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  KEY `user_id_permission_id` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `board`;
CREATE TABLE IF NOT EXISTS `board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `board_slug` text NOT NULL,
  `intro_text` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
INSERT INTO `category` (`id`, `title`, `description`) VALUES
(NULL, 'New Features', 'New Features'),
(NULL, 'Enhancements', 'Enhancements'),
(NULL, 'Implementation  Ideas', 'Implementation  Ideas');

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `emailtemplates`;
CREATE TABLE IF NOT EXISTS `emailtemplates` (
  `emailtemplateid` int(5) NOT NULL AUTO_INCREMENT,
  `type` mediumtext NOT NULL,
  `slug` varchar(100) NOT NULL,
  `language` varchar(40) DEFAULT NULL,
  `name` mediumtext NOT NULL,
  `subject` mediumtext NOT NULL,
  `message` text NOT NULL,
  `fromname` mediumtext NOT NULL,
  `fromemail` varchar(100) NOT NULL,
  `plaintext` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `order` int(4) NOT NULL,
  PRIMARY KEY (`emailtemplateid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
INSERT INTO `emailtemplates` (`emailtemplateid`, `type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
(NULL, 'feedbacks', 'new-feature-request', NULL, 'New Feature Request', '[Moderation required] New feature request submitted', '<p>Hey awesome staff member!</p>\r\n<p>User with email <strong>{FEEDBACK_USER_EMAIL}</strong> just submitted a new Feature Request (Feedback Suggestion Idea).<br /><br />Please log into admin area ( {ADMIN_URL} - head to Feedback Ideas Menu ) and <strong>Approve/Decline</strong> it (in case moderation is enabled) or take a look at its details and ask end-user for more details.</p>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\"><span style=\"color: #495057; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 14.08px;\">{LOGO}</span></p>', 'fromname', 'fromemail', 0, 1, 1),
(NULL, 'feedbacks', 'feature-request-approved', NULL, 'Feature Request Approved', 'Yei, your suggestion is now live!', '<p>Hey,&nbsp;<strong>{FEEDBACK_USER_NAME} </strong>!</p>\r\n<p>You are receiving this email notification, because the following Feature Request (Feedback Suggestion Idea):<br /><br /><strong>{FEEDBACK_URL}&nbsp;</strong><br /><br />was <strong>approved</strong> by an administrator and is now live!</p>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\"><span style=\"color: #495057; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 14.08px;\">{LOGO}</span></p>', 'fromname', 'fromemail', 0, 1, 1),
(NULL, 'members', 'user-activation', NULL, 'Activate your account', '[Action Needed] Please activate your account!', '<p>Hey,&nbsp;<strong>{USER_NAME}&nbsp;</strong>!</p>\r\n<p>You received this email because you signed up for an account with us.</p>\r\n<p>Kindly confirm your account\'s registration, by visiting the following URL: <strong>{USER_ACTIVATION_URL}</strong></p>\r\n<p>&nbsp;</p>\r\n<p>If you did not registered for an account with us, you can safely ignore this email.</p>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\">{LOGO}</p>', 'fromname', 'fromemail', 0, 1, 1),
(NULL, 'members', 'user-reset-password', NULL, 'Password Reset Instructions', '[Attention] Password Reset Instructions', '<p>Hello <strong>{USER_NAME}</strong>,<br /><br />You probably requested a password reset for your account with us.</p>\r\n<p>To reset your password, please use the following code: <strong>{USER_RESET_PASSWORD_CODE}<br /></strong> <br />Alternatively, you can click on the link below and follow the instructions: <br /><strong>{USER_RESET_PASSWORD_URL}<br /><br /></strong></p>\r\n<p>If you did not request a password reset, please ignore this email.</p>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\">{LOGO}</p>', 'fromname', 'fromemail', 0, 1, 1),
(NULL, 'feedback', 'request-more-info', NULL, 'Request More Information', '[Attention] More Information Needed!', '<p>{HEADER}</p>\r\n<p>Hello&nbsp;<strong>{FEEDBACK_USER_NAME} </strong>and thank you for submitting your Feedback Suggestion with us.&nbsp;</p>\r\n<p>Your idea was moderated and an administrator aksed for more information regarding it. <br />Providing it more info by replying at this email, will help the approval process.<br /><br /></p>\r\n<p>Here is your initial Feedback Suggestion description:</p>\r\n<p><strong>{FEEDBACK_DESCRIPTION}</strong></p>\r\n<p>Thank you in advance for your cooperation.</p>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\">{LOGO}</p>', 'fromname', 'fromemail', 0, 1, 1),
(NULL, 'comments', 'new-feedback-comment-added', NULL, 'New Comment added', 'New Comment Added', '<p>Hey, <strong>{FEEDBACK_USER_NAME}</strong> !</p>\r\n<p><strong>{COMMENTED_USER_NAME} </strong>(<strong>{COMMENTED_USER_EMAIL}</strong>), just submitted the following comment under the Feature Request \"<strong>{FEEDBACK_DESCRIPTION}</strong>\":</p>\r\n<p><strong>{COMMENT_DESCRIPTION}</strong></p>\r\n<p>Please log into admin area and Approve/Decline it:&nbsp;<strong>{COMMENT_LINK}</strong></p>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\">{LOGO}</p>', 'fromname', 'fromemail', 0, 1, 1);


DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `feedback_description` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `approval_status` tinyint(4) NOT NULL DEFAULT '0',
  `upvotes` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`category`,`board_id`),
  KEY `fk_board_id` (`board_id`),
  KEY `fk_category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `feedbacks_ideas`;
CREATE TABLE IF NOT EXISTS `feedbacks_ideas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` longtext NOT NULL,
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `board_id` int(11) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:Pending moderation\r\n1:Approved\r\n2:Dis-Approved',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_id` (`feedback_id`),
  KEY `board_id` (`board_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `value` longtext,
  `autoload` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
INSERT INTO `options` (`id`, `name`, `value`, `autoload`) VALUES
(NULL, 'company_name', 'company_name_value', 1),
(NULL, 'new_status_expiry_date', '7', 1),
(NULL, 'smtp_email_charset', 'UTF-8', 1),
(NULL, 'res_table', 'yes', 1),
(NULL, 'tables_pagination_limit',25, 1),
(NULL, 'copyright_text','powered_by_copyright', 1),
(NULL, 'purchase_code','purchase_code_value', 1),
(NULL, 'idea_feedback_verification_id','idea_feedback_verification_id_value', 1),
(NULL, 'idea_feedback_verified','idea_feedback_verified_value', 1),
(NULL, 'idea_feedback_last_verification','idea_feedback_last_verification_value', 1),
(NULL, 'smtp_email', 'noreply@ideafeedback.com', 1),
(NULL, 'email_protocol', 'mail', 1),
(NULL, 'email_header', '<!doctype html>\r\n<html>\r\n    <head>\r\n        <meta name=\"viewport\" content=\"width=device-width\" />\r\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\r\n        <style>\r\n            body {\r\n				background-color: #f6f6f6;\r\n				font-family: Arial !important;\r\n				-webkit-font-smoothing: antialiased;\r\n				font-size: 15px;\r\n				line-height: 1.4;\r\n				margin: 0;\r\n				padding: 0;\r\n				-ms-text-size-adjust: 100%;\r\n				-webkit-text-size-adjust: 100%;\r\n            }\r\n            table {\r\n				border-collapse: separate;\r\n				mso-table-lspace: 0pt;\r\n				mso-table-rspace: 0pt;\r\n				width: 100%;\r\n            }\r\n            table td {\r\n				font-family: Arial !important;\r\n				font-size: 15px;\r\n				vertical-align: top;\r\n            }\r\n            .content-block-footer{\r\n				box-sizing: border-box;\r\n				vertical-align: top;\r\n				width: 100%;\r\n				font-size: 0px;\r\n				text-align: center;\r\n				padding: 16px;\r\n				border-radius: 0px 0px 4px 4px;\r\n				line-height: inherit;\r\n				min-width: 0px !important;\r\n            }\r\n            .content-block-header{\r\n				box-sizing: border-box;\r\n				vertical-align: top;\r\n				width: 100%;\r\n				text-align: center;\r\n				padding: 25px;\r\n				line-height: inherit;\r\n				min-width: 0px !important;\r\n            }\r\n            .header-color{\r\n				background: #43cea2;\r\n				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;\r\n				font-weight: 500;\r\n				font-size: 29px !important;\r\n				letter-spacing: 2px;\r\n				font-family: Arial !important;\r\n            }\r\n            .footer-color{\r\n				background: #43cea2;\r\n				background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;\r\n				font-weight: 500;\r\n				font-family: Arial !important;\r\n            }\r\n            /* -------------------------------------\r\n            BODY & CONTAINER\r\n            ------------------------------------- */\r\n            .body {\r\n				background-color: #f9f9f9;\r\n				width: 100%;\r\n            }\r\n            /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */\r\n            .container {\r\n				display: block;\r\n				margin: 0 auto !important;\r\n				/* makes it centered */\r\n				max-width: 680px;\r\n				padding: 10px;\r\n				width: 680px;\r\n            }\r\n            /* This should also be a block element, so that it will fill 100% of the .container */\r\n            .content {\r\n				box-sizing: border-box;\r\n				display: block;\r\n				margin: 0 auto;\r\n				max-width: 680px;\r\n				padding: 10px;\r\n            }\r\n            /* -------------------------------------\r\n            HEADER, FOOTER, MAIN\r\n            ------------------------------------- */\r\n            .main {\r\n				background: #fff;\r\n				border-radius: 3px;\r\n				width: 100%;\r\n            }\r\n            .wrapper {\r\n				box-sizing: border-box;\r\n				padding: 20px;\r\n            }\r\n            .footer {\r\n				clear: both;\r\n				text-align: center;\r\n				width: 100%;\r\n            }\r\n            .footer td,\r\n            .footer p,\r\n            .footer span,\r\n            .footer a {\r\n				color: #fff;\r\n				font-size: 12px;\r\n				text-align: center;\r\n            }\r\n            hr {\r\n				border: 0;\r\n				border-bottom: 1px solid #f6f6f6;\r\n				margin: 20px 0;\r\n            }\r\n            /* -------------------------------------\r\n            RESPONSIVE AND MOBILE FRIENDLY STYLES\r\n            ------------------------------------- */\r\n            @media only screen and (max-width: 620px) {\r\n				table[class=body] .content {\r\n					padding: 0 !important;\r\n				}\r\n				table[class=body] .container {\r\n					padding: 0 !important;\r\n					width: 100% !important;\r\n				}\r\n					table[class=body] .main {\r\n					border-left-width: 0 !important;\r\n					border-radius: 0 !important;\r\n					border-right-width: 0 !important;\r\n				}\r\n            }\r\n        </style>\r\n    </head>\r\n    <body class=\"\">\r\n        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\">\r\n        <tr>\r\n            <td> </td>\r\n            <td class=\"container\">\r\n                <div class=\"content\">\r\n                <div class=\"footer\">\r\n                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n                        <tr>\r\n                            <td class=\"content-block-header header-color\">\r\n                                {COMPANY_NAME}\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                    </table>\r\n                </div>\r\n                <!-- START CENTERED WHITE CONTAINER -->\r\n                <table class=\"main\">\r\n                <!-- START MAIN CONTENT AREA -->\r\n        <tr>\r\n            <td class=\"wrapper\">\r\n                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n            <td>', 1),
(NULL, 'email_footer', '</td>\r\n</tr>\r\n</table>\r\n</td>\r\n</tr>\r\n<!-- END MAIN CONTENT AREA -->\r\n</table>\r\n<!-- START FOOTER -->\r\n<div class=\"footer\">\r\n    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n            <td class=\"content-block-footer footer-color\">\r\n                <span>{COMPANY_NAME}</span>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n    </table>\r\n</div>\r\n<!-- END FOOTER -->\r\n<!-- END CENTERED WHITE CONTAINER -->\r\n</div>\r\n</td>\r\n<td> </td>\r\n</tr>\r\n</table>\r\n</body>\r\n</html>', 1);


DROP TABLE IF EXISTS `roadmap`;
CREATE TABLE IF NOT EXISTS `roadmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `roadmap` (`id`, `value`) VALUES
(0, 'New'),
(1, 'Planned'),
(2, 'In-Progress'),
(3, 'Implemented'),
(4, 'Rejected');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(NULL, 'admin_email', 'admin_username', 'admin_password',NULL,NULL,NULL, NULL, NULL, NULL, 1, 0, 'admin_created_at',NULL, NULL);


DROP TABLE IF EXISTS `users_front`;
CREATE TABLE IF NOT EXISTS `users_front` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users_upvotes_detail`;
CREATE TABLE IF NOT EXISTS `users_upvotes_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `feedback_id` (`feedback_id`,`user_id`),
  KEY `users_upvotes_detail_ibfk_1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `feedbacks`
  ADD CONSTRAINT `fk_board_id` FOREIGN KEY (`board_id`) REFERENCES `board` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users_front` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `feedbacks_ideas`
  ADD CONSTRAINT `feedbacks_ideas_ibfk_1` FOREIGN KEY (`feedback_id`) REFERENCES `feedbacks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedbacks_ideas_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `board` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `users_upvotes_detail`
  ADD CONSTRAINT `fk_feedback_id` FOREIGN KEY (`feedback_id`) REFERENCES `feedbacks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_upvotes_detail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_front` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

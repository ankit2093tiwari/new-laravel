<!-- 06/04-2023 -->

ALTER TABLE `users` CHANGE `email_varify_status` `login_status` INT(11) NOT NULL DEFAULT '0';


<!-- 10/04/20203 -->

create a table -> user_types

ALTER TABLE `users` ADD `user_type_id` INT(20) NULL AFTER `id`;
ALTER TABLE `users` ADD `failed_login_attempt_count` INT(20) NULL DEFAULT '0' AFTER `login_status`;
ALTER TABLE `users` ADD `email_varify_status` INT NULL DEFAULT '0' AFTER `failed_login_attempt_count`;
ALTER TABLE `users` ADD `email_varify_otp` BIGINT(20) NULL AFTER `failed_login_attempt_count`;


<!-- 11/04/2023 -->
create a table -> settings

<!-- 12/04/2023 -->

ALTER TABLE `users` CHANGE `email_varify_otp` `foreget_username_and_password_otp` BIGINT(20) NULL DEFAULT NULL, CHANGE `email_varify_status` `foreget_username_and_password_otp_verification_status` INT(11) NULL DEFAULT '0';


ALTER TABLE `users` ADD `is_email_verify_status` INT NULL DEFAULT '0' AFTER `email`;


<!-- 24/04/2023 -->

create a new table colled insert_update_username_password_records

<!-- 04/05/2023 -->

INSERT INTO `user_types` (`id`, `user_type`, `created_at`, `updated_at`) VALUES (NULL, 'User', '2023-04-10 12:14:59', '2023-04-10 12:14:59');
ALTER TABLE `users` ADD `created_by` INT NULL AFTER `foreget_username_and_password_otp_verification_status`, ADD `updated_by` INT NULL AFTER `created_by`;

<!-- 17-05-23 -->

ALTER TABLE `users` ADD `profile_image` VARCHAR(255) NULL AFTER `password`, ADD `country` VARCHAR(255) NULL AFTER `profile_image`, ADD `country_code` VARCHAR(255) NULL AFTER `country`, ADD `whats_app_number` VARCHAR(255) NULL AFTER `country_code`, ADD `fb` VARCHAR(255) NULL AFTER `whats_app_number`, ADD `twitter` VARCHAR(255) NULL AFTER `fb`;

ALTER TABLE `users` CHANGE `profile_image` `profile_image` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

ALTER TABLE `users` ADD `file_name` VARCHAR(255) NULL AFTER `profile_image`, ADD `file_size` VARCHAR(255) NULL AFTER `file_name`, ADD `file_extention` VARCHAR(255) NULL AFTER `file_size`;

<!-- 18-05-23 -->
ALTER TABLE `users` CHANGE `gender` `gender` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '1-Male , 2-Female, 3-Others';


<!-- 23=5-23 -->
Add a new table (invite_users)

<!-- 24-05-23 -->
ALTER TABLE `invite_users` DROP `inviter_id`;

<!-- 05-06-23 -->
Add a table child_wise_favourite_stores

<!-- 06-06-23 -->
Add two table (interest_categories / interest_sub_categories)

<!-- 22-06-23 -->
ALTER TABLE `users` ADD `invite_user_status` INT NULL DEFAULT '0' COMMENT '0 -> not Invite / 1 -> pending / 2 -> Invite accepted' AFTER `login_status`;
ALTER TABLE `interest_categories` ADD `is_delete_edit` INT NULL DEFAULT '1' COMMENT '0 -> not delete / 1 -> delete' AFTER `description`;
ALTER TABLE `child_wise_favourite_stores` ADD `is_delete_edit` INT NULL DEFAULT '1' COMMENT '0 -> not delete / 1 -> delete' AFTER `website_url`;

<!-- 23-06-23 -->
ALTER TABLE `users` ADD `invited_by_parent_for_setup_profile` INT NULL DEFAULT '0' COMMENT '1 -> invite / 0 ->not invite' AFTER `invite_user_status`;

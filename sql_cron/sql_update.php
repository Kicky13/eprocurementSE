ALTER TABLE `supreme_user5`.`cmms_wr` 
ADD COLUMN `long_description` text NULL AFTER `comment_supervisor`;
ALTER TABLE `t_msr_draft` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `master_list`, ADD `eq_no` VARCHAR(50) NULL DEFAULT NULL AFTER `wo_no`;
ALTER TABLE `t_msr` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `deskripsi`, ADD `eq_no` VARCHAR(50) NULL DEFAULT NULL AFTER `wo_no`
INSERT INTO `cmms_settings` (`id`, `module`, `desc`, `desc1`, `desc2`, `seq`) VALUES (NULL, 'wo_detail', 'Agreement No', NULL, 'PO_NO', '12');

ALTER TABLE `supreme_user5`.`cmms_wr` 
ADD COLUMN `long_description` text NULL AFTER `comment_supervisor`;
ALTER TABLE `t_msr_draft` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `master_list`, ADD `eq_no` VARCHAR(50) NULL DEFAULT NULL AFTER `wo_no`;
ALTER TABLE `t_msr` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `deskripsi`, ADD `eq_no` VARCHAR(50) NULL DEFAULT NULL AFTER `wo_no`
INSERT INTO `cmms_settings` (`id`, `module`, `desc`, `desc1`, `desc2`, `seq`) VALUES (NULL, 'wo_detail', 'Agreement No', NULL, 'PO_NO', '12');

ALTER TABLE `t_msr_item_draft` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `is_asset`;
ALTER TABLE `t_msr_item` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `is_asset`;


INSERT INTO `m_menu` (`ID_MENU`, `PARENT`, `DESKRIPSI_IND`, `DESKRIPSI_ENG`, `CATEGORY`, `SORT`, `STATUS`, `ICON`, `URL`) VALUES (NULL, '118', 'Replenisment', 'Replenisment', NULL, '8', '1', 'fa-cube', 'cmms/replenisment');
UPDATE `m_user_roles` SET `MENU` = ',118,119,121,122,123,120,124,125,126,' WHERE `m_user_roles`.`ID_USER_ROLES` = 100009;

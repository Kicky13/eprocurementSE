ALTER TABLE `supreme_user5`.`cmms_wr` 
ADD COLUMN `long_description` text NULL AFTER `comment_supervisor`;
ALTER TABLE `t_msr_draft` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `master_list`, ADD `eq_no` VARCHAR(50) NULL DEFAULT NULL AFTER `wo_no`;
ALTER TABLE `t_msr` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `deskripsi`, ADD `eq_no` VARCHAR(50) NULL DEFAULT NULL AFTER `wo_no`
INSERT INTO `cmms_settings` (`id`, `module`, `desc`, `desc1`, `desc2`, `seq`) VALUES (NULL, 'wo_detail', 'Agreement No', NULL, 'PO_NO', '12');

ALTER TABLE `t_msr_item_draft` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `is_asset`;
ALTER TABLE `t_msr_item` ADD `wo_no` VARCHAR(50) NULL DEFAULT NULL AFTER `is_asset`;


INSERT INTO `m_menu` (`ID_MENU`, `PARENT`, `DESKRIPSI_IND`, `DESKRIPSI_ENG`, `CATEGORY`, `SORT`, `STATUS`, `ICON`, `URL`) VALUES (NULL, '118', 'Replenisment', 'Replenisment', NULL, '8', '1', 'fa-cube', 'cmms/replenisment');
UPDATE `m_user_roles` SET `MENU` = ',118,119,121,122,123,120,124,125,126,' WHERE `m_user_roles`.`ID_USER_ROLES` = 100009;


INSERT INTO `m_menu_task` (`id`, `desc_ind`, `desc_eng`, `key`, `url`, `sort`, `parent`, `open_on_zero`, `icon`) VALUES 
(101, 'CMMS', 'CMMS', NULL, NULL, 5, 0, 0, 'fa fa-home'),
(102, 'CMMS', 'CMMS', 'cmms', NULL, 1, 101, 1, 'fa fa-gear'),
(103, 'Outstanding Work Order', 'Outstanding Work Order', 'outstanding_wo_report', 'cmms/wo/index/outstanding', 1, 102, 0, 'fa fa-home'),
(104, 'Work Request Approval', 'Work Request Approval', 'suprevisor_task', 'cmms/wr', 2, 102, 0, 'fa fa-home')

INSERT INTO `m_user_roles` (`ID_USER_ROLES`, `DESCRIPTION`, `MENU`, `TASK`, `STATUS`, `CREATE_BY`, `CREATE_TIME`, `UPDATE_BY`, `UPDATE_TIME`) VALUES 
(100007, 'CMMS Maintenance Planner', ',118,119,121,122,123,124,120,', ',101,102,103,', '1', '1', '2019-08-04 18:25:33', '168', '2019-08-04 18:25:33'),
(100008, 'CMMS Technician- Operator', ',118,119,120,121,122,123,124,', ',101,102,103,', '1', '1', '2018-03-07 15:13:22', '168', '2019-07-11 14:25:53'),
(100009, 'CMMS Supervisor', ',118,119,121,122,123,120,124,125,126,', ',101,102,103,104,', '1', '1', '2018-02-18 04:26:16', '168', '2019-07-11 14:29:29'),
(100010, 'CMMS Department', ',118,119,121,120,', ',101,102,103,', '1', '1', '2018-02-18 04:26:16', '168', '2019-07-11 14:29:29'),
(100011, 'Manage User CMMS', ',127,', ',127,', '1', '1', '2018-02-18 04:26:16', '168', '2019-07-11 14:29:29')

UPDATE `m_user` SET `ROLES` = ',32,41,100009,' WHERE `m_user`.`ID_USER` = 116;

ALTER TABLE `m_warehouse`  ADD `is_cmms` TINYINT(1) NOT NULL DEFAULT '0'  AFTER `active`;

INSERT INTO `m_warehouse` (`id_company`, `id_warehouse`, `description`, `active`, `is_cmms`, `update_by`, `update_date`, `create_by`, `create_date`) VALUES 
('10101', '   10101WH02', 'Branch Plant Muara Laboh Close WH ', 1, 1, 1, '2018-04-09 09:33:16', 1, '2018-04-09 09:33:16');
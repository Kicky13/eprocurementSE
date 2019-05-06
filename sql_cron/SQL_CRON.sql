

-- PO --
DELETE FROM supreme_dashboard.t_purchase_order WHERE po_no in (
	select po_no from supreme_user.t_purchase_order where issued_date>=(select max(createdate) from supreme_user.sync_log WHERE module='PO_MST')
);

DELETE FROM supreme_dashboard.t_purchase_order_detail WHERE po_id in (
	select id from supreme_user.t_purchase_order where issued_date>=(select max(createdate) from supreme_user.sync_log WHERE module='PO_MST')
);

INSERT INTO supreme_dashboard.t_purchase_order (id, po_no, po_type, msr_no, id_company, company_desc, bl_detail_id, title, po_date, delivery_date, blanket, payment_term, shipping_term, id_dpoint, id_importation, id_currency, id_currency_base, vendor_bank_account_key, account_name, bank_name, tkdn_type, tkdn_value_goods, tkdn_value_service, tkdn_value_combination, id_vendor, master_list, total_amount, total_amount_base, create_by, create_on, issued, issued_date, issued_by, completed, completed_date, completed_by, accept_completed, accept_completed_date, accept_completed_by) 
SELECT id, po_no, po_type, msr_no, id_company, company_desc, bl_detail_id, title, po_date, delivery_date, blanket, payment_term, shipping_term, id_dpoint, id_importation, id_currency, id_currency_base, vendor_bank_account_key, account_name, bank_name, tkdn_type, tkdn_value_goods, tkdn_value_service, tkdn_value_combination, id_vendor, master_list, total_amount, total_amount_base, create_by, create_on, issued, issued_date, issued_by, completed, completed_date, completed_by, accept_completed, accept_completed_date, accept_completed_by
FROM supreme_user.t_purchase_order
WHERE po_no not in (
	SELECT distinct po_no FROM supreme_dashboard.t_purchase_order
);

INSERT INTO supreme_dashboard.t_purchase_order_detail (id, po_id, msr_item_id, line_no, sop_bid_id, id_itemtype, material_id, semic_no, material_desc, qty, id_uom, uom_desc, is_modification, id_msr_inv_type, id_costcenter, costcenter_desc, id_accsub, accsub_desc, groupcat, sub_groupcat, sub_groupcat_desc, groupcat_desc, est_unitprice, est_unitprice_base, est_total_price, est_total_price_base, unitprice, unitprice_base, total_price, total_price_base)
SELECT id, po_id, msr_item_id, line_no, sop_bid_id, id_itemtype, material_id, semic_no, material_desc, qty, id_uom, uom_desc, is_modification, id_msr_inv_type, id_costcenter, costcenter_desc, id_accsub, accsub_desc, groupcat, sub_groupcat, sub_groupcat_desc, groupcat_desc, est_unitprice, est_unitprice_base, est_total_price, est_total_price_base, unitprice, unitprice_base, total_price, total_price_base
FROM supreme_user.t_purchase_order_detail 
WHERE po_id not in (
	SELECT distinct po_id FROM supreme_dashboard.t_purchase_order_detail
);

INSERT INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'PO_MST',now());
INSERT INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'PO_DTL',now());



-- APPROVAL --
DELETE FROM supreme_dashboard.t_approval WHERE id in (
	select id from supreme_user.t_approval where created_at>=(select max(createdate) from supreme_user.sync_log WHERE module='APP_MST')
);

DELETE FROM supreme_dashboard.m_approval_rule WHERE id in (
	select id from supreme_user.m_approval_rule where updatedate>=(select max(createdate) from supreme_user.sync_log WHERE module='APP_RUL')
);

INSERT INTO supreme_dashboard.m_approval (id, module_kode, role_id, urutan, opsi, deskripsi, aktif) 
SELECT id, module_kode, role_id, urutan, opsi, deskripsi, aktif FROM supreme_user.m_approval WHERE id not in
(SELECT id FROM supreme_dashboard.m_approval);


INSERT INTO supreme_dashboard.t_approval (id, m_approval_id, status, data_id, created_at, deskripsi, created_by, urutan) 
SELECT id, m_approval_id, status, data_id, created_at, deskripsi, created_by, urutan
FROM supreme_user.t_approval where id not in (
	SELECT distinct id FROM supreme_dashboard.t_approval
);

INSERT INTO supreme_dashboard.m_approval_modul (id, description) SELECT id, description FROM supreme_user.m_approval_modul WHERE id not in 
(SELECT id FROM supreme_dashboard.m_approval_modul);

INSERT INTO supreme_dashboard.m_approval_rule (id, user_roles, description, sequence, type, status, module, reject_step, email_approve, email_reject, edit_content, extra_case, updateby, updatedate, createby, createdate) 
SELECT id, user_roles, description, sequence, type, status, module, reject_step, email_approve, email_reject, edit_content, extra_case, updateby, updatedate, createby, createdate FROM supreme_user.m_approval_rule
WHERE id not in (SELECT id FROm supreme_dashboard.m_approval_rule);

INSERT INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'APP_MST',now());
INSERT INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'APP_TRC',now());
INSERT INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'APP_MDL',now());
INSERT INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'APP_RUL',now());


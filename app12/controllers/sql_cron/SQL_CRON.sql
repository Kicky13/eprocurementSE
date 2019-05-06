

-- PO --
DELETE FROM supreme_dashboard.t_purchase_order WHERE po_no in (
	select po_no from supreme_user.t_purchase_order where issued_date>=(select max(createdate) from supreme_user.sync_log WHERE module='PO_MST')
);

DELETE FROM supreme_dashboard.t_purchase_order_detail WHERE po_id in (
	select id from supreme_user.t_purchase_order where issued_date>=(select max(createdate) from supreme_user.sync_log WHERE module='PO_MST')
);

REPLACE INTO supreme_dashboard.t_purchase_order (id, po_no, po_type, msr_no, id_company, company_desc, bl_detail_id, title, po_date, delivery_date, blanket, payment_term, shipping_term, id_dpoint, id_importation, id_currency, id_currency_base, vendor_bank_account_key, account_name, bank_name, tkdn_type, tkdn_value_goods, tkdn_value_service, tkdn_value_combination, id_vendor, master_list, total_amount, total_amount_base, create_by, create_on, issued, issued_date, issued_by, completed, completed_date, completed_by, accept_completed, accept_completed_date, accept_completed_by) 
SELECT id, po_no, po_type, msr_no, id_company, company_desc, bl_detail_id, title, po_date, delivery_date, blanket, payment_term, shipping_term, id_dpoint, id_importation, id_currency, id_currency_base, vendor_bank_account_key, account_name, bank_name, tkdn_type, tkdn_value_goods, tkdn_value_service, tkdn_value_combination, id_vendor, master_list, total_amount, total_amount_base, create_by, create_on, issued, issued_date, issued_by, completed, completed_date, completed_by, accept_completed, accept_completed_date, accept_completed_by
FROM supreme_user.t_purchase_order
WHERE po_no not in (
	SELECT distinct po_no FROM supreme_dashboard.t_purchase_order
);

REPLACE INTO supreme_dashboard.t_purchase_order_detail (id, po_id, msr_item_id, line_no, sop_bid_id, id_itemtype, material_id, semic_no, material_desc, qty, id_uom, uom_desc, is_modification, id_msr_inv_type, id_costcenter, costcenter_desc, id_accsub, accsub_desc, groupcat, sub_groupcat, sub_groupcat_desc, groupcat_desc, est_unitprice, est_unitprice_base, est_total_price, est_total_price_base, unitprice, unitprice_base, total_price, total_price_base)
SELECT id, po_id, msr_item_id, line_no, sop_bid_id, id_itemtype, material_id, semic_no, material_desc, qty, id_uom, uom_desc, is_modification, id_msr_inv_type, id_costcenter, costcenter_desc, id_accsub, accsub_desc, groupcat, sub_groupcat, sub_groupcat_desc, groupcat_desc, est_unitprice, est_unitprice_base, est_total_price, est_total_price_base, unitprice, unitprice_base, total_price, total_price_base
FROM supreme_user.t_purchase_order_detail 
WHERE po_id not in (
	SELECT distinct po_id FROM supreme_dashboard.t_purchase_order_detail
);

REPLACE INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'PO_MST',now());
REPLACE INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'PO_DTL',now());



-- APPROVAL --
DELETE FROM supreme_dashboard.t_approval WHERE id in (
	select id from supreme_user.t_approval where created_at>=(select max(createdate) from supreme_user.sync_log WHERE module='APP_MST')
);

DELETE FROM supreme_dashboard.m_approval_rule WHERE id in (
	select id from supreme_user.m_approval_rule where updatedate>=(select max(createdate) from supreme_user.sync_log WHERE module='APP_RUL')
);

REPLACE INTO supreme_dashboard.m_approval (id, module_kode, role_id, urutan, opsi, deskripsi, aktif) 
SELECT id, module_kode, role_id, urutan, opsi, deskripsi, aktif FROM supreme_user.m_approval WHERE id not in
(SELECT id FROM supreme_dashboard.m_approval);


REPLACE INTO supreme_dashboard.t_approval (id, m_approval_id, status, data_id, created_at, deskripsi, created_by, urutan) 
SELECT id, m_approval_id, status, data_id, created_at, deskripsi, created_by, urutan
FROM supreme_user.t_approval where id not in (
	SELECT distinct id FROM supreme_dashboard.t_approval
);

REPLACE INTO supreme_dashboard.m_approval_modul (id, description) SELECT id, description FROM supreme_user.m_approval_modul WHERE id not in 
(SELECT id FROM supreme_dashboard.m_approval_modul);

REPLACE INTO supreme_dashboard.m_approval_rule (id, user_roles, description, sequence, type, status, module, reject_step, email_approve, email_reject, edit_content, extra_case, updateby, updatedate, createby, createdate) 
SELECT id, user_roles, description, sequence, type, status, module, reject_step, email_approve, email_reject, edit_content, extra_case, updateby, updatedate, createby, createdate FROM supreme_user.m_approval_rule
WHERE id not in (SELECT id FROm supreme_dashboard.m_approval_rule);

REPLACE INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'APP_MST',now());
REPLACE INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'APP_TRC',now());
REPLACE INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'APP_MDL',now());
REPLACE INTO supreme_user.sync_log(id,module,createdate) VALUES (null,'APP_RUL',now());

-- SETTING MASTER --

REPLACE INTO supreme_dashboard.m_accsub (COMPANY, COSTCENTER, ID_ACCSUB, ACCSUB_DESC, POSTING, STATUS, CREATE_BY, CREATE_ON, CHANGED_BY, CHANGED_ON) 
SELECT COMPANY, COSTCENTER, ID_ACCSUB, ACCSUB_DESC, POSTING, STATUS, CREATE_BY, CREATE_ON, CHANGED_BY, CHANGED_ON FROM supreme_user.m_accsub
WHERE CONCAT(supreme_user.m_accsub.COSTCENTER,supreme_user.m_accsub.ID_ACCSUB);


-- MSR --
REPLACE INTO supreme_dashboard.t_msr (msr_no, id_company, company_desc, id_msr_type, msr_type_desc, title, blanket, id_currency, id_currency_base, req_date, lead_time, id_ploc, rloc_desc, id_pmethod, pmethod_desc, scope_of_work, create_by, create_on, id_dpoint, dpoint_desc, id_importation, importation_desc, id_requestfor, requestfor_desc, id_inspection, inspection_desc, id_deliveryterm, deliveryterm_desc, id_freight, freight_desc, total_amount, total_amount_base, procure_processing_time, id_costcenter, costcenter_desc, id_department, department_desc, master_list, status)
SELECT msr_no, id_company, company_desc, id_msr_type, msr_type_desc, title, blanket, id_currency, id_currency_base, req_date, lead_time, id_ploc, rloc_desc, id_pmethod, pmethod_desc, scope_of_work, create_by, create_on, id_dpoint, dpoint_desc, id_importation, importation_desc, id_requestfor, requestfor_desc, id_inspection, inspection_desc, id_deliveryterm, deliveryterm_desc, id_freight, freight_desc, total_amount, total_amount_base, procure_processing_time, id_costcenter, costcenter_desc, id_department, department_desc, master_list, status 
FROM supreme_user.t_msr;


REPLACE INTO supreme_dashboard.t_msr_item (line_item, msr_no, id_itemtype, id_itemtype_category, material_id, semic_no, service_cat, description, groupcat, groupcat_desc, sub_groupcat, sub_groupcat_desc, qty, uom_id, uom, priceunit, priceunit_base, id_importation, importation_desc, id_dpoint, dpoint_desc, id_bplant, id_costcenter, costcenter_desc, id_accsub, accsub_desc, amount, amount_base, inv_type, item_modification, is_asset) 
SELECT line_item, msr_no, id_itemtype, id_itemtype_category, material_id, semic_no, service_cat, description, groupcat, groupcat_desc, sub_groupcat, sub_groupcat_desc, qty, uom_id, uom, priceunit, priceunit_base, id_importation, importation_desc, id_dpoint, dpoint_desc, id_bplant, id_costcenter, costcenter_desc, id_accsub, accsub_desc, amount, amount_base, inv_type, item_modification, is_asset
FROM supreme_user.t_msr_item;


REPLACE INTO supreme_dashboard.t_eq_data (id, msr_no, created_at, created_by, subject, prebid_address, closing_date, administration, technical_data, commercial_data, currency, bid_validity, bid_bond, bid_bond_type, bid_bond_validity, prebid_loc, status, bid_opening, administrative, technical, commercial, award, boc_date, bod_date, issued_award_note, packet, incoterm, envelope_system, delivery_point, issued_date, bid_opening_date, desc_of_award, path_boc, path_bod, ee_file, ee_value, ee_desc) 
SELECT id, msr_no, created_at, created_by, subject, prebid_address, closing_date, administration, technical_data, commercial_data, currency, bid_validity, bid_bond, bid_bond_type, bid_bond_validity, prebid_loc, status, bid_opening, administrative, technical, commercial, award, boc_date, bod_date, issued_award_note, packet, incoterm, envelope_system, delivery_point, issued_date, bid_opening_date, desc_of_award, path_boc, path_bod, ee_file, ee_value, ee_desc
 FROM supreme_user.t_eq_data ;

REPLACE INTO supreme_dashboard.t_assignment (id, user_id, msr_no, msr_type, proc_method, deskripsi, updated_at, updated_by) 
SELECT id, user_id, msr_no, msr_type, proc_method, deskripsi, updated_at, updated_by FROM supreme_user.t_assignment;

REPLACE INTO supreme_dashboard.t_bid_bond (id, bled_no, bid_bond_no, bid_bond_file, issuer, issued_date, nominal, currency, effective_date, expired_date, status, description, created_by, created_at) 
SELECT id, bled_no, bid_bond_no, bid_bond_file, issuer, issued_date, nominal, currency, effective_date, expired_date, status, description, created_by, created_at
FROM supreme_user.t_bid_bond;

REPLACE INTO supreme_dashboard.t_bid_detail (id, msr_detail_id, id_currency, unit_price, nego_price, id_currency_base, unit_price_base, nego_price_base, created_at, created_by, updated_at, bled_no, nego, nego_date, award, unit_month, unit_week) 
SELECT id, msr_detail_id, id_currency, unit_price, nego_price, id_currency_base, unit_price_base, nego_price_base, created_at, created_by, updated_at, bled_no, nego, nego_date, award, unit_month, unit_week 
FROM supreme_user.t_bid_detail;

REPLACE INTO supreme_dashboard.t_bid_head (id, vendor_id, bled_no, status, bid_letter_no, id_local_content_type, local_content, bid_letter_path, local_content_path, duration, bid_validity, soc, tp, pl, issued_nego, note, delivery_month, delivery_week, delivery_nilai, delivery_satuan, created_at, created_by) 
SELECT id, vendor_id, bled_no, status, bid_letter_no, id_local_content_type, local_content, bid_letter_path, local_content_path, duration, bid_validity, soc, tp, pl, issued_nego, note, delivery_month, delivery_week, delivery_nilai, delivery_satuan, created_at, created_by
 FROM supreme_user.t_bid_head;

 REPLACE INTO supreme_dashboard.t_bl (id, bled_no, title, msr_no, created_at, created_by, pmethod, status) 
SELECT id, bled_no, title, msr_no, created_at, created_by, pmethod, status FROM 
supreme_user.t_bl;


REPLACE INTO supreme_dashboard.t_bl_detail (id, vendor_id, msr_no, confirmed, submission_date, created_at, created_by, administrative, desc_administrative, technical, desc_technical, commercial, desc_commercial, nego_desc, nego_date, award_desc, awarder, accept_award, desc_accept_award, accept_award_date, awarder_date, reason, scoring)
SELECT id, vendor_id, msr_no, confirmed, submission_date, created_at, created_by, administrative, desc_administrative, technical, desc_technical, commercial, desc_commercial, nego_desc, nego_date, award_desc, awarder, accept_award, desc_accept_award, accept_award_date, awarder_date, reason, scoring
FROM supreme_user.t_bl_detail;

REPLACE INTO supreme_dashboard.t_letter_of_intent (id, bl_id, bl_detail_id, id_company, awarder_id, msr_no, rfq_no, po_no, loi_date, title, company_letter, id_currency, id_currency_base, total_amount, total_amount_base, issued, issued_by, issued_on, accepted, accepted_on, accepted_by, create_by, create_on, update_by, update_on) 
SELECT id, bl_id, bl_detail_id, id_company, awarder_id, msr_no, rfq_no, po_no, loi_date, title, company_letter, id_currency, id_currency_base, total_amount, total_amount_base, issued, issued_by, issued_on, accepted, accepted_on, accepted_by, create_by, create_on, update_by, update_on
FROM supreme_user.t_letter_of_intent;

REPLACE INTO supreme_dashboard.t_nego (id, msr_no, vendor_id, company_letter_no, closing_date, supporting_document, note, bid_letter_no, bid_letter_file, id_local_content_type, local_content, local_content_file, bid_note, status, closed, created_by, created_at, responsed_at)
SELECT id, msr_no, vendor_id, company_letter_no, closing_date, supporting_document, note, bid_letter_no, bid_letter_file, id_local_content_type, local_content, local_content_file, bid_note, status, closed, created_by, created_at, responsed_at
FROM supreme_user.t_nego;


REPLACE INTO supreme_dashboard.t_nego_detail (id, nego_id, msr_no, vendor_id, sop_id, id_currency, id_currency_base, latest_price, latest_price_base, negotiated_price, negotiated_price_base, nego)
SELECT id, nego_id, msr_no, vendor_id, sop_id, id_currency, id_currency_base, latest_price, latest_price_base, negotiated_price, negotiated_price_base, nego
FROM supreme_user.t_nego_detail;


REPLACE INTO supreme_dashboard.t_service_receipt (id, id_itp, service_receipt_no, id_external, receipt_date, id_currency, subtotal, id_currency_base, subtotal_base, note, status, accept, cancel, accepted_at, created_by, created_at, updated_by, updated_at)
SELECT id, id_itp, service_receipt_no, id_external, receipt_date, id_currency, subtotal, id_currency_base, subtotal_base, note, status, accept, cancel, accepted_at, created_by, created_at, updated_by, updated_at FROM
supreme_user.t_service_receipt ;


REPLACE INTO supreme_dashboard.t_service_receipt_detail (id, id_itp, id_service_receipt, id_material, qty, id_currency, price, total, id_currency_base, price_base, total_base, note)
SELECT id, id_itp, id_service_receipt, id_material, qty, id_currency, price, total, id_currency_base, price_base, total_base, note FROM
supreme_user.t_service_receipt_detail;


REPLACE INTO supreme_dashboard.t_sop (id, msr_item_id, msr_no, sop_type, item_material_id, item_semic_no_value, item, id_itemtype, id_itemtype_category, groupcat, groupcat_desc, sub_groupcat, sub_groupcat_desc, inv_type, item_modification, id_costcenter, costcenter_desc, id_accsub, accsub_desc, qty1, uom1, qty2, uom2, tax, created_by, created_at, updated_at)
SELECT id, msr_item_id, msr_no, sop_type, item_material_id, item_semic_no_value, item, id_itemtype, id_itemtype_category, groupcat, groupcat_desc, sub_groupcat, sub_groupcat_desc, inv_type, item_modification, id_costcenter, costcenter_desc, id_accsub, accsub_desc, qty1, uom1, qty2, uom2, tax, created_by, created_at, updated_at
FROM supreme_user.t_sop;

REPLACE INTO supreme_dashboard.t_sop_bid (id, sop_id, msr_no, vendor_id, id_currency, unit_price, nego_price, id_currency_base, unit_price_base, nego_price_base, remark, nego, nego_date, award, unit_month, unit_week, deviation, unit_value, unit_uom, created_at, updated_at, created_by, updated_by, qty) 
SELECT id, sop_id, msr_no, vendor_id, id_currency, unit_price, nego_price, id_currency_base, unit_price_base, nego_price_base, remark, nego, nego_date, award, unit_month, unit_week, deviation, unit_value, unit_uom, created_at, updated_at, created_by, updated_by, qty
FROM supreme_user.t_sop_bid ;


REPLACE INTO supreme_dashboard.t_arf (id, doc_no, doc_date, po_no, po_title, company_id, company, department_id, department, currency_id, currency, currency_base_id, currency_base, amount_po, amount_po_base, amount_po_arf, amount_po_arf_base, amount_spending, amount_spending_base, amount_remaining, amount_remaining_base, delivery_date_po, amended_date, estimated_value, estimated_value_base, estimated_new_value, estimated_new_value_base, expected_commencement_date, review_bod, tax, tax_base, total, total_base, status, created_by, created_at, updated_by, updated_at) 
SELECT id, doc_no, doc_date, po_no, po_title, company_id, company, department_id, department, currency_id, currency, currency_base_id, currency_base, amount_po, amount_po_base, amount_po_arf, amount_po_arf_base, amount_spending, amount_spending_base, amount_remaining, amount_remaining_base, delivery_date_po, amended_date, estimated_value, estimated_value_base, estimated_new_value, estimated_new_value_base, expected_commencement_date, review_bod, tax, tax_base, total, total_base, status, created_by, created_at, updated_by, updated_at
FROM supreme_user.t_arf;


REPLACE INTO supreme_dashboard.t_arf_assignment (id, doc_id, po_no, user_id, created_by, created_at, updated_by, updated_at) 
SELECT id, doc_id, po_no, user_id, created_by, created_at, updated_by, updated_at 
FROM supreme_user.t_arf_assignment;


REPLACE INTO supreme_dashboard.t_arf_detail (id, doc_id, semic_no, material_desc, material_category, material_classification, id_item_type, item_type, id_item_type_category, item_type_category, id_inventory_type, inventory_type, item_modification, id_importation, id_delivery_point, delivery_point, id_costcenter, costcenter, id_account_subsidiary, account_subsidiary, qty, uom, id_currency, id_currency_base, unit_price, unit_price_base, is_tax, tax, tax_base, total_price, total_price_base) 
SELECT id, doc_id, semic_no, material_desc, material_category, material_classification, id_item_type, item_type, id_item_type_category, item_type_category, id_inventory_type, inventory_type, item_modification, id_importation, id_delivery_point, delivery_point, id_costcenter, costcenter, id_account_subsidiary, account_subsidiary, qty, uom, id_currency, id_currency_base, unit_price, unit_price_base, is_tax, tax, tax_base, total_price, total_price_base
FROM supreme_user.t_arf_detail;


REPLACE INTO supreme_dashboard.t_arf_detail_revision (id, doc_id, type, value, remark) 
SELECT id, doc_id, type, value, remark FROM supreme_user.t_arf_detail_revision
;


REPLACE INTO supreme_dashboard.t_arf_notification (id, doc_no, dated, po_no, estimated_value_new, response_date, is_draft, is_done, updated_by, updated_date, created_by, created_date) 
SELECT id, doc_no, dated, po_no, estimated_value_new, response_date, is_draft, is_done, updated_by, updated_date, created_by, created_date FROM supreme_user.t_arf_notification;

REPLACE INTO supreme_dashboard.t_arf_sop (id, arf_item_id, doc_id, sop_type, item_material_id, item_semic_no_value, item, id_itemtype, id_itemtype_category, groupcat, groupcat_desc, sub_groupcat, sub_groupcat_desc, inv_type, item_modification, id_costcenter, costcenter_desc, id_accsub, accsub_desc, id_importation, id_delivery_point, delivery_point, qty1, uom1, qty2, uom2, tax, created_by, created_at, updated_by, updated_at) 
SELECT id, arf_item_id, doc_id, sop_type, item_material_id, item_semic_no_value, item, id_itemtype, id_itemtype_category, groupcat, groupcat_desc, sub_groupcat, sub_groupcat_desc, inv_type, item_modification, id_costcenter, costcenter_desc, id_accsub, accsub_desc, id_importation, id_delivery_point, delivery_point, qty1, uom1, qty2, uom2, tax, created_by, created_at, updated_by, updated_at FROM supreme_user.t_arf_sop;


REPLACE INTO supreme_dashboard.m_vendor (ID, ID_VENDOR, NAMA, PASSWORD, PREFIX, CLASSIFICATION, CUALIFICATION, URL, URL_BATAS_HARI, NO_SLKA, SLKA_DATE, STATUS, ID_EXTERNAL, RISK, CREATE_BY, CREATE_TIME, UPDATE_BY, UPDATE_TIME) 
SELECT ID, ID_VENDOR, NAMA, PASSWORD, PREFIX, CLASSIFICATION, CUALIFICATION, URL, URL_BATAS_HARI, NO_SLKA, SLKA_DATE, STATUS, ID_EXTERNAL, RISK, CREATE_BY, CREATE_TIME, UPDATE_BY, UPDATE_TIME FROM supreme_user.m_vendor;


REPLACE INTO supreme_dashboard.m_material (MATERIAL, MATERIAL_CODE, MATERIAL_NAME, REQUEST_NO, SEARCH_TEXT, DESCRIPTION, DESCRIPTION1, IMG1_URL, IMG2_URL, IMG3_URL, IMG4_URL, FILE_URL, FILE_URL2, UOM, UOM1, EQPMENT_NO, EQPMENT_ID, MANUFACTURER, MANUFACTURER_DESCRIPTION, MATERIAL_TYPE, MATERIAL_TYPE_DESCRIPTION, SEQUENCE_GROUP, SEQUENCE_GROUP_DESCRIPTION, INDICATOR, INDICATOR_DESCRIPTION, PART_NO, STOCK_CLASS, AVAILABILITY, CRITICALITY, COLLUQUIALS, TYPE, SERIAL_NUMBER, GL_CLASS, LINE_TYPE, STOCKING_TYPE, STOCK_CLASS2, PROJECT_PHASE, INVENTORY_TYPE, MONTHLY_USAGE, ANNUAL_USAGE, INITIAL_ORDER_QTY, EXPL_ELEMENT, UNIT_OF_ISSUE, ESTIMATE_VALUE, SHELF_LIFE, CROSS_RERERENCE, HAZARDOUS, STATUS, GROUP_CLASS, INSPECTION_CODE, LEAD_TIME, FREIGHT_CODE, FPA, UNIT_PRICE, SUPPLIER_NUMBER, STD_PACK, TARIFF_CODE, CONV_FACT, ORIGIN_CODE, UNIT_OF_ISSUE2, MIN, UNIT_OF_PURCHASE, ROQ, STATISTIC_CODE, ROP, ITEM_OWNERSHIP, STOCK_TYPE, PART_STATUS, STOCK_CODE_NO, PART_NUMBER, ITEM_NAME, PREFERENCE, ITEM_NAME_CODE, MNEMONIC, SEMIC_MAIN_GROUP, SHORTDESC, CREATE_TIME, CREATE_BY, UPDATE_TIME, UPDATE_BY) 
SELECT MATERIAL, MATERIAL_CODE, MATERIAL_NAME, REQUEST_NO, SEARCH_TEXT, DESCRIPTION, DESCRIPTION1, IMG1_URL, IMG2_URL, IMG3_URL, IMG4_URL, FILE_URL, FILE_URL2, UOM, UOM1, EQPMENT_NO, EQPMENT_ID, MANUFACTURER, MANUFACTURER_DESCRIPTION, MATERIAL_TYPE, MATERIAL_TYPE_DESCRIPTION, SEQUENCE_GROUP, SEQUENCE_GROUP_DESCRIPTION, INDICATOR, INDICATOR_DESCRIPTION, PART_NO, STOCK_CLASS, AVAILABILITY, CRITICALITY, COLLUQUIALS, TYPE, SERIAL_NUMBER, GL_CLASS, LINE_TYPE, STOCKING_TYPE, STOCK_CLASS2, PROJECT_PHASE, INVENTORY_TYPE, MONTHLY_USAGE, ANNUAL_USAGE, INITIAL_ORDER_QTY, EXPL_ELEMENT, UNIT_OF_ISSUE, ESTIMATE_VALUE, SHELF_LIFE, CROSS_RERERENCE, HAZARDOUS, STATUS, GROUP_CLASS, INSPECTION_CODE, LEAD_TIME, FREIGHT_CODE, FPA, UNIT_PRICE, SUPPLIER_NUMBER, STD_PACK, TARIFF_CODE, CONV_FACT, ORIGIN_CODE, UNIT_OF_ISSUE2, MIN, UNIT_OF_PURCHASE, ROQ, STATISTIC_CODE, ROP, ITEM_OWNERSHIP, STOCK_TYPE, PART_STATUS, STOCK_CODE_NO, PART_NUMBER, ITEM_NAME, PREFERENCE, ITEM_NAME_CODE, MNEMONIC, SEMIC_MAIN_GROUP, SHORTDESC, CREATE_TIME, CREATE_BY, UPDATE_TIME, UPDATE_BY FROM
supreme_user.m_material;


REPLACE INTO supreme_dashboard.m_material_group (ID, MATERIAL_GROUP, DESCRIPTION, TYPE, CATEGORY, PARENT, STATUS, CREATE_BY, CREATE_TIME, UPDATE_BY, UPDATE_TIME)
SELECT ID, MATERIAL_GROUP, DESCRIPTION, TYPE, CATEGORY, PARENT, STATUS, CREATE_BY, CREATE_TIME, UPDATE_BY, UPDATE_TIME FROM supreme_user.m_material_group;


REPLACE INTO supreme_dashboard.m_user (ID_USER, USERNAME, EMAIL, PASSWORD, NAME, COMPANY, ID_DEPARTMENT, COST_CENTER, CONTACT, IMG, ROLES, STATUS, CREATE_BY, CREATE_TIME, UPDATE_BY, UPDATE_TIME)
SELECT ID_USER, USERNAME, EMAIL, PASSWORD, NAME, COMPANY, ID_DEPARTMENT, COST_CENTER, CONTACT, IMG, ROLES, STATUS, CREATE_BY, CREATE_TIME, UPDATE_BY, UPDATE_TIME
FROM supreme_user.m_user ;


REPLACE INTO supreme_dashboard. m_user_roles (ID_USER_ROLES, DESCRIPTION, MENU, STATUS, CREATE_BY, CREATE_TIME, UPDATE_BY, UPDATE_TIME)
SELECT ID_USER_ROLES, DESCRIPTION, MENU, STATUS, CREATE_BY, CREATE_TIME, UPDATE_BY, UPDATE_TIME 
FROM supreme_user.m_user_roles;


REPLACE INTO supreme_dashboard.m_costcenter (ID_COMPANY, ID_COSTCENTER, COSTCENTER_DESC, COSTCENTER_ABR, STATUS, CREATE_BY, CREATE_ON, CHANGED_BY, CHANGED_ON)
SELECT ID_COMPANY, ID_COSTCENTER, COSTCENTER_DESC, COSTCENTER_ABR, STATUS, CREATE_BY, CREATE_ON, CHANGED_BY, CHANGED_ON FROM
supreme_user.m_costcenter;


REPLACE INTO supreme_dashboard.m_departement (ID_COMPANY, ID_DEPARTMENT, DEPARTMENT_DESC, DEPARTMENT_ABR, STATUS, CREATE_BY, CREATE_ON, CHANGED_BY, CHANGED_ON)
SELECT ID_COMPANY, ID_DEPARTMENT, DEPARTMENT_DESC, DEPARTMENT_ABR, STATUS, CREATE_BY, CREATE_ON, CHANGED_BY, CHANGED_ON
FROM supreme_user.m_departement;


REPLACE INTO supreme_dashboard.sync_mutasi_stock (ID, DOC_ID, DOC_NO, DATED, SEMIC_NO, DOC, UOM, QTY, LINE_NUMBER, BRACH_PLANT, UNIT_PRICE, TOTAL, CREATED, CREATED_DATE)
SELECT ID, DOC_ID, DOC_NO, DATED, SEMIC_NO, DOC, UOM, QTY, LINE_NUMBER, BRACH_PLANT, UNIT_PRICE, TOTAL, CREATED, CREATED_DATE FROM
supreme_user.sync_mutasi_stock;


REPLACE INTO supreme_dashboard.sync_receipt (DATED, DATE_REC, DATE_PROMDEV, DATE_REQ, INV_NO, AGG_NO, LINE_NUMBER, SEMIC_NO, BUS_UNIT, LOC, PAY_STATUS, COMPANY, AMT_REC, CURR, TYPE_MATCH, QTY_ORD, DOC_TYPE, UOM, CREATE_DATE, CREATOR, ID) 
SELECT DATED, DATE_REC, DATE_PROMDEV, DATE_REQ, INV_NO, AGG_NO, LINE_NUMBER, SEMIC_NO, BUS_UNIT, LOC, PAY_STATUS, COMPANY, AMT_REC, CURR, TYPE_MATCH, QTY_ORD, DOC_TYPE, UOM, CREATE_DATE, CREATOR, ID 
FROM supreme_user.sync_receipt;

REPLACE INTO supreme_dashboard.t_material_request (request_no, company_code, departement, document_type, purpose_of_request, request_date, account, account_desc, branch_plant, to_branch_plant, from_company, to_company, intrans_no, intrans_user, wo_reason, inspection, asset_valuation, asset_type, disposal_method, justification_disposal_method, disposal_value, disposal_cost, disposal_value_curr, disposal_cost_curr, isclosed, busines_unit, update_by, update_date, create_date, create_by)
SELECT request_no, company_code, departement, document_type, purpose_of_request, request_date, account, account_desc, branch_plant, to_branch_plant, from_company, to_company, intrans_no, intrans_user, wo_reason, inspection, asset_valuation, asset_type, disposal_method, justification_disposal_method, disposal_value, disposal_cost, disposal_value_curr, disposal_cost_curr, isclosed, busines_unit, update_by, update_date, create_date, create_by FROM supreme_user.t_material_request;



REPLACE INTO supreme_dashboard.t_material_request_item (request_no, semic_no, item_desc, uom, qty, qty_act, qty_avl, location, to_location, currency, unit_cost, to_unit_cost, extended_ammount, to_extended_ammount, branch_plant, to_branch_plant, account, account_desc, acq_year, acq_value, book_value, category, material_status, busines_unit, remark)
SELECT request_no, semic_no, item_desc, uom, qty, qty_act, qty_avl, location, to_location, currency, unit_cost, to_unit_cost, extended_ammount, to_extended_ammount, branch_plant, to_branch_plant, account, account_desc, acq_year, acq_value, book_value, category, material_status, busines_unit, remark
FROM supreme_user.t_material_request_item;

INSERT INTO supreme_dashboard.t_approval_material_request (id, id_mr, id_user, user_roles, sequence, status_approve, description, reject_step, email_approve, email_reject, edit_content, extra_case, note, approve_by, updatedate,createdate)
SELECT id, id_mr, id_user, user_roles, sequence, status_approve, description, reject_step, email_approve, email_reject, edit_content, extra_case, note, approve_by, updatedate,createdate
FROM supreme_user.t_approval_material_request;
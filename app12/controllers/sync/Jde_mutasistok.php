<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jde_mutasistok extends CI_Controller {

    public function __construct() {
        parent::__construct();

    }


    public function getData() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_mutstok'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select
		mt.ILUNCS/10000 as UNITPRICE,mt.ilpaid/100 as TOTAL,mt.ILDOC||'-'||mt.ILLNID as DOC_ID,mt.ILDOC as DOC_NO,mt.ILLNID as LINE_NUMBER,mt.ILTRUM as UOM,mt.ILTRQT as QTY,trim(mt.ILMCU) as BRANCHPLANT,mt.ILLITM as SEMICNO,mt.ILDCT as DOC,
		TO_CHAR(TO_DATE(TO_CHAR(mt.ILTRDJ+1900000),'YYYYDDD'),'YYYY-MM-DD') as DATED,
		TO_CHAR(TO_DATE(TO_CHAR(mt.ILCRDJ+1900000),'YYYYDDD'),'YYYY-MM-DD') CREATED
		 from f4111 mt
		join F4101 i on i.IMLITM=mt.ILLITM
		where TO_CHAR(TO_DATE(TO_CHAR(mt.ILTRDJ+1900000),'YYYYDDD'),'YYYY-MM-DD') between '".$dated."' AND TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD')");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->load->model('sync/M_temp_mutasi_stock');
            $this->M_temp_mutasi_stock->deleteAll();
            foreach ($result_check as $data) {

				$ms = array(
			      'DOC_ID' => $data["DOC_ID"],
			      'DOC_NO' => $data["DOC_NO"],
			      'DATED' => $data["DATED"],
			      'CREATED_DATE' => date("Y-m-d H:i:s"),
			      'SEMIC_NO' => $data["SEMICNO"],
			      'DOC' => $data['DOC'],
			      'UOM' => $data['UOM'],
			      'QTY' => $data['QTY'],
			      'LINE_NUMBER' => $data['LINE_NUMBER'],
			      'BRACH_PLANT' => $data['BRANCHPLANT'],
			      'UNIT_PRICE' => $data['UNITPRICE'],
			      'TOTAL' => $data['TOTAL'],
			      'CREATED' => $data['CREATED'],
			    );
			    $this->db->insert('temp_mutasi_stock', $ms);


            }

            	    $query = $this->db->query("INSERT INTO sync_mutasi_stock(ID,DOC_ID, DOC_NO, DATED, SEMIC_NO, DOC, UOM, QTY, LINE_NUMBER, BRACH_PLANT, UNIT_PRICE, TOTAL,CREATED) SELECT NULL,DOC_ID, DOC_NO, DATED, SEMIC_NO, DOC, UOM, QTY, LINE_NUMBER, BRACH_PLANT, UNIT_PRICE, TOTAL,CREATED FROM temp_mutasi_stock WHERE DOC_ID not in (SELECT distinct DOC_ID FROM sync_mutasi_stock)");

			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_mutstok';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}


	public function getDataReceipt() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_receipt'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select
		TO_CHAR(TO_DATE(TO_CHAR(PRTRDJ+1900000),'YYYYDDD'),'YYYY-MM-DD') as DATED,CASE WHEN TO_CHAR(PRRCDJ+1900000)='1900000' THEN NULL ELSE TO_CHAR(TO_DATE(TO_CHAR(PRRCDJ+1900000),'YYYYDDD'),'YYYY-MM-DD') END  as DATE_REC,TO_CHAR(TO_DATE(TO_CHAR(PROPDJ+1900000),'YYYYDDD'),'YYYY-MM-DD')  as DATE_PROMDEV ,TO_CHAR(TO_DATE(TO_CHAR(PRDRQJ+1900000),'YYYYDDD'),'YYYY-MM-DD')  as DATE_REQ,
		PRDOCO as INV_NO, PRDOC as AGG_NO, PRLNID as LINE_NUMBER,
		PRLITM as SEMIC_NO, PRMCU as BUS_UNIT, PRLOCN as LOC,
		PRPST as PAY_STATUS, PRCO as COMPANY, PRAREC as AMT_REC, PRCRCD as CURR,
		PRMATC as TYPE_MATCH, PRUORG as QTY_ORD, PRDCT as DOC_TYPE, PRUOM as UOM,PRUSER as CREATOR from f43121 where TO_CHAR(TO_DATE(TO_CHAR(PRRCDJ+1900000),'YYYYDDD'),'YYYY-MM-DD') between '".$dated."' AND TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD') ");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->load->model('sync/M_temp_sync_receipt');
            $this->M_temp_sync_receipt->deleteAll();
            foreach ($result_check as $data) {

				$ms = array(
			      'DATED' => $data["DATED"],
			      'DATE_REC' => $data["DATE_REC"],
			      'DATE_PROMDEV' => $data['DATE_PROMDEV'],
			      'DATE_REQ' => $data['DATE_REQ'],
			      'INV_NO' => $data['INV_NO'],
			      'AGG_NO' => $data['AGG_NO'],
			      'LINE_NUMBER' => $data['LINE_NUMBER'],
			      'SEMIC_NO' => $data['SEMIC_NO'],
			      'BUS_UNIT' => $data['BUS_UNIT'],
			      'LOC' => $data['LOC'],
			      'PAY_STATUS' => $data['PAY_STATUS'],
			      'COMPANY' => $data['COMPANY'],
			      'AMT_REC' => $data['AMT_REC'],
			      'CURR' => $data['CURR'],
			      'TYPE_MATCH' => $data['TYPE_MATCH'],
			      'QTY_ORD' => $data['QTY_ORD'],
			      'DOC_TYPE' => $data['DOC_TYPE'],
			      'UOM' => $data['UOM'],
			      'CREATOR' => $data['CREATOR'],
			      'CREATE_DATE' => date("Y-m-d H:i:s"),
			    );
			    $this->db->insert('temp_sync_receipt', $ms);


            }

             $query = $this->db->query("INSERT INTO `sync_receipt` (`DATED`, `DATE_REC`, `DATE_PROMDEV`, `DATE_REQ`, `INV_NO`, `AGG_NO`, `LINE_NUMBER`, `SEMIC_NO`, `BUS_UNIT`, `LOC`, `PAY_STATUS`, `COMPANY`, `AMT_REC`, `CURR`, `TYPE_MATCH`, `QTY_ORD`, `DOC_TYPE`, `UOM`, `CREATE_DATE`, `ID`,CREATOR) SELECT `DATED`, `DATE_REC`, `DATE_PROMDEV`, `DATE_REQ`, `INV_NO`, `AGG_NO`, `LINE_NUMBER`, `SEMIC_NO`, `BUS_UNIT`, `LOC`, `PAY_STATUS`, `COMPANY`, `AMT_REC`, `CURR`, `TYPE_MATCH`, `QTY_ORD`, `DOC_TYPE`, `UOM`, `CREATE_DATE`, NULL,CREATOR FROM temp_sync_receipt WHERE INV_NO NOT IN (SELECT DISTINCT INV_NO FROM sync_receipt)");

			echo "Sync at ".date("Y-m-d H:i:s");
        }
        echo "Execution at ".date("Y-m-d H:i:s");
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_receipt';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataCostCenter() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_cost'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select MCMCU as COST_CENTER,MCCO as COMPANY,MCDL01 as DESCRIPTION from F0006 where MCCO in (10101,10102,10103) and MCLDM !=1  AND MCPECC=' '  AND MCSTYL IN ('IS','PJ') ");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->load->model('sync/M_temp_mutasi_cost');
            $this->M_temp_mutasi_cost->deleteAll();
            foreach ($result_check as $data) {

				$ms = array(
			      'COST_CENTER' => $data["COST_CENTER"],
			      'COMPANY' => $data["COMPANY"],
			      'DESCRIPTION' => str_replace("'", "", $data["DESCRIPTION"]),
			      'CREATED_DATE' => date("Y-m-d H:i:s")
			    );
			    $this->db->insert('temp_cost_center', $ms);


            }

            $query = $this->db->query("INSERT INTO `sync_cost_center` (`id`,`COMPANY`, `COST_CENTER`, `DESCRIPTION`, `CREATED_DATE`) SELECT  NULL,TRIM(COMPANY),TRIM(COST_CENTER),DESCRIPTION,CREATED_DATE FROM temp_cost_center where CONCAT(TRIM(COST_CENTER),TRIM(COMPANY)) not in ( select CONCAT(TRIM(COST_CENTER),TRIM(COMPANY)) FROM sync_cost_center) ");

			    $query = $this->db->query("INSERT INTO `m_costcenter`  (`ID_COMPANY`, `ID_COSTCENTER`, `COSTCENTER_DESC`, `COSTCENTER_ABR`, `STATUS`, `CREATE_BY`, `CREATE_ON`, `CHANGED_BY`, `CHANGED_ON`) SELECT  DISTINCT TRIM(COMPANY),TRIM(COST_CENTER),DESCRIPTION,'',1,1,NOW(),1,NOW() FROM sync_cost_center where TRIM(COST_CENTER) NOT in (SELECT TRIM(ID_COSTCENTER) FROM m_costcenter ) ");

			    $query = $this->db->query("update m_costcenter set STATUS=0 WHERE TRIM(ID_COSTCENTER) NOT IN
					(
					select DISTINCT TRIM(COST_CENTER) from temp_cost_center
					) ");

			    $query = $this->db->query("update m_costcenter set STATUS=1 WHERE TRIM(ID_COSTCENTER) IN
					(
					select DISTINCT TRIM(COST_CENTER) from temp_cost_center
					) ");

			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_cost';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataAccSub() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_acc'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select TRIM(GMMCU) as COST_CENTER,GMOBJ as ACC_OBJ,GMSUB as ACC_SUB,GMDL01 as DESCRIPTION,GMPEC as POSTING  from F0901 where GMCO  in (10101,10102,10103) AND GMOBJ>7100 AND GMPEC IN ('L', 'S', ' ') ");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->load->model('sync/M_temp_mutasi_accsubs');
            $this->M_temp_mutasi_accsubs->deleteAll();
            $query = $this->db->query("ALTER TABLE temp_acc_subs AUTO_INCREMENT = 1 ");
            foreach ($result_check as $data) {

				$ms = array(
			      'ACC_SUB' => TRIM($data["ACC_SUB"]),
			      'POSTING' => TRIM($data["POSTING"]),
			      'COST_CENTER' => TRIM($data["COST_CENTER"]),
			      'ACC_OBJ' => TRIM($data["ACC_OBJ"]),
			      'DESCRIPTION' => str_replace("'", "", $data["DESCRIPTION"]),
			      'CREATED_DATE' => date("Y-m-d H:i:s")
			    );
			    $this->db->insert('temp_acc_subs', $ms);

			    /*$query = $this->db->query("UPDATE m_accsub  set POSTING='".TRIM($data["POSTING"])."',STATUS=1,CHANGED_ON=NOW() WHERE ID_ACCSUB=CONCAT('".TRIM($data["ACC_OBJ"])."','-','".TRIM($data["ACC_SUB"])."') AND COSTCENTER='".TRIM($data["COST_CENTER"])."'  ");*/
            }

            /*$query = $this->db->query("ALTER TABLE sync_acc_subs AUTO_INCREMENT = 1 ");
            $query = $this->db->query("DELETE FROM sync_acc_subs");

            $query = $this->db->query("INSERT INTO `sync_acc_subs` (`id`, `COST_CENTER`, `ACC_OBJ`, `ACC_SUB`, `DESCRIPTION`, `CREATED_DATE`,`POSTING`) SELECT  NULL,TRIM(COST_CENTER),TRIM(ACC_OBJ),TRIM(ACC_SUB),DESCRIPTION,CREATED_DATE,TRIM(POSTING) FROM temp_acc_subs  ");*/

		    $query = $this->db->query("INSERT INTO `m_accsub` (`COMPANY`,`POSTING`, `COSTCENTER`, `ID_ACCSUB`, `ACCSUB_DESC`, `STATUS`, `CREATE_BY`, `CREATE_ON`, `CHANGED_BY`, `CHANGED_ON`) SELECT  DISTINCT LEFT(COST_CENTER,5),`POSTING`,COST_CENTER,CONCAT(ACC_OBJ,'-',ACC_SUB),DESCRIPTION,1,1,NOW(),1,NOW() FROM temp_acc_subs where ACC_SUB!='' AND CONCAT(COST_CENTER,ACC_OBJ,'-',ACC_SUB) NOT in (SELECT CONCAT(COSTCENTER,ID_ACCSUB) FROM m_accsub ) ");


		    $query = $this->db->query("update m_accsub set STATUS=1,CHANGED_ON=NOW() WHERE CONCAT(COSTCENTER,ID_ACCSUB) IN
				(
				select DISTINCT CONCAT(COST_CENTER,ACC_OBJ,'-',ACC_SUB) from temp_acc_subs
				) ");
		    $query = $this->db->query("update m_accsub set STATUS=0,CHANGED_ON=NOW() WHERE CONCAT(COSTCENTER,ID_ACCSUB) NOT IN
				(
				select DISTINCT CONCAT(COST_CENTER,ACC_OBJ,'-',ACC_SUB) from temp_acc_subs
				) ");
			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_acc';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataDMAAI() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_dmaai'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;

		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select DISTINCT MLCO as COMPANY, MLGLPT as GLCLASS, MLOBJ as ACC_OBJ, MLSUB as ACC_SUB from F4095 where MLANUM = 4124 and mldct = 'II' ");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->load->model('sync/M_temp_dmaai');
            $this->M_temp_dmaai->deleteAll();
            foreach ($result_check as $data) {

				$ms = array(
			      'COMPANY' => $data["COMPANY"],
			      'ACC_SUB' => $data["ACC_SUB"],
			      'COMPANY' => $data["COMPANY"],
			      'ACC_OBJ' => $data["ACC_OBJ"],
			      'GLCLASS' => str_replace("'", "", $data["GLCLASS"]),
			      'CREATED_DATE' => date("Y-m-d H:i:s")
			    );
			    $this->db->insert('temp_dmaai', $ms);
            }
            	    $query = $this->db->query("INSERT INTO `sync_dmaai` ( `COMPANY`, `ACC_SUB`, `ACC_OBJ`, `GLCLASS`, `CREATED_DATE`) SELECT  DISTINCT COMPANY,TRIM(ACC_SUB),TRIM(ACC_OBJ),TRIM(GLCLASS),NOW() FROM temp_dmaai where CONCAT(TRIM(ACC_SUB),TRIM(ACC_OBJ),TRIM(GLCLASS)) NOT in (SELECT CONCAT(TRIM(ACC_SUB),TRIM(ACC_OBJ),TRIM(GLCLASS)) FROM sync_dmaai ) ");
			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_dmaai';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataItemCost() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_itc'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("Select COITM as MATERIAL_ID,COLITM as SEMIC, COMCU as BRANCH_PLANT, (COUNCS/10000) as ITEM_COST from F4105 where COMCU like  '%1010%' and COLEDG = '02' AND LENGTH(TRIM(COMCU))>6 AND COUNCS>0 ");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->load->model('sync/M_temp_item_cost');
            $this->M_temp_item_cost->deleteAll();
            foreach ($result_check as $data) {

				$ms = array(
			      'MATERIAL_ID' => trim($data["MATERIAL_ID"]),
			      'SEMIC' => trim($data["SEMIC"]),
			      'BRANCH_PLANT' => trim($data["BRANCH_PLANT"]),
			      'ITEM_COST' => $data["ITEM_COST"],
			      'CREATED_DATE' => date("Y-m-d H:i:s")
			    );
			    $this->db->insert('temp_item_cost', $ms);

			    $query = $this->db->query("UPDATE `sync_item_cost`  set ITEM_COST=".$data["ITEM_COST"]." WHERE BRANCH_PLANT='".trim($data["BRANCH_PLANT"])."' AND SEMIC='".trim($data["SEMIC"])."'  AND MATERIAL_ID='".trim($data["MATERIAL_ID"])."' ");
            }

            $query = $this->db->query("DELETE FROM `sync_item_cost` where CONCAT(TRIM(BRANCH_PLANT),TRIM(SEMIC),TRIM(MATERIAL_ID)) not in ( select CONCAT(TRIM(BRANCH_PLANT),TRIM(SEMIC),TRIM(MATERIAL_ID)) FROM temp_item_cost) ");

            $query = $this->db->query("INSERT INTO `sync_item_cost` (`MATERIAL_ID`,`BRANCH_PLANT`, `SEMIC`, `ITEM_COST`, `CREATED_DATE`) SELECT TRIM(MATERIAL_ID),TRIM(BRANCH_PLANT),TRIM(SEMIC),TRIM(ITEM_COST),CREATED_DATE FROM temp_item_cost where CONCAT(TRIM(BRANCH_PLANT),TRIM(SEMIC),TRIM(MATERIAL_ID)) not in ( select CONCAT(TRIM(BRANCH_PLANT),TRIM(SEMIC),TRIM(MATERIAL_ID)) FROM sync_item_cost) ");


			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_itc';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataItemAvl() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_avl'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("Select DISTINCT LIITM as MATERIAL_ID, LIMCU as BRANCH_PLANT, LILOCN as LOCATION, LIPBIN as LOCATION_TYPE, LIPQOH as QTY from F41021 WHERE LENGTH(TRIM(LIMCU))>5 ");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->load->model('sync/M_temp_item_available');
            $this->M_temp_item_available->deleteAll();
            foreach ($result_check as $data) {

				$ms = array(
			      'MATERIAL_ID' => trim($data["MATERIAL_ID"]),
			      'BRANCH_PLANT' => trim($data["BRANCH_PLANT"]),
			      'LOCATION' => trim($data["LOCATION"]),
			      'LOCATION_TYPE' => trim($data["LOCATION_TYPE"]),
			      'QTY' => $data["QTY"],
			      'CREATED_DATE' => date("Y-m-d H:i:s")
			    );
			    $this->db->insert('temp_item_available', $ms);


			    $query = $this->db->query("DELETE FROM `sync_item_available`  WHERE TRIM(BRANCH_PLANT)='".trim($data["BRANCH_PLANT"])."' AND TRIM(MATERIAL_ID)='".trim($data["MATERIAL_ID"])."' ");
			    $query = $this->db->query("DELETE FROM `sync_item_available_history`  WHERE CREATED_DATE=CURRENT_DATE() AND TRIM(BRANCH_PLANT)='".trim($data["BRANCH_PLANT"])."' AND TRIM(MATERIAL_ID)='".trim($data["MATERIAL_ID"])."' ");
            }
            $query = $this->db->query("INSERT INTO `sync_item_available` (`BRANCH_PLANT`, `MATERIAL_ID`, `LOCATION`,`LOCATION_TYPE`,`QTY`, `CREATED_DATE`) SELECT  TRIM(BRANCH_PLANT),TRIM(MATERIAL_ID),TRIM(LOCATION),TRIM(LOCATION_TYPE),TRIM(QTY),NOW() FROM temp_item_available where CONCAT(TRIM(BRANCH_PLANT),TRIM(MATERIAL_ID),TRIM(LOCATION_TYPE),TRIM(LOCATION)) not in ( select CONCAT(TRIM(BRANCH_PLANT),TRIM(MATERIAL_ID),TRIM(LOCATION_TYPE),TRIM(LOCATION)) FROM sync_item_available) ");
            $query = $this->db->query("INSERT INTO `sync_item_available_history` (`BRANCH_PLANT`, `MATERIAL_ID`, `LOCATION`,`LOCATION_TYPE`,`QTY`, `CREATED_DATE`) SELECT  TRIM(BRANCH_PLANT),TRIM(MATERIAL_ID),TRIM(LOCATION),TRIM(LOCATION_TYPE),TRIM(QTY),CURRENT_DATE() FROM temp_item_available where CONCAT(TRIM(BRANCH_PLANT),TRIM(MATERIAL_ID),TRIM(LOCATION_TYPE),TRIM(LOCATION),TRIM(CREATED_DATE)) not in ( select CONCAT(TRIM(BRANCH_PLANT),TRIM(MATERIAL_ID),TRIM(LOCATION_TYPE),TRIM(LOCATION),TRIM(CREATED_DATE)) FROM sync_item_available_history) ");

			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_avl';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}


	public function getDataGLCLASS() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_gl_class'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("Select DRKY as CODE,DRDL02 as DESCRIPTION,drdl01 as VAT from CRPCTL.F0005 where drrt = 'GL' and DRSY='57'");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->db->query("delete from temp_gl_class");
            foreach ($result_check as $data) {

				$ms = array(
			      'code' => trim($data["CODE"]),
			      'description' => trim($data["DESCRIPTION"]),
			      'vat' => trim($data["VAT"])
			    );
			    $this->db->insert('temp_gl_class', $ms);
			    $query = $this->db->query("UPDATE m_gl_class set description='".trim($data["DESCRIPTION"])."',update_date=now(),vat='".trim($data["VAT"])."' WHERE code='".trim($data["CODE"])."' ");

            }
    	    $query = $this->db->query("INSERT INTO m_gl_class (id, code, description, create_date, create_by, update_date, update_by, status,vat) SELECT NULL,code,description,now(),1,now(),1,1,vat from temp_gl_class where code not in (select code from m_gl_class)");

			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_gl_class';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataUOM() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_uom'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select DRKY as CODE,DRDL01 as DESCRIPTION from CRPCTL.f0005 where  DRRT='UM' AND DRSY='00' AND DRKY<>' ' ");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->db->query("delete from temp_uom");
            foreach ($result_check as $data) {

				$ms = array(
			      'code' => trim($data["CODE"]),
			      'description' => trim($data["DESCRIPTION"])
			    );
			    $this->db->insert('temp_uom', $ms);
			    $query = $this->db->query("UPDATE m_material_uom set description='".trim($data["DESCRIPTION"])."',update_time=now() WHERE MATERIAL_UOM='".trim($data["CODE"])."' ");

            }
    	    $query = $this->db->query("INSERT INTO `m_material_uom` (`ID`, `MATERIAL_UOM`, `DESCRIPTION`, `STATUS`, `UOM_TYPE`, `CREATE_BY`, `CREATE_TIME`, `UPDATE_BY`, `UPDATE_TIME`) SELECT NULL,code,description,1,1,1,now(),1,now() from temp_uom where code not in (select MATERIAL_UOM from m_material_uom) ");

    	    $query = $this->db->query("UPDATE m_material_uom SET STATUS=0 where MATERIAL_UOM not in (select code from temp_uom) ");

			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_uom';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataReceiptAgreement() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT COALESCE(DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d'),CURRENT_DATE) as dated FROM `i_sync_log` where script_type='agg_val'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
			$query_check_out = $this->db->query("SELECT PDDOCO||'-'||PDDCTO||'-'||PDKCOO as DOC_NO, 
			PDLITM as SEMIC,
			PDDSC1 as DESCRIPTION,
			PDLNID as LINE_NO,
			PDUOM as UOM, 
			PDUOPN as QTY_OPN, 
			PDUREC QTY_REC, 
			PDCRCD as CURRENCY,
			PDAOPN as AMOUNT_OPN, 
			PDAREC as AMOUNT_REC FROM  crpdta.F4311 where 
		TO_CHAR(TO_DATE(TO_CHAR(PDUPMJ+1900000),'YYYYDDD'),'YYYY-MM-DD') between '".$dated."' AND TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD')");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $this->db->query("delete from temp_agg_val");
            foreach ($result_check as $data) {

				$ms = array(
			      'doc_no' => trim($data["DOC_NO"]),
			      'line_no' => trim($data["LINE_NO"]),
			      'uom' => trim($data["UOM"]),
			      'qty_open' => trim($data["QTY_OPN"]),
			      'qty_rec' => trim($data["QTY_REC"]),
			      'currency' => trim($data["CURRENCY"]),

			      'amount_open' => trim($data["AMOUNT_OPN"]),
			      'amount_receipt' => trim($data["AMOUNT_REC"])
			    );
			    $this->db->insert('temp_agg_val', $ms);
			    $query = $this->db->query("UPDATE sync_agg_val set qty_open='".trim($data["QTY_OPN"])."',currency='".trim($data["AMOUNT_REC"])."',amount_open='".trim($data["AMOUNT_OPN"])."',currency='".trim($data["CURRENCY"])."',qty_rec='".trim($data["QTY_REC"])."',update_time=now() WHERE DOC_NO='".trim($data["DOC_NO"])."' and LINE_NO='".trim($data["LINE_NO"])."' ");

            }
    	    $query = $this->db->query("REPLACE INTO sync_agg_val (doc_no,line_no,uom,qty_open,qty_rec,currency,amount_open,amount_receipt, create_by, create_time, update_by, update_time) SELECT doc_no,line_no,uom,qty_open,qty_rec,currency,amount_open,amount_receipt,1,now(),1,now() from temp_agg_val ");

			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_aggval';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataExchangeRate() {
    	/*ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_ext'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;


		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select m.CXCRCD as CUR_FROM ,m.CXCRDC as CUR_TO ,m.CXCRRD as EXC from F0015 m
		JOIN (select CXCRCD,CXCRDC,MAX(CXEFT) as CXEFT from F0015 WHERE CXAN8=0 GROUP BY CXCRCD,CXCRDC) a on a.CXCRCD=m.CXCRCD and a.CXCRDC=m.CXCRDC AND a.CXEFT=m.CXEFT
		 WHERE CXAN8=0");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $query = $this->db->query("DELETE FROM temp_exc_rate");
            foreach ($result_check as $data) {

				$ms = array(
			      'CUR_FROM' => trim($data["CUR_FROM"]),
			      'CUR_TO' => trim($data["CUR_TO"]),
			      'EXC' => trim($data["EXC"]),
			      'CREATED_DATE' => date("Y-m-d H:i:s")
			    );
			    $this->db->insert('temp_exc_rate', $ms);

			    $query = $this->db->query("DELETE FROM `sync_exc_rate`  WHERE CUR_TO='".trim($data["CUR_TO"])."' AND CUR_FROM='".trim($data["CUR_FROM"])."'  ");
            }

            $query = $this->db->query("INSERT INTO `sync_exc_rate` (`CUR_TO`,`CUR_FROM`, `EXC`, `CREATED_DATE`) SELECT TRIM(CUR_TO),TRIM(CUR_FROM),TRIM(EXC),TRIM(CREATED_DATE) FROM temp_exc_rate WHERE  CONCAT(TRIM(CUR_TO),TRIM(CUR_FROM)) not in ( select CONCAT(TRIM(CUR_TO),TRIM(CUR_FROM)) FROM sync_exc_rate) ");

            $query_update_exc = $this->db->query("select c.ID as ID_FROM,d.ID as ID_TO,s.CUR_FROM,EXC as EXC_FROM,s.CUR_TO, 1 as EXC_TO,CREATED_DATE from sync_exc_rate s
				join m_currency c on c.CURRENCY=s.CUR_FROM
				join m_currency d on d.CURRENCY=s.CUR_TO");

            $result_check_exc = $query_update_exc->result_array();

            foreach ($result_check_exc as $datas) {
            	$query = $this->db->query(" delete from m_exchange_rate WHERE currency_from='".trim($datas["ID_FROM"])."' and currency_to='".trim($datas["ID_TO"])."' ");
			    $query = $this->db->query(" update m_exchange_rate set valid_to=CURRENT_DATE WHERE currency_from='".trim($datas["ID_FROM"])."' and currency_to='".trim($datas["ID_TO"])."' and valid_to>CURRENT_DATE ");
			    $query = $this->db->query("INSERT INTO m_exchange_rate (id,currency_from, currency_to,amount_from,amount_to,valid_from, valid_to) VALUES (NULL, '".trim($datas["ID_FROM"])."', '".trim($datas["ID_TO"])."', '".trim($datas["EXC_FROM"])."', '".trim($datas["EXC_TO"])."', CURRENT_DATE, DATE_ADD(CURRENT_DATE,interval 360 day))  ");
            }


			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_exc';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();*/
	}

	public function getDataCycleCount() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_cc'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;

		//QTY_OND,VAL_OND,QTY_CTD,VAL_CTD,UNIT_COST,SEMIC,COST_CENTER,DOC_NO,DESCRIPTION,START_DATE,COUNT_QTY,COUNT_LOC,CREATOR
		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select d.PJTQOH as QTY_OND,d.PJTAOH as VAL_OND,d.PJTQCT as QTY_CTD,d.PJTACT as VAL_CTD,d.PJUNCS as UNIT_COST,d.PJLITM as SEMIC,d.PJMCU as COST_CENTER,m.PICYNO as DOC_NO,m.PIDSC1 as DESCRIPTION,TO_CHAR(TO_DATE(TO_CHAR(m.PICSDJ+1900000),'YYYYDDD'),'YYYY-MM-DD') as START_DATE,m.PICYIT COUNT_QTY,d.PJLOCN as COUNT_LOC,m.PIUSER as CREATOR
		from F4140 m JOIN F4141 d on d.PJCYNO=m.PICYNO WHERE m.PICYCS=50");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $query = $this->db->query("DELETE FROM temp_cycle_count");
            foreach ($result_check as $data) {

				$ms = array(
				  'QTY_OND' => trim($data["QTY_OND"]),
				  'VAL_OND' => trim($data["VAL_OND"]),
				  'QTY_CTD' => trim($data["QTY_CTD"]),
				  'UNIT_COST' => trim($data["UNIT_COST"]),
				  'SEMIC' => trim($data["SEMIC"]),
				  'COST_CENTER' => trim($data["COST_CENTER"]),
				  'DOC_NO' => trim($data["DOC_NO"]),
				  'DESCRIPTION' => trim($data["DESCRIPTION"]),
				  'START_DATE' => trim($data["START_DATE"]),
				  'COUNT_QTY' => trim($data["COUNT_QTY"]),
				  'COUNT_LOC' => trim($data["COUNT_LOC"]),
				  'CREATOR' => trim($data["CREATOR"]),
				  'VAL_CTD' => trim($data["VAL_CTD"])
			    );
			    $this->db->insert('temp_cycle_count', $ms);

			    //$query = $this->db->query("DELETE FROM `sync_cycle_count`  WHERE DOC_NO='".trim($data["DOC_NO"])."' AND CUR_FROM='".trim($data["CUR_FROM"])."'  ");
            }

            $query = $this->db->query("INSERT INTO `sync_cycle_count` (QTY_OND,VAL_OND,QTY_CTD,VAL_CTD,UNIT_COST,SEMIC,COST_CENTER,DOC_NO,DESCRIPTION,START_DATE,COUNT_QTY,COUNT_LOC,CREATOR) SELECT QTY_OND,VAL_OND,QTY_CTD,VAL_CTD,UNIT_COST,SEMIC,COST_CENTER,DOC_NO,DESCRIPTION,START_DATE,COUNT_QTY,COUNT_LOC,CREATOR FROM temp_cycle_count WHERE DOC_NO not in ( select DOC_NO FROM sync_cycle_count) ");
			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_cc';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

	public function getDataInvoice() {
    	ini_set('max_execution_time', 300);
    	$this->db = $this->load->database('default', true);
		$query_check_out = $this->db->query("SELECT DATE_FORMAT(subdate(max(execute_time),2),'%Y-%m-%d') as dated FROM `i_sync_log` where script_type='sync_inv'");
		$result_check = $query_check_out->result();
		$dated = $result_check[0]->dated;

		$this->db = $this->load->database('oracle', true);
		$query_check_out = $this->db->query("select RPKCO||RPDOC||RPDCT||RPSFX||RPSFXE as DOC_NO,RPPO as DOC_PO,RPAG as TOTAL,RPPST as PAID_STATUS,RPCO as ID_COMPANY,TO_CHAR(TO_DATE(TO_CHAR(RPDIVJ+1900000),'YYYYDDD'),'YYYY-MM-DD') as CREATED_DATE from F0411  WHERE RPPST='P' AND RPCO in ('10101','10102','10103')");

        if($query_check_out->num_rows()>0){
            $result_check = $query_check_out->result_array();

            $this->db = $this->load->database('default', true);
            $query = $this->db->query("DELETE FROM temp_inv");
            foreach ($result_check as $data) {

				$ms = array(
				  'DOC_NO' => trim($data["DOC_NO"]),
				  'DOC_PO' => trim($data["DOC_PO"]),
				  'TOTAL' => trim($data["TOTAL"]),
				  'PAID_STATUS' => trim($data["PAID_STATUS"]),
				  'ID_COMPANY' => trim($data["ID_COMPANY"]),
				  'CREATED_DATE' => trim($data["CREATED_DATE"])
			    );
			    $this->db->insert('temp_inv', $ms);

			    //$query = $this->db->query("DELETE FROM `sync_cycle_count`  WHERE DOC_NO='".trim($data["DOC_NO"])."' AND CUR_FROM='".trim($data["CUR_FROM"])."'  ");
            }

            $query = $this->db->query("INSERT INTO `sync_inv` (DOC_NO,DOC_PO,TOTAL,PAID_STATUS,ID_COMPANY,CREATED_DATE) SELECT DOC_NO,DOC_PO,TOTAL,PAID_STATUS,ID_COMPANY,CREATED_DATE FROM temp_inv WHERE DOC_NO not in ( select DOC_NO FROM sync_inv) ");
			echo "Sync at ".date("Y-m-d H:i:s");
        }
		$this->db = $this->load->database('default', true);
		$data_log['script_type'] = 'sync_inv';
		$this->db->insert('i_sync_log',$data_log);
		$this->db->close();
	}

}

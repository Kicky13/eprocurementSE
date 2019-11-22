<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP130001/"><soapenv:Header><wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" soapenv:mustUnderstand="1"> <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"> <wsse:Username>BSV01</wsse:Username><wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">interop</wsse:Password> </wsse:UsernameToken>
   </wsse:Security>
</soapenv:Header>
   <soapenv:Body>
      <orac:processEquipmentWorkOrder>
         <accounting>
            <!--Optional:-->
            <businessUnit>10101WH02</businessUnit>
            <!--Optional:-->
         </accounting>
         <!--Optional:-->
         <assetNumber>*<?= $fanumb ?></assetNumber>
         <!--Optional:-->
         <classification>
            <categoryCodes>
               <categoryCode002>.</categoryCode002>             
               <categoryCode003><?=$maintenance_activity_type?></categoryCode003>
               <phase>.</phase>
            </categoryCodes>
         </classification> 
         <description><?= trim($wr_description) ?></description>
         <!--Optional:-->
         <failureDescription><?= $failure_desc ?></failureDescription>
         <!--Optional:-->
         <orderNumber><?= $wr_no ?></orderNumber>
         <orderType>WM</orderType>
         <planning>
            <!--Optional:-->
            <originator>
               <!--Optional:-->
               <entityId><?= $originator ?></entityId>
               <!--Optional:-->
            </originator>
            <!--Optional:-->
            <?php if(isset($parent_id)): ?>
            <parentOrderNumber><?=$parent_id?></parentOrderNumber>
            <?php endif?>
            <!--Optional:-->
            <plannedFinishDate></plannedFinishDate>            
            <!--Optional:-->
            <requestedFinishDate><?= $req_finish_date ?>T00:00:00-00:00</requestedFinishDate>
            <!--Optional:-->
            <priority><?= $priority ?></priority>
            <!--Optional:-->
           <status>01</status>
            <statusComment></statusComment>
         </planning>        
         <processing>
            <!--Optional:-->
            <actionType>1</actionType>
            <!--Optional:-->
            <processingVersion>ZJDE0001</processingVersion>
         </processing>
         <!--Optional:-->
         <workOrderType><?= $wo_type_id ?></workOrderType>
      </orac:processEquipmentWorkOrder>
   </soapenv:Body>
</soapenv:Envelope>
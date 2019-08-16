<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP130001/"><soapenv:Header><wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" soapenv:mustUnderstand="1"> <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"> <wsse:Username>BSV01</wsse:Username>  <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">interop</wsse:Password> </wsse:UsernameToken>
   </wsse:Security>
</soapenv:Header>
   <soapenv:Body>
      <orac:processEquipmentWorkOrder>
         <accounting>
            <!--Optional:-->
            <businessUnit><?= $id_warehouse ?></businessUnit>
            <!--Optional:-->
         </accounting>
         <!--Optional:-->
         <assetNumber><?= $fanumb ?></assetNumber>
         <!--Optional:-->
         <description><?= $wr_description ?></description>
         <!--Optional:-->
         <failureDescription><?= $failure_desc ?></failureDescription>
         <!-- -->
         <orderNumber><?= $wr_no ?></orderNumber>
         <orderType>WM</orderType>
         <processing>
            <!--Optional:-->
            <actionType>1</actionType>
            <!--Optional:-->
            <processingVersion>ZJDE0001</processingVersion>
         </processing>
         <planning>
           <status>01</status>
         </planning>
         <!--Optional:-->
         <workOrderType><?= $wo_type_id ?></workOrderType>
      </orac:processEquipmentWorkOrder>
   </soapenv:Body>
</soapenv:Envelope>
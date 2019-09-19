<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP430000/">
<soapenv:Header>
<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
    soapenv:mustUnderstand="1">
        <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
        xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:Username>BSV01</wsse:Username>  
            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">interop</wsse:Password>  
        </wsse:UsernameToken>
    </wsse:Security>
</soapenv:Header>
   <soapenv:Body>
      <orac:processPurchaseOrderV2>
         <!--Optional:-->
         <header>
            <buyer>
               <entityId><?= $po->username_procurement_specialist ?></entityId>
            </buyer>
            <currencyCodeTo><?= $po->currency ?></currencyCodeTo>
           
            <dates>
                <datePromisedDelivery><?= substr($date_promised_delivery,0,4).'-'.substr($date_promised_delivery,5,2).'-'.substr($date_promised_delivery,8,2) ?>T00:00:00-06:00</datePromisedDelivery>
            </dates>
            <?php foreach ($results as $result) : ?>
            <detail>
              <actionType>2</actionType>
              <datesDetail>
                  <datePromisedDelivery><?= substr($date_promised_delivery,0,4).'-'.substr($date_promised_delivery,5,2).'-'.substr($date_promised_delivery,8,2) ?>T00:00:00-06:00</datePromisedDelivery>
              </datesDetail>    
              <purchaseOrderLineKey>
                  <!--Optional:-->
                  <documentLineNumber><?= $result->PDLNID ?></documentLineNumber><!-- PDLNID -->
              </purchaseOrderLineKey>

            </detail>
          <?php endforeach;?>
            <!--Optional:-->
            <processing>
               <!--Optional:-->
               <actionType>2</actionType>
               <!--ZJDE0001-->
               <processingVersion>ZJDE0006</processingVersion>
            </processing>
            <!--Optional:-->
            <purchaseOrderKey>
               <!--Optional:-->
               <documentCompany>$po->id_company</documentCompany>
               <!--Optional:-->
               <documentNumber><?= substr($po->po_no, 0, 8) ?></documentNumber>
               <!--OP-->
               <documentTypeCode><?= substr($po->po_no, 9, 2) ?></documentTypeCode>


            </purchaseOrderKey>
            <!--Optional:-->
            <shipToAddress>
               <shipTo>
                  <!--Optional:-->
                  <entityId><?= (($po->id_dpoint) ? $po->id_dpoint : '10001') ?></entityId>
               </shipTo>
            </shipToAddress>

         </header>
      </orac:processPurchaseOrderV2>
   </soapenv:Body>
</soapenv:Envelope>

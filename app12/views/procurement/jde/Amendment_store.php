<?php
    $search = array('&');
    $replace = array('');
?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP430000/">
    <soapenv:Header>
        <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
            xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
            xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
            soapenv:mustUnderstand="1">
            <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                <wsse:Username>SCM</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
        <orac:processPurchaseOrderV2>
        <!--Optional:-->
            <header>
                <!--Branch/Plant:-->
                <businessUnit><?= substr(str_repeat(' ', 12).$arf->id_warehouse, -12) ?></businessUnit>
                <!--Nomor Pegawai:-->
                <buyer>
                   <entityId><?= $po->username_procurement_specialist ?></entityId>
                </buyer>
                <currencyCodeTo><?= $po->currency ?></currencyCodeTo>
                <dates>
                    <dateOrdered><?= date('m/d/Y', strtotime($po->po_date)) ?></dateOrdered>
                    <datePromisedDelivery><?= date('m/d/Y', strtotime($date_promised_delivery)) ?></datePromisedDelivery>
                    <dateRequested><?= date('m/d/Y') ?></dateRequested>
                </dates>
                <!--PO Description:-->
                <description1><?= substr($po->title, 0, 30) ?></description1>
                <?php if (isset($acceptance->items)) { ?>
                    <?php foreach ($acceptance->items as $item) { ?>
                        <detail>
                            <actionType>1</actionType>
                            <buyer>
                                <!--Optional:-->
                                <entityId><?= $po->username_procurement_specialist ?></entityId>
                            </buyer>
                            <datesDetail>
                                <dateAccounting><?= date('m/d/Y', strtotime($acceptance->accepted_user_at)) ?></dateAccounting>
                                <dateCancel></dateCancel>
                                <dateEffectiveLot></dateEffectiveLot>
                                <datePromisedDelivery><?= date('m/d/Y', strtotime($date_promised_delivery)) ?></datePromisedDelivery>
                                <dateRequested><?= date('m/d/Y', strtotime($acceptance->accepted_user_at)) ?></dateRequested>
                            </datesDetail>
                            <costUnitPurchasing><?= $item['cost_unit'] ?></costUnitPurchasing>
                            <deliveryDetail>
                                <!--Optional:-->
                                <landedCostRuleCode><?= $item['landed_cost_rule_code'] ?></landedCostRuleCode>
                            </deliveryDetail>
                            <financialDetail>
                                <glAccount>
                                    <businessUnit><?= $item['id_costcenter'] ?></businessUnit>
                                    <objectAccount><?= $item['id_account'] ?></objectAccount>
                                    <subsidiary><?= $item['id_subsidiary'] ?></subsidiary>
                                </glAccount>
                                <glClassCode><?= $item['gl_class_code'] ?></glClassCode>
                                <?php if ($item['id_itemtype'] == 'SERVICE' || ($item['id_itemtype'] == 'GOODS' && in_array($item['inventory_type_code'], array('AST', 'CON')))) { ?>
                                    <subledger><?= $item['subledger'] ?></subledger>
                                    <subledgerTypeCode><?= $item['subledger_type_code'] ?></subledgerTypeCode>
                                <?php } ?>
                            </financialDetail>
                            <product>
                                <!--Jika Jasa diisi:!-->
                                <description1><?= substr(str_replace($search, $replace, $item['material_desc']), -30) ?></description1>
                                <!--Optional:-->
                                <description2></description2>
                                <!--Optional:-->
                                <item>
                                    <!--Optional:-->
                                    <itemCatalog><?= $item['semic_no'] ?></itemCatalog>
                                </item>

                                <!--Optional:-->
                                <lineTypeCode><?= $item['line_type_code'] ?></lineTypeCode>
                            </product>
                            <purchaseOrderLineKey>
                                <!--Optional:-->
                                <documentLineNumber><?= $item['line_no'] ?></documentLineNumber>
                            </purchaseOrderLineKey>
                            <!--Optional:-->
                            <quantityOrdered><?= $item['qty'] ?></quantityOrdered>
                            <costExtended><?= $item['cost_extended'] ?></costExtended>
                            <!--Keterangan:-->
                            <reference><?= $po->po_no ?></reference>
                            <!--Keterangan2:-->
                            <!-- <reference1>?</reference1> -->
                            <!-- <relievePOBlanketOrder>?</relievePOBlanketOrder> -->
                            <shipTo>
                                <!--Addressbook:-->
                                <entityId><?= (($po->id_dpoint) ? $po->id_dpoint : '10001') ?></entityId>
                            </shipTo>
                            <!--Last Status : 220:-->
                            <statusCodeLast>220</statusCodeLast>
                            <!--Next Status : 400-->
                            <statusCodeNext>400</statusCodeNext>
                            <!--User : SCM-->
                            <transactionOriginator>SCM</transactionOriginator>
                            <!--UOM Primary-->
                            <unitOfMeasureCodePurchasing><?= $item['uom'] ?></unitOfMeasureCodePurchasing>
                            <unitOfMeasureCodeTransaction><?= $item['uom'] ?></unitOfMeasureCodeTransaction>
                        </detail>
                    <?php } ?>
                <?php } ?>

                <orderedBy><?= $notification->username_creator ?></orderedBy>
                <!--Optional:-->
                <!--<paymentTermsCode>?</paymentTermsCode> -->
                <!--Optional:-->
                <processing>
                   <!--Optional:-->
                   <actionType>2</actionType>
                   <!--ZJDE0001-->
                   <processingVersion>ZJDE0001</processingVersion>
                </processing>
                <!--Optional:-->
                <purchaseOrderKey>
                   <!--Optional:-->
                   <documentCompany><?= $po->id_company ?></documentCompany>
                   <!--Optional:-->
                   <documentNumber><?= substr($po->po_no, 0, 8) ?></documentNumber>
                   <!--OP-->
                   <documentTypeCode><?= substr($po->po_no, 9, 2) ?></documentTypeCode>
                   <!-- <documentTypeCode>OP</documentTypeCode> -->
                </purchaseOrderKey>
                <!--Optional:-->
                <shipToAddress>
                   <shipTo>
                      <!--Optional:-->
                      <entityId><?= (($po->id_dpoint) ? $po->id_dpoint : '10001') ?></entityId>
                   </shipTo>
                </shipToAddress>
                <supplierAddress>
                   <supplier>
                      <!--Optional:-->
                      <entityId><?= $po->id_external_vendor ?></entityId>
                   </supplier>
                </supplierAddress>
            </header>
        </orac:processPurchaseOrderV2>
    </soapenv:Body>
</soapenv:Envelope>
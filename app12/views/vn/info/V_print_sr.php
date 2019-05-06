<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PRINT SR DOCUMENT</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
    <style media="screen">
    .button {
    background-color: #7c7c7c; /* Green */
    border: none;
    color: white;
    padding: 10px 35px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    }
    .button-close {
    background-color: #e93b3b; /* Green */
    border: none;
    color: white;
    padding: 10px 35px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    }

    .button1 {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
    }

    .button2:hover {
        box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
    }
    @media print {
      .hidden-print {
        display: none !important;
      }
    }
    </style>
  </head>
  <body style="font-size: 10px;">
    <?php
    $query = $this->db->query("select h.ID_VENDOR, h.NAMA as nama_vendor, i.COMPANY, a.id_itp_vendor, d.itp_no, d.no_po, g.po_id, b.material_id, a.note AS note_vendor, d.note AS note_user, b.total AS total_vendor, b.qty as qty_vendor, e.qty as qty_user, e.total AS total_user, g.unitprice, g.total_price as totalprice_po, g.qty as qty_po, SUM(b.total) as tot_vendor, SUM(e.total) AS tot_user
    FROM t_vendor_itp a
    JOIN t_vendor_itp_detail b ON b.id_itp_vendor=a.id_itp_vendor
    JOIN t_itp d ON d.id_itp=a.id_itp
    JOIN t_itp_detail e ON e.id_itp=a.id_itp AND e.material_id=b.material_id
    JOIN t_purchase_order f ON f.po_no=d.no_po
    JOIN t_purchase_order_detail g ON g.po_id=d.no_po AND g.material_id=b.material_id
    LEFT JOIN m_vendor h ON h.ID_VENDOR=d.id_vendor AND h.ID_VENDOR=f.id_vendor
    JOIN m_user i ON i.ID_USER=d.created_by
    WHERE a.id_itp='".base64_decode(hex2bin($data))."'
    GROUP BY h.ID_VENDOR, nama_vendor, i.COMPANY, a.id_itp_vendor, d.itp_no, d.no_po, g.po_id, b.material_id, note_vendor, note_user, total_vendor, qty_vendor, qty_user, total_user, g.unitprice, totalprice_po, qty_po, b.total, e.total");
    $dt_bpk = $query->result_array();

    $query3 = $this->db->query("select SUM(total_vendor) as sumtotal_vendor, SUM(total_user) as sumtotal_user, SUM(totalprice_po) as sumtotalprice_po, SUM(est_unitprice) as est_unitpricepo, SUM(est_total_price) as est_total_pricepo, bb.*
	FROM (select h.ID_VENDOR, h.NAMA as nama_vendor, i.COMPANY, a.id_itp_vendor, d.itp_no, d.no_po, g.po_id, b.material_id, a.note AS note_vendor, d.note AS note_user, b.total AS total_vendor, b.qty as qty_vendor, e.qty as qty_user, e.total AS total_user, g.unitprice, g.total_price as totalprice_po, g.est_unitprice, g.est_total_price, g.qty as qty_po, SUM(b.total) as tot_vendor, SUM(e.total) AS tot_user
    FROM t_vendor_itp a
    JOIN t_vendor_itp_detail b ON b.id_itp_vendor=a.id_itp_vendor
    JOIN t_itp d ON d.id_itp=a.id_itp
    JOIN t_itp_detail e ON e.id_itp=a.id_itp AND e.material_id=b.material_id
    JOIN t_purchase_order f ON f.po_no=d.no_po
    JOIN t_purchase_order_detail g ON g.po_id=d.no_po AND g.material_id=b.material_id
    LEFT JOIN m_vendor h ON h.ID_VENDOR=d.id_vendor AND h.ID_VENDOR=f.id_vendor
    JOIN m_user i ON i.ID_USER=d.created_by
    WHERE a.id_itp='".base64_decode(hex2bin($data))."'
    GROUP BY
	h.ID_VENDOR, nama_vendor, i.COMPANY, a.id_itp_vendor, d.itp_no, d.no_po, g.po_id, b.material_id, note_vendor, note_user, total_vendor, qty_vendor, qty_user, total_user, g.unitprice, totalprice_po, g.est_unitprice, g.est_total_price, qty_po, b.total, e.total
	) as bb GROUP BY bb.ID_VENDOR, bb.nama_vendor, bb.COMPANY, bb.id_itp_vendor, bb.itp_no, bb.no_po, bb.po_id, bb.material_id, bb.note_vendor, bb.note_user, bb.total_vendor, bb.qty_vendor, bb.qty_user, bb.total_user, bb.unitprice, bb.totalprice_po, bb.est_unitprice, bb.est_total_price, bb.qty_po");

    $query2 = $this->db->query("select DESCRIPTION FROM m_company WHERE ID_COMPANY IN (".$query->row()->COMPANY.") ");
    $dt_comp = $query2->result_array();

    $sumtotal_vendor = $query3->row()->sumtotal_vendor;
    $sumtotalprice_po = $query3->row()->sumtotalprice_po;
    $remaining = $sumtotalprice_po-$sumtotal_vendor;
    ?>
  <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
        <button type="button" class="hidden-print button button2" name="button" onClick="window.print();">PRINT</button>
        <button type="button" class="hidden-print button-close button2" name="button" onClick="window.close();">CLOSE</button>
        <h4 class="text-center" style="margin-left: -15px; color: #337ab7; font-weight: bold;"><img style="width:30px;" alt="Supreme admin logo" src="<?= base_url()?>ast11/img/supreme.png" class="brand-logo">
        supre<span style="color: #ff3333">m</span>e energy</h4>
        <br>
			<h5 class="text-center">
				<b>INSTRUCTION TO PERFORM (ITP)</b><br>
				<b>SURAT PERINTAH KERJA</b>
			</h5>
      <br>
			<h4 class="text-center" style="font-size: 12px;">
				 <?php
          foreach ($dt_comp as $arr) {
            echo 'Issued by / Dikeluarkan oleh '.$arr['DESCRIPTION'].'<br>';
          }
         ?>
			</h4>
      <div class="" style="width: 100%; display: inline-block;">
        <div class="" style="width: 60%; float: left;">
          <table class="">
            <tbody>
              <tr>
                <td>ITP Number <br> No ITP</td>
                <td> <?= $query->row()->itp_no; ?></td>
              </tr>
              <tr>
                <td>Contract Ref. <br> Ref. Kotrak</td>
                <td> <?= $query->row()->no_po; ?></td>
              </tr>
              <tr>
                <td>Contractor Name : <br> Nama Kontraktor : </td>
                <td> <?= $query->row()->nama_vendor; ?></td>
              </tr>
              <tr>
                <td>Location <br>Lokasi</td>
                <td>
                  <?php
                    foreach ($dt_comp as $arr) {
                      echo $arr['DESCRIPTION'].'<br>';
                    }
                   ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

          <div class="" style="width: 40%; float: right;">
            <table class="">
              <tbody>
                <tr>
                  <td>Date <br> Tanggal</td>
                  <td><?= date("d-M-Y")?></td>
                </tr>
                <tr>
                  <td>Dept File No. <br> No. File Dept.</td>
                  <td> ................................</td>
                </tr>
                <tr>
                  <td>Charge To <br> Dibebankan Ke</td>
                  <td> ................................</td>
                </tr>
              </tbody>
            </table>
          </div>
      </div>
			<div class="">
        <h4 style="font-size: 12px;">
  				<b>Work to be performed under this ITP / Pekerjaan yang harus dilaksanakan dalam ITP ini</b>
  			</h4>
      </div>
			<div class="row">
				<div class="col-md-12">
					<div style="width: 100%; padding-left: 10px; border: 2px solid gray; margin: 0;">
            <h5 class="text-center" style="font-size: 10px;">
  						<b>
                <?php
                  echo $query3->row()->note_vendor;
                 ?>
              </b>
  					</h5>
            <h4 style="font-size: 10px;">Notes / Catatan :</h4>
  					<br>
  					<br>
  					<br>
  					<br>
  					<br>
  					<br>
          </div>
				</div>
			</div>
      <table class="table">
        <tbody>
          <tr>
            <td>Estimate amount under this ITP <br> Estimasi nilai dalam ITP</td>
            <td>: <?php echo $query3->row()->est_total_pricepo; ?></td>
          </tr>
          <tr>
            <td>Cumulative total spending  (prior to this ITP) <br> Jumlah pengeluaran kumulatif (sebelum ITP ini)</td>
            <td>: <?php echo $query3->row()->sumtotalprice_po; ?></td>
          </tr><tr>
            <td>Remaining spending (after this ITP) <br> Sisa pengeluaran (setelah ITP ini)</td>
            <td>: <?php echo $remaining; ?> </td>
          </tr>
        </tbody>
      </table>
      <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th></th>
            <th class="text-center">Instructed by <br> Diperintahkan oleh</th>
            <th class="text-center">Approved by <br> Disetujui oleh</th>
            <th class="text-center">ITP Acceptance <br> Penerimaan oleh <br> (by Cotractor / oleh Kontraktor)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Name <br> Nama</td>
            <td class="text-center"> Ismail Martian</td>
            <td class="text-center"> Hary Wibowo</td>
            <td> </td>
          </tr>
          <tr>
            <td>Title <br> Posisi</td>
            <td class="text-center">Logistic Specialist</td>
            <td class="text-center">Sr. Manager SCM</td>
            <td></td>
          </tr>
          <tr>
            <td>Signature <br> Tanda Tangan</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Date <br> Tanggal</td>
            <td class="text-center"><?= date("d-M-Y")?></td>
            <td class="text-center"><?= date("d-M-Y")?></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
    <h4 style="font-size: 12px;"><b>Notes / Catatan :</b></h4>
    <p>
      <?php
        echo $query3->row()->note_user;
      ?>
    </p>
		</div>
	</div>
</div>
<br>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>INSPINIA | Login</title>

        <link href="<?= base_url() ?>ast11/css/bootstrap.min.css" rel="stylesheet">

    </head>

    <body class="gray-bg">

        <div class="box-body mdl-cell--12-col">

            <h3 class="mdl-cell mdl-cell--12-col">Total Harga A</h3>

            <div class="mdl-cell--12-col panel panel-default ">
                <div class="panel-body">

                    <table width="85%"  class="table table-condensed" >
                        <thead>

                            <tr>   
                                <th data-field="name">ID</th>
                                <th data-field="name">Deskripsi</th>
                                <th data-field="name">Qty</th>
                                <th data-field="name">Harga</th>
                                <th data-field="name">Total</th>                   

                            </tr>    
                        </thead>
                        <tbody>

                            <?php
                            for ($i = 0; $i <= 12; $i++) {
                                ?>
                                <tr><td><?= $i+1 ?></td>
                                    <td><?= "Deskripsi $i" ?></td>
                                    <td><?= 10 ?></td>
                                    <td><?= $i * 10 ?></td>
                                    <td><?= ($i * 10)*10 ?></td>                          


                                </tr>

                            <?php } ?> 
                        </tbody>
                    </table>
                </div></div>
        </div>

        <!-- Mainly scripts -->
        <script src="<?= base_url() ?>ast11/js/jquery-2.1.1.js"></script>
        <script src="<?= base_url() ?>ast11/js/bootstrap.min.js"></script>

    </body>

</html>
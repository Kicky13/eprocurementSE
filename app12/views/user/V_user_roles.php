<style>
	#treeviewTask {
		height: 300px;
		overflow-y: auto;
		overflow-x: hidden;
		border: 1px solid #d9d9d9;
	}

</style>


<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a>
                            </li>
                            <li class="breadcrumb-item active"><?= lang("Akses User", "User Roles") ?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="description" class="card">
                <div class="card-header">
                    <div class="form-group row">
                        <div class="col-6">
                            <h4 class="card-title"><?= lang("Akses User", "User Roles") ?></h4>
                        </div>
                        <div class="col-6">
                            <div role="group" aria-label="Button group with nested dropdown" class="btn-group float-md-right">
                                <div role="group" class="btn-group">
                                    <button aria-expanded="false" onclick="add()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang("Tambah", "Add") ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="card-text">
                            <table id="tbl" class="table table-striped table-bordered table-hover display" width="100%">
                                <tfoot>
                                    <tr>
                                        <th><center>No</center></th>
                                        <th><center><?= lang('ID User Roles', 'ID User Roles') ?></center></th>
                                        <th><center><?= lang("Deskripsi", "Description") ?></center></th>
                                        <th><center>Status</center></th>
                                        <th><center><?= lang("Aksi", "Action") ?></center></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div class="modal fade bs-example" data-backdrop="static" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <form id="form">
                <!--hide value-->
                <input name="id" id="id" hidden>
                <!--end hide value-->
                <div class="modal-header bg-primary" style="color:#fff">
                    <h4 class="modal-title "></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label"><?= lang('Deskripsi Role', 'Role Description') ?></label>
                        <div class="controls">
                            <input type="text" name="desc" id="desc" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Menu', 'Menu') ?></label>
                        <div class="row">
                            <div class="col-md-12">
                                <input id="filterText" type="text" placeholder="Search categories" />
                                <div class="selectAll">
                                    <input type="checkbox" id="chbAll" class="k-checkbox" onchange="chbAllOnChange()" />
                                    <label class="k-checkbox-label" for="chbAll">Select All</label>
                                    <span id="result">0 categories selected</span>
                                </div>
                                <div id="treeview" required></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= lang('Task', 'Task') ?></label>
                        <div class="row">
                            <div class="col-md-12">
                                <!--input id="filterText" type="text" placeholder="Search categories" /-->
                                <!--div class="selectAll">
                                    <input type="checkbox" id="chbAll" class="k-checkbox" onchange="chbAllOnChange()" />
                                    <label class="k-checkbox-label" for="chbAll">Select All</label>
                                    <span id="result">0 categories selected</span>
                                </div-->
                                <div id="treeviewTask" required></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="controls">
                            <div class="col-sm-10">
                                <input type="radio" value="1" name="status" id="aktif"> <i></i><?= lang('Aktif', 'Active') ?>
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" value="0" name="status" id="nonaktif"> <i></i><?= lang('Nonaktif', 'Nonactive') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="submit" class="btn btn-primary" id="save"><?= lang('Simpan', 'Save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal2" class="modal fade" role="dialog"  >
    <div class="modal-dialog" >
        <div class="modal-content" >
            <div class="modal-header bg-primary">
                <h3 class="modal-title ">Pilih Menu</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="treeview"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary col-md-5" onclick="onOkClick()"><?= lang("Pilih", "Select") ?></button>
                <button class="btn btn-default col-md-5" type="button" data-dissmiss="modal"><?= lang("Batal", "Cancel") ?></button>
            </div>
        </div>
    </div>
</div>
<link href="<?= base_url() ?>ast11/css/kendo/kendo.common-material.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/kendo/kendo.material.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/kendo/kendo.material.mobile.min.css" rel="stylesheet">
<script src="<?= base_url() ?>ast11/js/kendo.all.min.js"></script>
<script src="<?= base_url() ?>ast11/js/kendo.all.min.js"></script>
<script type="text/javascript">
                    $(function () {
                       
						$.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: '<?= base_url("users/user_roles/getTask") ?>',
                            success: function (res) {
								console.log(res);
								$("#treeviewTask").kendoTreeView({
                                    loadOnDemand: false,
                                    checkboxes: {
                                        checkChildren: true
                                    },
                                    dataSource: new kendo.data.HierarchicalDataSource({
                                        data: res
                                    }),
                                    check: onCheck,
                                    expand: onExpand
                                });
                            }
                        });
						var DataSource =
							$("#multiselect").kendoMultiSelect({
								dataTextField: "text",
								dataValueField: "id"
							});
						$('#modal').on('hidden.bs.modal', function (e) {
                            uncheckAllNodes($("#treeviewTask").data("kendoTreeView").dataSource.view());
                        });
						
						
						
						var data2 = new Array();
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: '<?= base_url("users/user_roles/get_usermenu") ?>',
                            success: function (res) {
								console.log(res);
                                $("#treeview").kendoTreeView({
                                    loadOnDemand: false,
                                    checkboxes: {
                                        checkChildren: true
                                    },
                                    dataSource: new kendo.data.HierarchicalDataSource({
                                        data: res
                                    }),
                                    check: onCheck,
                                    expand: onExpand
                                });
                            }
                        });
                        var DataSource =
                                $("#multiselect").kendoMultiSelect({
                            dataTextField: "text",
                            dataValueField: "id"
                        });
                        $('#modal').on('hidden.bs.modal', function (e) {
                            uncheckAllNodes($("#treeview").data("kendoTreeView").dataSource.view());
                        });
//                        $("#menu").select2({
//                            placeholder: "Please Select"
//                        });
                        $('#form').on('submit', function (e) {
                            e.preventDefault();
                            var checkedNodes = [];
                            var checkedNodesTask = [];
                            var data = {};
                            var treeView = $("#treeview").data("kendoTreeView");
                            var treeViewTask = $("#treeviewTask").data("kendoTreeView");
                            getCheckedNodes(treeView.dataSource.view(), checkedNodes);
                            getCheckedNodes(treeViewTask.dataSource.view(), checkedNodesTask);
                            $.each($("#form").serializeArray(), function (i, field) {
                                data[field.name] = field.value;
                            });
                            data['idmenu'] = checkedNodes;
                            data['idtask'] = checkedNodesTask;
							$.ajax({
                                type: 'POST',
                                url: '<?= base_url('users/user_roles/change') ?>',
                                data: data,
                                success: function (m) {
                                    if (m == ' sukses') {
                                        $('#modal').modal('hide');
                                        document.getElementById("form").reset();
                                        $("#treeview .k-checkbox input").prop("checked", false).trigger("change");
                                        $("#treeviewTask .k-checkbox input").prop("checked", false).trigger("change");
                                        $('#tbl').DataTable().ajax.reload();
                                        msg_info('Sukses tersimpan');
                                    } else {
                                        msg_danger(m);
                                    }
                                }
                            });
                        });
                        $('#tbl tfoot th').each(function (i) {
                            var title = $('#tbl thead th').eq($(this).index()).text();
                            if (i > 0 && i < 4)
                                $(this).html('<input type="text" placeholder="Search ' + title + '" data-index="' + i + '" />');
                        });
                        var table = $('#tbl').DataTable({
                            ajax: {
                                url: '<?= base_url('users/user_roles/show') ?>',
                                dataSrc: ''
                            },
                            scrollX: true,
                            scrollY: '300px',
                            scrollCollapse: true,
                            paging: true,
                            filter: true,
                            fixedColumns: {
                                leftColumns: 1,
                                rightColumns: 1
                            },
                            columns: [
                                {title: "<center>No</center>", "width": "20px"},
                                {title: "<center><?= lang('ID User Roles', 'ID User Roles') ?></center>"},
                                {title: "<center><?= lang("Deskripsi", "Description") ?></center>"},
                                {title: "<center>Status</center>"},
                                {title: "<center><?= lang("Aksi", "Action") ?></center>", "width": "50px"}
                            ],
                            "columnDefs": [
                                {"className": "dt-right", "targets": [0]},
                                {"className": "dt-center", "targets": [1]},
                                {"className": "dt-center", "targets": [2]},
                                {"className": "dt-center", "targets": [3]},
                                {"className": "dt-center", "targets": [4]}
                            ]
                        });
                        $(table.table().container()).on('keyup', 'tfoot input', function () {
                            table.column($(this).data('index'))
                                .search(this.value)
                                .draw();
                        });
                        lang();

                        $("#filterText").keyup(function (e) {
                            var filterText = $(this).val();
                            filterText=filterText.toLowerCase();
                            console.log(filterText);
                            if (filterText !== "") {
                                $(".selectAll").css("visibility", "hidden");

                                $("#treeview .k-group .k-group .k-in").closest("li").hide();
                                $("#treeview .k-group").closest("li").hide();
                                console.log($("#treeview .k-in:contains(" + filterText + ")"));
                                $("#treeview .k-in:contains(" + filterText + ")").each(function () {
                                    $(this).parents("ul, li").each(function () {
                                        var treeView = $("#treeview").data("kendoTreeView");
                                        treeView.expand($(this).parents("li"));
                                        $(this).show();
                                    });
                                });
                                $("#treeview .k-group .k-in:contains(" + filterText + ")").each(function () {
                                    $(this).parents("ul, li").each(function () {
                                        $(this).show();
                                    });
                                });
                            }
                            else {
                                $("#treeview .k-group").find("li").show();
                                var nodes = $("#treeview > .k-group > li");

                                $.each(nodes, function (i, val) {
                                    if (nodes[i].getAttribute("data-expanded") == null) {
                                        $(nodes[i]).find("li").hide();
                                    }
                                });

                                $(".selectAll").css("visibility", "visible");
                            }
                        });
                    });
                    function add() {
                        document.getElementById("form").reset();
                        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
                        onCheck();
                        $('#modal').modal('show');
                        $('#id').val("");
                        document.getElementById("aktif").checked = true;
                        lang();
                    }

                    function update(id) {
                        $.ajax({
                            type: 'get',
                            url: '<?= base_url('users/user_roles/get/') ?>' + id,
                            success: function (msg) {
                                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                                var msg = msg.replace("[", "");
                                var msg = msg.replace("]", "");
                                var d = JSON.parse(msg);
                                $('#id').val(d.ID_USER_ROLES);
                                $('#desc').val(d.DESCRIPTION);
                                var menu = [];
                                $.each(d.MENU.split(","), function(key, val) {
                                    menu[val] = val;
                                });
                                checkSpecificNodes($("#treeview").data("kendoTreeView").dataSource.view(), true, menu);
                                
								var task = [];
								$.each(d.TASK.split(","), function(key, val) {
                                    task[val] = val;
                                });
                                checkSpecificNodes($("#treeviewTask").data("kendoTreeView").dataSource.view(), true, task);
                                
								// $('#status_akses').val(d.AKSES);
                                // console.log(d.MENU);
                                if (d.STATUS == "1") {
                                    document.getElementById("aktif").checked = true;
                                } else {
                                    document.getElementById("nonaktif").checked = true;
                                }
                                onCheck();
                                $('#modal').modal('show');
                                lang();
                            }
                        });
                    }
                    function onClose() {
                        $("#openWindow").fadeIn();
                    }

                    function populateMultiSelect(checkedNodes) {
                        var multiSelect = $("#multiselect").data("kendoMultiSelect");
                        multiSelect.dataSource.data([]);
                        var multiData = multiSelect.dataSource.data();
                        if (checkedNodes.length > 0) {
                            var array = multiSelect.value().slice();
                            for (var i = 0; i < checkedNodes.length; i++) {
                                multiData.push({text: checkedNodes[i].text, id: checkedNodes[i].id});
                                array.push(checkedNodes[i].id.toString());
                            }

                            multiSelect.dataSource.data(multiData);
                            multiSelect.dataSource.filter({});
                            multiSelect.value(array);
                        }
                    }

                    function checkUncheckAllNodes(nodes, checked) {
                        for (var i = 0; i < nodes.length; i++) {

                            nodes[i].set("checked", checked);
                            if (nodes[i].hasChildren) {
                                checkUncheckAllNodes(nodes[i].children.view(), checked);
                            }
                        }
                    }
                    function uncheckAllNodes(nodes)
                    {
                        for (var i = 0; i < nodes.length; i++) {
                            nodes[i].set("checked", false);
                            if (nodes[i].hasChildren) {
                                checkUncheckAllNodes(nodes[i].children.view(), false);
                            }
                        }
                    }

                    function checkSpecificNodes(nodes, checked, data) {
                        for (var i = 0; i < nodes.length; i++) {
                            if (nodes[i].hasChildren) {
                                checkSpecificNodes(nodes[i].children.view(), checked, data);
                            }else{
                                if (data[nodes[i].id]) {
                                    nodes[i].set("checked", checked);
                                }
                            }
                        }
                    }

                    function chbAllOnChange() {
                        var checkedNodes = [];
                        var treeView = $("#treeview").data("kendoTreeView");
                        var isAllChecked = $('#chbAll').prop("checked");
                        checkUncheckAllNodes(treeView.dataSource.view(), isAllChecked)

                        if (isAllChecked) {
                            setMessage($('#treeview input[type="checkbox"]').length);
                        }
                        else {
                            setMessage(0);
                        }
                    }

                    function getCheckedNodes(nodes, checkedNodes) {
                        var node;
                        for (var i = 0; i < nodes.length; i++) {
                            node = nodes[i];
                            if (node.checked) {
//                                checkedNodes.push({text: node.text, id: node.id});
                                checkedNodes.push(node.id);
                            }

                            if (node.hasChildren) {
                                getCheckedNodes(node.children.view(), checkedNodes);
                            }
                        }
                    }

                    function onCheck() {
                        var checkedNodes = [];
                        var treeView = $("#treeview").data("kendoTreeView");
                        getCheckedNodes(treeView.dataSource.view(), checkedNodes);
                        setMessage(checkedNodes.length);
                    }

                    function onExpand(e) {
                        if ($("#filterText").val() == "") {
                            $(e.node).find("li").show();
                        }
                    }

                    function setMessage(checkedNodes) {
                        var message;
                        if (checkedNodes > 0) {
                            message = checkedNodes + "&nbsp<?= lang("Kategori Terpilih", "categories selected") ?>";
                        }
                        else {
                            message = "0&nbsp<?= lang("Kategori Terpilih", "categories selected") ?>";
                        }
                        lang();
                        $("#result").html(message);
                        lang();
                    }
</script>

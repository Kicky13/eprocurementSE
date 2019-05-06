<script>
    function clear_filter(filters) {
        $.each(filters, function(key, name) {
            $('[name*="filter['+name+']"').prop('checked', false);
            is_filter_checked_all(name);
        });
    }

    function select_all(filter) {
        var value = $('#select_all-'+filter).val();
        if (value == 0) {
            $('[name*="filter['+filter+']"').prop('checked', true);
        } else {
            $('[name*="filter['+filter+']"').prop('checked', false);
        }
        is_filter_checked_all(filter);
    }

    function is_filter_checked_all(filter) {
        var unchecked = $('[name*="filter['+filter+']"]:not(:checked)').length;
        if (unchecked == 0) {
            $('#select_all-'+filter+'-toggle').html('Unselect All');
            $('#select_all-'+filter).val(1);
        } else {
            $('#select_all-'+filter+'-toggle').html('Select All');
            $('#select_all-'+filter).val(0);
        }
    }

    function get_filter_department() {
        $.ajax({
            url : '<?= base_url('dashboard/filter/department_json') ?>',
            data : $('[name*="filter[company]"]').serialize(),
            dataType : 'json',
            success : function(response) {
                var filterContentHtml = '';
                $.each(response['data'], function(key, row) {
                    filterContentHtml += '<label class="custom-control ">';
                        filterContentHtml += '<input type="checkbox" id="department" name="filter[department][]" value="'+row.ID_DEPARTMENT+'" data-id="'+row.ID_DEPARTMENT+'" data-text="'+row.DEPARTMENT_DESC+'" onchange="is_filter_checked_all(\'department\'), get_filter_costcenter()">';
                        filterContentHtml += '<span class="checkbox-label">'+row.DEPARTMENT_DESC+'</span>';
                    filterContentHtml += '</label>';
                });
                $('#filter-content-department').html(filterContentHtml);
                is_filter_checked_all('department');
            }
        });
    }

    function get_filter_costcenter() {
        $.ajax({
            url : '<?= base_url('dashboard/filter/costcenter_json') ?>',
            data : $('[name*="filter[department]"]').serialize(),
            dataType : 'json',
            success : function(response) {
                var filterContentHtml = '';
                $.each(response['data'], function(key, row) {
                    filterContentHtml += '<label class="custom-control ">';
                        filterContentHtml += '<input type="checkbox" name="filter[costcenter][]" value="'+row.ID_COSTCENTER+'" data-text="'+row.COSTCENTER_DESC+'" onchange="is_filter_checked_all(\'costcenter\'), get_filter_accsub()">';
                        filterContentHtml += '<span class="checkbox-label">'+row.ID_COSTCENTER+'</span>';
                    filterContentHtml += '</label>';
                });
                $('#filter-content-costcenter').html(filterContentHtml);
                is_filter_checked_all('costcenter');
            }
        });
    }

    function get_filter_accsub() {
        $.ajax({
            url : '<?= base_url('dashboard/filter/accsub_json') ?>',
            data : $('[name*="filter[costcenter]"]').serialize(),
            dataType : 'json',
            success : function(response) {
                var filterContentHtml = '';
                $.each(response['data'], function(key, row) {
                    filterContentHtml += '<label class="custom-control ">';
                        filterContentHtml += '<input type="checkbox" name="filter[subsidiary_account][]" value="'+row.ID_ACCSUB+'" data-text="'+row.ACCSUB_DESC+'">';
                        filterContentHtml += '<span class="checkbox-label">'+row.ID_ACCSUB+'</span>';
                    filterContentHtml += '</label>';
                });
                $('#filter-content-subsidiary_account').html(filterContentHtml);
                is_filter_checked_all('subsidiary_account');
            }
        });
    }

    function renderCurrentFilterContent(filter, title) {
        var html = '';
        if ($('[name*="filter['+filter+'][]"]:checked').length) {
            html += '<div class="row"><label class="col-md-2">'+title+'</label><div class="col-md-9">';
            $.each($('[name*="filter['+filter+'][]"]:checked'), function(key, elem) {
                html += '<span class="badge badge-secondary mr-1 mb-1">'+$(elem).data('text')+'</span>';
            });
            html += '</div></div>';
        }
        return html;
    }
</script>

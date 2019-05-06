<script>
    $(function() {
        $("#filter-dashboard .select2").select2({
            dropdownCssClass: 'select2-dropdown-large select2-font-sm'
        });
        $('#company').change(function() {                       
            get_filter_department();
        });
    });

    function get_filter_department() {
        $.ajax({
            url: '<?= base_url('dashboard/filter/get_department') ?>',
            data: $('#company').serialize(),
            dataType: 'json',
            success: function(response) {
                $('#department').html('').select2({
                    data:response,
                    dropdownCssClass: 'select2-dropdown-large select2-font-sm'
                }).trigger('change');                
            }
        });        
    }

    function get_filter_procurement_specialist() {
        $.ajax({
            url: '<?= base_url('dashboard/filter/get_procurement_specialist') ?>',
            data: $('#company, #department').serialize(),
            dataType: 'json',
            success: function(response) {
                $('#specialist').html('').select2({
                    data:response,
                    dropdownCssClass: 'select2-dropdown-large select2-font-sm'
                }).trigger('change');
            }
        });
    }

    function get_filter_users() {
        $.ajax({
            url: '<?= base_url('dashboard/filter/get_users') ?>',
            data: $('#company, #department').serialize(),
            dataType: 'json',
            success: function(response) {
                $('#users').html('').select2({
                    data:response,
                    dropdownCssClass: 'select2-dropdown-large select2-font-sm'
                }).trigger('change');
            }
        });
    }
</script>
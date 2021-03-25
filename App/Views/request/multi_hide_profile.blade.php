<script>
    $(document).ready(function () {
        $('.hide-profile').on('click', function () {
            var other_id = $(this).data('id');
            $.ajax({
                url: "/ajax/hide-profile",
                method: 'post',
                data: {
                    other_id: other_id
                },
                dataType: "text",
                success: function (data, status) {
                    var message = data;
                    if(toaster.length != 0){
                        if (document.dir != "rtl") {
                            callToaster("toast-top-right",message);
                        } else {
                            callToaster("toast-top-left",message);
                        }
                    }
                    //$('#remind-'+other_id).attr('disabled',true);

                    //$('.ir-'+other_id).hide('slow');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#sendInterest').on('click', function () {
            var other_id = $(this).data('id');
            $.ajax({
                url: "/ajax/connect-profile",
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
                    $('#sendInterest').attr('disabled','disabled');
                }
            });
        });
    });
</script>
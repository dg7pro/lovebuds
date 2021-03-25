<script>

    //================================
    // Unset & close
    // Flash Message on cross click
    //================================
    $(document).ready(function() {
        $('.alert').on('closed.bs.alert', function () {
            $.ajax({
                url: "ajax/unset-session.php",
                method: 'POST',
                dataType: "text",
                success: function (data, status) {
                    console.log(5050);
                    console.log(status);
                    //$('.alert').hide('slow');
                }
            });
        });
    });

    //================================
    // Unset & close
    // Flash Message after 10 sec
    //================================
    $(document).ready(function(){
        window.setTimeout(unsetFlash,10000);
        function unsetFlash(){
            $.ajax({
                url:"ajax/unset-session.php",
                method:'POST',
                dataType:"text",
                success:function (data,status) {
                    console.log(status)
                    $('.alert').hide('slow');
                }
            });
        }
    });

</script>

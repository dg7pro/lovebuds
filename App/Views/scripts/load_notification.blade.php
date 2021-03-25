<script>
    //================================
    // Notification
    // system for users
    //================================

    $(document).ready(function(){
        function load_notification(view=''){
            $.ajax({

                url:'ajax/notification.php',
                method:'POST',
                data:{view:view},
                dataType:"json",
                success:function(data){
                    console.log(data);
                    // $('#dropdown-menu').html(data)
                    $('#notify').html(data)
                }
            });
        }
        load_notification();
    });

</script>
<script>
    $(document).ready(function(){
        // ==================================
        // Password validation
        // Validating user input password
        // ==================================
        $('#newPassword').blur(function () {

            var password = $(this).val();
            $.ajax({
                url:"/AjaxRegistration/checkPassword",
                method:'POST',
                data:{pw:password},
                dataType:"json",
                success:function (data) {
                    //console.log(data);
                    if(data.n == 1){
                        $('#pw_ok').attr('hidden',false);
                        $('#pw_not_ok').attr('hidden',true);
                    }else{
                        $('#pw_ok').attr('hidden',true);
                        $('#pw_not_ok').attr('hidden',false);
                        toastr.error(data.ht);
                    }
                }
            });
        });
    });
</script>

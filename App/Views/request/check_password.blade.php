<script>
    $(document).ready(function(){
        // ==================================
        // Password validation
        // Validating user input password
        // ==================================
        $('#newPassword').blur(function () {

            var password = $(this).val();
            $.ajax({
                url:"/Ajax/checkPassword",
                method:'POST',
                data:{pw:password},
                dataType:"json",
                success:function (data) {
                    //console.log(data);
                    if(data.n == 1){
                        //$('#btn-signup').attr('disabled',false);
                        // $('#password').removeClass('is-invalid').addClass('is-valid');
                        // $('#msg-4').removeClass('invalid-feedback').addClass('valid-feedback');
                        $('#pw_ok').attr('hidden',false);
                        $('#pw_not_ok').attr('hidden',true);
                    }else{
                        //$('#btn-signup').attr('disabled',true);
                        // $('#password').removeClass('is-valid').addClass('is-invalid');
                        // $('#msg-4').removeClass('valid-feedback').addClass('invalid-feedback');
                        $('#pw_ok').attr('hidden',true);
                        $('#pw_not_ok').attr('hidden',false);
                        toastr.error(data.ht);
                    }
                    setTimeout(function(){

                    }, 500);
                }
            });
        });
    });
</script>

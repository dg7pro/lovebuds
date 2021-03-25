<script>
    $(document).ready(function(){
        // ==================================
        // Password validation
        // Validating user input password
        // ==================================
        $('#password').keyup(function () {
            var password = $(this).val();
            $('#msg-4').attr('hidden',true);
            $('#spinner-4').attr('hidden',false);
            $.ajax({
                url:"/Ajax/checkPassword",
                method:'POST',
                data:{pw:password},
                dataType:"json",
                success:function (data) {
                    //console.log(data);
                    if(data.n == 1){
                        //$('#btn-signup').attr('disabled',false);
                        $('#password').removeClass('is-invalid').addClass('is-valid');
                        $('#msg-4').removeClass('invalid-feedback').addClass('valid-feedback');
                    }else{
                        //$('#btn-signup').attr('disabled',true);
                        $('#password').removeClass('is-valid').addClass('is-invalid');
                        $('#msg-4').removeClass('valid-feedback').addClass('invalid-feedback');
                    }
                    setTimeout(function(){
                        $('#spinner-4').attr('hidden',true);
                        $('#msg-4').text(data.ht).attr('hidden',false).show();
                    }, 500);
                }
            });
        });
    });
</script>

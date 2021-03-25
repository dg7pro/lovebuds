<script>
    $(document).ready(function(){

        // ==================================
        // Email validation
        // Validating user input email
        // ==================================
        $('#email').blur(function () {
            var email = $(this).val();
            $('#msg-2').attr('hidden',true);
            $('#spinner-2').attr('hidden',false);
            $.ajax({
                url:"/Ajax/checkEmail",
                method:'POST',
                data:{em:email},
                dataType:"json",
                success:function (data) {
                    //console.log(data);
                    if(data.n == 1){
                        //$('#btn-signup').attr('disabled',false);
                        $('#email').removeClass('is-invalid').addClass('is-valid');
                        $('#msg-2').removeClass('invalid-feedback').addClass('valid-feedback');
                    }else{
                        //$('#btn-signup').attr('disabled',true);
                        $('#email').removeClass('is-valid').addClass('is-invalid');
                        $('#msg-2').removeClass('valid-feedback').addClass('invalid-feedback');
                    }
                    setTimeout(function(){
                        $('#spinner-2').attr('hidden',true);
                        $('#msg-2').text(data.ht).attr('hidden',false).show();
                    }, 500);
                }
            });
        });


    });
</script>
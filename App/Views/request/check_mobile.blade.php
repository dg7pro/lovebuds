<script>
    $(document).ready(function(){

        // ==================================
        // Mobile validation
        // Validating user input mobile
        // ==================================
        $('#mobile').blur(function () {
            var mobile = $(this).val();
            $('#msg-3').attr('hidden',true);
            $('#spinner-3').attr('hidden',false);
            $.ajax({
                url:"/Ajax/checkMobile",
                method:'POST',
                data:{mb:mobile},
                dataType:"json",
                success:function (data) {
                    //console.log(data);
                    if(data.n == 1){
                        //$('#btn-signup').attr('disabled',false);
                        $('#mobile').removeClass('is-invalid').addClass('is-valid');
                        $('#msg-3').removeClass('invalid-feedback').addClass('valid-feedback');
                    }else{
                        //$('#btn-signup').attr('disabled',true);
                        $('#mobile').removeClass('is-valid').addClass('is-invalid');
                        $('#msg-3').removeClass('valid-feedback').addClass('invalid-feedback');
                    }
                    setTimeout(function(){
                        $('#spinner-3').attr('hidden',true);
                        $('#msg-3').text(data.ht).attr('hidden',false).show();
                    }, 500);
                }
            });
        });




    });
</script>

<script>
    $(document).ready(function(){
        $('#min_age').on('change', function(){
            var minAgeVal = $(this).val();
            console.log(minAgeVal);
            if(minAgeVal){
                $.ajax({
                    type:'POST',
                    url:'/ajaxLoad/minmaxAge',
                    data:{
                        min_age_val:minAgeVal
                    },
                    dataType: "json",
                    success:function(data,status){
                        //console.log(data);
                        //console.log(status);
                        $('#max_age').html(data.opt);
                    }
                });
            }else{
                $('#max_age').html('<option value="">min-age first</option>');
            }
        });
    });

    $(document).ready(function(){

        $('#min_ht').on('change', function(){
            var minHtVal = $(this).val();
            console.log(minHtVal);
            if(minHtVal){
                $.ajax({
                    type:'POST',
                    url:'/ajaxLoad/minmaxHt',
                    data:{
                        min_ht_val:minHtVal
                    },
                    dataType: "json",
                    success:function(data,status){
                        //console.log(data);
                        //console.log(status);
                        $('#max_ht').html(data.opt);
                    }
                });
            }else{
                $('#max_ht').html('<option value="">min-ht first</option>');
            }
        });
    });

    $(document).ready(function (){
        $('#save-partner-preference').on('click', function () {

            var pp = $('#save-partner-preference').val();
            var myCastes = $('#my-preferred-caste').val();
            var cnb = ($('#cnb').is(':checked'))?1:0;
            var minHt = $('#min_ht').val();
            var maxHt = $('#max_ht').val();
            var minAge = $('#min_age').val();
            var maxAge = $('#max_age').val();
            var pm = ($('#pm').is(':checked'))?1:0;

            console.log(myCastes);

            if(!myCastes.length){
                // alert('Please select the preferred castes');
                // console.log('fucked');
                $.alert({
                    title: 'Alert alert!',
                    content: 'Please select your castes preferences<br> You can select <strong>multiple</strong> <em></em>',
                    icon: 'fa fa-rocket',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    buttons: {
                        okay: {
                            text: 'Okay',
                            btnClass: 'btn-blue'
                        }
                    }
                });
            }else{
                $.ajax({
                    url: "/ajaxUpdate/updatePartnerPreference",
                    method: 'post',
                    data: {
                        pp:pp,
                        mycastes:myCastes,
                        cnb:cnb,
                        min_ht:minHt,
                        max_ht:maxHt,
                        min_age:minAge,
                        max_age:maxAge,
                        pm:pm
                    },
                    dataType: "json",
                    success: function (data, status) {
                        var message = data.msg;
                        setTimeout(function(){
                            toastr.success(data.msg);
                        }, 500);
                        console.log(data);
                        console.log(status);
                    }
                });
            }
            console.log(cnb);
        });
    });
</script>

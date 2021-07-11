
<script>
    $(document).ready(function(){
        $('#min_age').on('change', function(){
            var minAgeVal = $(this).val();
            console.log(minAgeVal);
            if(minAgeVal){
                $.ajax({
                    headers:{
                        'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                        // 'CsrfToken': '65f575dd7ba89dbd08a02a86bf990514eb8182254f9af1299d75cd1f92a7ec1',
                    },
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
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( jqXhr.responseJSON.message );
                        console.log( errorThrown );
                        //console.log( jqXhr.responseText );
                        $.alert({
                            title: 'Security Alert!',
                            content: jqXhr.responseJSON.message + ' Please logout and login after sometime to continue.',
                            icon: 'fa fa-skull',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            buttons: {
                                okay: {
                                    text: 'Okay',
                                    btnClass: 'btn-blue'
                                }
                            }
                        });
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
                    headers:{
                        // 'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                        // 'CsrfToken': '65f575dd7ba89dbd08a02a86bf990514eb8182254f9af1299d75cd1f92a7ec1',
                    },
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
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( jqXhr.responseJSON.message );
                        console.log( errorThrown );
                        //console.log( jqXhr.responseText );
                        $.alert({
                            title: 'Security Alert!',
                            content: jqXhr.responseJSON.message + ' Please logout and login after sometime to continue.',
                            icon: 'fa fa-skull',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            buttons: {
                                okay: {
                                    text: 'Okay',
                                    btnClass: 'btn-blue'
                                }
                            }
                        });
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
                    headers: {
                        'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                        //'CsrfToken': '65f575dd7ba89dbd08a02a86bf990514eb8182254f9af1299d75cd1f92a7ec1',
                    },
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
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( jqXhr.responseJSON.message );
                        console.log( errorThrown );
                        //console.log( jqXhr.responseText );
                        $.alert({
                            title: 'Security Alert!',
                            content: jqXhr.responseJSON.message + ' Please logout and login after sometime to continue.',
                            icon: 'fa fa-skull',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            buttons: {
                                okay: {
                                    text: 'Okay',
                                    btnClass: 'btn-blue'
                                }
                            }
                        });
                    }
                });
            }
            console.log(cnb);
        });
    });
</script>

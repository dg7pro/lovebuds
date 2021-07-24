<script>
    $(document).ready(function(){

        // ==================================
        // Getting Gender
        // Toggle Block to select gender
        // ==================================
        $('#cFor').change(function(){
            var cfor = $(this).children("option:selected").val();
            //alert("You have selected  - " + cfor);
            //console.log(cfor);
            $.ajax({
                headers:{
                    'CsrfToken': $('meta[name="photon"]').attr('content'),
                    // For Testing
                    //'CsrfToken': '65f575dd7ba89dbd08a02a86bf990514eb8182254f9af1299d75cd1f92a7ec1',

                },
                url:"/AjaxRegistration/selectGender",
                method:'POST',
                data:{cfor:cfor},
                dataType:"json",
                success:function (data) {
                    console.log(data);
                    if(data.gender==='ambiguous'){
                        $('#genderDiv').show('slow');
                        $('input[name=gender]').attr('checked', false);
                    }
                    else{
                        $('input[name=gender][value='+data.val+']').attr('checked', true);
                        $('#genderDiv').hide('slow');
                    }
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
        });

    });
</script>
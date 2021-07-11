<script>

    @if($authUser)

    $(document).ready(function(){
        recordProfileVisitor();
    });

    function recordProfileVisitor(){

            var uid = '{{$authUser->id}}';
            var pid = '{{$profile->id}}';

            // console.log(uid);
            // console.log(pid);
            $.ajax({
                headers:{
                    'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "/AjaxActivity/recordVisitor",
                method: 'post',
                data: {
                    uid: uid,
                    pid: pid
                },
                dataType: "json",
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                    //$('#fav-profile').addClass('disabled');
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

    @endif

</script>


<script>
    function loadNotifications() {
        var readrecord = "readrecord";
        $.ajax({
             headers:{
                 'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
             },
            url: "/ajax/unreadNotifications",
            type: "POST",
            data: {
                readrecord:readrecord
            },
            success: function(data,status){
                console.log(data);
                $('#records_content').html(data);
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

        })
    }

    $('.my_notification').on('click', function(){
        loadNotifications();
        console.log('my current notifications');
    });

    function marNotification(id){
        console.log(id);
        $.ajax({
            headers:{
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                // For Testing
                //'CsrfToken': '65f575dd7ba89dbd08a02a86bf990514eb8182254f9af1299d75cd1f92a7ec1',
            },
            url: "/ajax/mar-notification",
            method: 'post',
            data: {
                aid: id
            },
            dataType: "text",
            success: function (data, status) {
                console.log(data);
                console.log(status);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                //console.log( jqXhr.responseJSON.message );
                console.log( errorThrown );
                //console.log( jqXhr.responseText );
                $.alert({
                    title: 'Security Alert!',
                    content: ' Please logout and login after sometime to continue.',
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
</script>

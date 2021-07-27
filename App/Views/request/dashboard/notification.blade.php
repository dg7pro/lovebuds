
<script>
    function loadNotifications() {
        var readrecord = "readrecord";
        $.ajax({
            url: "/ajax/unreadNotifications",
            type: "POST",
            data: {
                readrecord:readrecord
            },
            success: function(data,status){
                console.log(data);
                $('#records_content').html(data);
            }
        });
    }

    $('.my_notification').on('click', function(){
        loadNotifications();
        console.log('my current notifications');
    });

    function marNotification(id){
        console.log(id);
        $.ajax({
            url: "/ajax/mar-notification",
            method: 'post',
            data: {
                aid: id
            },
            dataType: "text",
            success: function (data, status) {
                console.log(data);
                console.log(status);
            }
        });
    }
</script>

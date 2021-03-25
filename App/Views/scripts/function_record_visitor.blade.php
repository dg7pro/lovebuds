<script>
    function recordProfileVisitor(){
        var uid = '{{$profile->user_id}}';
        var pid = '{{$profile->pid}}';


        console.log(uid);
        console.log(pid);
        $.ajax({
            url: "ajax/record-visitor.php",
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
            }
        });
    }
</script>
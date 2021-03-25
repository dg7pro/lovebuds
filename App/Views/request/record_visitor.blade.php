<script>


    function recordProfileVisitor(){

        var uid = '{{$authUser->id}}';
        var pid = '{{$profile->id}}';

        console.log(uid);
        console.log(pid);
        $.ajax({
            url: "/ajax/record-visitor",
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





    $(document).ready(function () {
        recordProfileVisitor();
    });

</script>

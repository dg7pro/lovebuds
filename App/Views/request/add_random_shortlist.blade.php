<script>

    function addRandomShortlistProfiles(){

        var uid = '{{$authUser->id}}';
        var gen = '{{$authUser->gender}}';

        $.ajax({
            url:"/Ajax/add-random-shortlist",
            method:"POST",
            data:{
                uid:uid,
                gen:gen
            },
            dataType: "json",
            success:function(data){
                console.log(data);
            }
        });

    }

    $(document).ready(function () {
        addRandomShortlistProfiles();
    });

</script>

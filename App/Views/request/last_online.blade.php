<script>
    //================================
    // Online Status
    // show user online status
    //================================
    $(document).ready(function () {
        function  update_user_activity(){
            var action = 'update_time';
            $.ajax({
                url:"/Ajax/lastUserActivity",
                method:"POST",
                data:{action:action},
                dataType: "text",
                success:function(data){
                    console.log(data);
                }
            })
        }
        setInterval(function(){
            update_user_activity()
        },15000);
    });
</script>
<script>
    $(document).ready(function(){
        function load_connect_profile(userId){
            //console.log("loaded connected profile call");
            $.ajax({
                url:'ajax/connected-profile.php',
                method:'POST',
                data:{userId:userId},
                dataType:"json",
                success:function(data){
                    //console.log("loaded connected profile ids");
                }
            });
        }
        setTimeout(function() { load_connect_profile({{$_SESSION['id']}}); }, 10000);
    });
</script>
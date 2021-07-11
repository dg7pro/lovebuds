
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId            : '489039115878297',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v10.0'
        });
    };
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
    document.getElementById('shareBtn').onclick = function() {
        FB.ui({
            display: 'popup',
            method: 'share',
            href: 'http://www.jumatrimony.com/home/index',
        }, function(response){
            console.log(response);
            if(response){
                console.log('response came back');
                var fb = true;
                $.ajax({
                    type:'POST',
                    url:'/ajax/setFBAdd',
                    data:{
                        fb:fb
                    },
                    success:function(data,status){
                        console.log(data);
                    }
                });
            }else{
                console.log('no no');
            }
        });
    }
</script>

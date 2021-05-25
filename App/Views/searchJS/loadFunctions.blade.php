<script>

    //====================
    // For first time load
    //====================
    $(document).ready(function(){
        loadNewProfiles();
    });

    //=================
    // Recent Visitor
    //=================
    function loadRecentVisitor(){
        $.ajax({
            url: "/AjaxSearch/load-recent-visitors",
            method: "POST",
            data:{},
            success:function(data){
                $('#recent-profile-visitor').html(data);
                // setTimeout(function(){
                //     $('#loader-icon').addClass('display-off');
                // }, 500);
            }
        });
    }

    $('.recent_visitor').on('click', function(){
        loadRecentVisitor();
        console.log('recent visitor clicked');
    });

    //=====================
    // Shortlisted Profiles
    //=====================
    function loadShortlistedProfiles(){
        $.ajax({
            url: "/AjaxSearch/load-shortlisted-profiles",
            method: "POST",
            data:{},
            success:function(data){
                $('#shortlisted-profiles').html(data);
                // setTimeout(function(){
                //     $('#loader-icon').addClass('display-off');
                // }, 500);
            }
        });
    }

    $('.shortlisted-profiles').on('click', function(){
        loadShortlistedProfiles();
        console.log('shortlisted profiles clicked');
    });

    //=====================
    // New Profiles
    //=====================
    function loadNewProfiles(){
        $.ajax({
            url: "/AjaxSearch/load-new-profiles",
            method: "POST",
            data:{},
            success:function(data){
                $('#new-profiles').html(data);
                // setTimeout(function(){
                //     $('#loader-icon').addClass('display-off');
                // }, 500);
            }
        });
    }

    $('.new-profiles').on('click', function(){
        loadNewProfiles();
        console.log('new profiles clicked');
    });
</script>
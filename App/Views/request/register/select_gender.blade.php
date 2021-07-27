<script>
    $(document).ready(function(){

        // ==================================
        // Getting Gender
        // Toggle Block to select gender
        // ==================================
        $('#cFor').change(function(){
            var cfor = $(this).children("option:selected").val();
            //alert("You have selected  - " + cfor);
            //console.log(cfor);
            $.ajax({
                url:"/AjaxRegistration/selectGender",
                method:'POST',
                data:{cfor:cfor},
                dataType:"json",
                success:function (data) {
                    console.log(data);
                    if(data.gender==='ambiguous'){
                        $('#genderDiv').show('slow');
                        $('input[name=gender]').attr('checked', false);
                    }
                    else{
                        $('input[name=gender][value='+data.val+']').attr('checked', true);
                        $('#genderDiv').hide('slow');
                    }
                }
            });
        });

    });
</script>
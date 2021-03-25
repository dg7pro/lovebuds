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
                url:"/Ajax/selectGender",
                method:'POST',
                data:{cfor:cfor},
                dataType:"json",
                success:function (data) {
                    //console.log(data);
                    if(data.gender==='ambiguous'){
                        //$('#genderDiv').attr('hidden',false);
                        $('#genderDiv').show('slow');
                        $('input[name=gender]').attr('checked', false);
                        //$('#gender').attr('required',true);
                        //$('#blockDiv').fadeIn();
                    }
                    else{

                        $('input[name=gender][value='+data.val+']').attr('checked', true);
                        $('#genderDiv').hide('slow');
                        //$('#genderDiv').attr('hidden',true);
                        //$('#block').attr('required',false);
                        //$('#blockDiv').fadeOut();
                    }

                }
            });
        });

        $("[name=location]").on('click', function () {
            var loc = $(this).val();
            //console.log(loc);
            if(loc==1){
                $('#blockDiv').show('slow');
                $('#block').attr('required',true);
                //$('#blockDiv').fadeIn();
            }
            else{
                $('#blockDiv').hide('slow');
                $('#block').attr('required',false);
                //$('#blockDiv').fadeOut();
            }
        });




    });
</script>
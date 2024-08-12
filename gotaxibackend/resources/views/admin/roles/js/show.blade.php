  <script>
    $(document).ready(function(){
        
            /* Permission */
            $('#fn_view').click(function(){
                if($(this).is(':checked')){
                    $(".fn_view").prop("checked", true);
                    console.log('Yes');
                }else{
                $(".fn_view").prop("checked", false);
                console.log('No');
                }
            });

            /* Permission */
            $('#fn_add').click(function(){
            if($(this).is(':checked')){
                $(".fn_add").prop("checked", true);
                console.log('Yes');
            }else{
                $(".fn_add").prop("checked", false);
                console.log('No');
            }
            });

            /* Permission */
            $('#fn_edit').click(function(){
            if($(this).is(':checked')){
                $(".fn_edit").prop("checked", true);
                console.log('Yes');
            }else{
                $(".fn_edit").prop("checked", false);
                console.log('No');
            }
            });

            /* Permission */
            $('#fn_notify').click(function(){
            if($(this).is(':checked')){
                $(".fn_notify").prop("checked", true);
                console.log('Yes');
            }else{
                $(".fn_notify").prop("checked", false);
                console.log('No');
            }
            });

            /* Permission */
            $('#fn_status').click(function(){
            if($(this).is(':checked')){
                $(".fn_status").prop("checked", true);
                console.log('Yes');
            }else{
                $(".fn_status").prop("checked", false);
                console.log('No');
            }
            });

            /* Permission */
            $('#fn_delete').click(function(){
            if($(this).is(':checked')){
                $(".fn_delete").prop("checked", true);
                console.log('Yes');
            }else{
                $(".fn_delete").prop("checked", false);
                console.log('No');
            }
            });

            /* Permission */
            $('#fn_data').click(function(){
            if($(this).is(':checked')){
                $(".fn_data").prop("checked", true);
                console.log('Yes');
            }else{
                $(".fn_data").prop("checked", false);
                console.log('No');
            }
            });

    });
</script>
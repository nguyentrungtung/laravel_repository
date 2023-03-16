$(function() {
    $('#master_checkbox').on('click', function(e) {
        if ($(this).is(':checked',true))
        {
            $(".sub_chk").prop('checked', true);
        } else {
            $(".sub_chk").prop('checked',false);
        }
    });


    $('.delete_all_checkbox').on('click', function(e) {
        var allVals = [];
        $(".sub_chk:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });
        if(allVals.length <=0)
        {
            alert("Please select row.");
        }  else {
            var check = confirm("Are you sure you want to delete this row?");
            if(check == true){
                e.preventDefault();
                var join_selected_values = allVals.join(",");

                $.ajax({
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: 'ids='+join_selected_values,
                    url: $(this).data('url'),
                    success: function (data) {
                        window.location.reload();
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });
            }
        }
    });

})


$('#create_Btn').click(function(){
    $('#category_form').toggleClass('d-none');
  })

  $('.update_Btn').click(function(){
    $parentNode = $(this).parents("tr");
    $id = $parentNode.find('.id').val();
    $name = $parentNode.find('.name').val();
    $.ajax({
        type : 'get',
        url : '/kitchen/category/update',
        data : {
            'id' : $id,
            'name' : $name
        },
        dataType : 'json',
        success : function(response){
            if (response.status == 'success') {
                location.reload();
            }
        }
    })
  })

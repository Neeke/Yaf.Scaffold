/**
 * @author ciogao@gmail.com
 */
$('.btn-view').click(function(e){
    e.preventDefault();
    $('#scaffoldEdit').modal('show');
});

$('.btn-new').click(function(e){
    e.preventDefault();
    $('#scaffoldEdit').modal('show');
    $("input[type=reset]").trigger("click");
});

$('.btn-edit').click(function(e){
    e.preventDefault();
    $('#scaffoldEdit').modal('show');
    var api_get = $("#api-getrow").attr('data-api');
    var primary_value = $(this).closest('td').attr('data-primary-value');

    $.get(api_get,{primary:primary_value},function(result){
        if (result.code == 1000){
            $.each(result.data,function(key,value){
                $('input[name="'+ key +'"]').val(value);
                $('textarea[name="'+ key +'"]').html(value);
            });
        }else{
            alert(result.msg);
        }
    });
});

$('.btn-remove').click(function(e){
    e.preventDefault();
    var this_btn = $(this);
    var api = $("#api-remove").attr('data-api');
    var primary_value = this_btn.closest('td').attr('data-primary-value');
    $.post(api,{primary:primary_value},function(result){
        if (result.code && result.code == 1000){
            this_btn.closest('tr').remove();
        }else{
            alert(result.msg);
        }
    });
});


$('.btn-modify').click(function(e){
    e.preventDefault();
    var api_modify = $("#api-modify").attr('data-api');

    $.ajax({
        type: "POST",
        url: api_modify,
        data: $("#form-modify").serialize(),
        success: function(result){
            alert(result.msg);
            $('#scaffoldEdit').modal('hide');
        }
    });
});
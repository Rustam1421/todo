$(document).ready(function($) {
    $("#addForm").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "/addTodo",
            method: "POST",
            data: formData,
            success: function (response) {
                console.log(response);
                alert('Задание добавлено');
                window.location.reload();
            }
        })
    });

    $(document).on('click', '.editBtn', function () {
        $('#editModalPopup').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children('td').map(function () {
            return $(this).text();
        }).get();

        console.log(data);


        $('#id').val(data[0]);
        $('#purpose').val(data[1]);
        $('#category').val(data[2]);
        $('#description').val(data[3]);
    });

    $('#editForm').on('submit', function (e) {
        e.preventDefault();

        var id = $('#id').val();

        $.ajax({
            type: 'PUT',
            url: '/todo/' + id,
            data: $('#editForm').serialize(),
            success: function (response) {
                console.log(response);
                $('#editModalPopup').modal('hide');
                alert('Данные обновлены');
                window.location.reload();
            }
        })
    });

    $('#search').on('keyup', function () {
        var value = $(this).val();


        $.ajax({
            url: '/search',
            type: 'GET',
            data:{search:value,},
            success: function (data) {
                // $('#initial_table').hide();
                $('#initial_table').html(data);
            },

            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX error:' + textStatus+ ':' + errorThrown)
            },


        })
    });

    $(document).on('click', '.deleteBtn', function(e) {
        e.preventDefault();

        var todoId = $(this).data('id');

        var button = $(this);
        // console.log(button);
        if (confirm('Are you sure you want to delete todo with id ' + todoId)) {

            $.ajax({
                url: '/todoDelete/' + todoId,
                method: 'delete',
                success: function (data) {
                    button.closest('tr').remove();
                    console.log(data);
                },
                headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
        }
    });
});

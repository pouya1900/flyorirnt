jQuery(document).ready(function ($) {

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    $('.ck_editor').each(function () {

        var id = $(this).attr('id');

        var selectot = "#" + id;
        ClassicEditor
            .create(document.querySelector(selectot))
            .catch(error => {
                console.error(error);
            });

    });




    $(document).on('click', '.btn-danger', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var target = $(this).data('target');
        swal({
                title: "Are you sure!",
                text: "You want to Delete This Mail Details?",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes!",
                confirmButtonColor: "#DD6B55",
                showCancelButton: true,
            },
            function() {
                $.ajax({
                    type: "POST",
                    url: '/admin/'+target+'/delete',
                    data: {id:id},
                    success: function () {
                        swal({
                            type: 'success',
                            title: 'Succesfully deleted!!',
                            text: "You have successfully Deleted this!",
                            showConfirmButton: false,
                            timer: 5000
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }
                });
            });
    });


    $(".thumbnail_input").change(function(){

        var image_holder=$(this).siblings('.thumbnail_image_show');

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                image_holder.attr('src', e.target.result);
            };

            reader.readAsDataURL(this.files[0]);
        }


    });


});

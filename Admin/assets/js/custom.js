$(document).ready(function() {
    $(document).on('click','.delete_products_btn',function(e){
        e.preventDefault();

        var id = $(this).val();

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: "POST",
                    url: "code.php",
                    data: {
                        'product_id': id,
                        'delete_products_btn': true
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 200) {
                            swal("Success!", "Product deleted successfully!", "success");
                            $("#products_table").load(location.href + " #products_table");
                        } else if (response == 500) {
                            swal("Error!", "Something went wrong!", "error");
                        } else if (response == 404) {
                            swal("Error!", "Product not found!", "error");
                        } else {
                            swal("Error!", "Unexpected response: " + response, "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + error);
                        swal("Error!", "AJAX request failed!", "error");
                    }
                });
            }
        });
    });
    $(document).on('click','.delete_category_btn',function(e){
        e.preventDefault();

        var id = $(this).val();

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: "POST",
                    url: "code.php",
                    data: {
                        'category_id': id,
                        'delete_category_btn': true
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 200) {
                            swal("Success!", "category deleted successfully!", "success");
                            $("#category_table").load(location.href + " #category_table");
                        } else if (response == 500) {
                            swal("Error!", "Something went wrong!", "error");
                        } else if (response == 404) {
                            swal("Error!", "category not found!", "error");
                        } else {
                            swal("Error!", "Unexpected response: " + response, "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + error);
                        swal("Error!", "AJAX request failed!", "error");
                    }
                });
            }
        });
    });
    
});

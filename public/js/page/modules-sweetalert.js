"use strict";

$("#swal-1").click(function () {
    swal("Hello");
});

$("#swal-2").click(function () {
    swal("Good Job", "You clicked the button!", "success");
});

$("#swal-3").click(function () {
    swal("Good Job", "You clicked the button!", "warning");
});

$("#swal-4").click(function () {
    swal("Good Job", "You clicked the button!", "info");
});

$("#swal-5").click(function () {
    swal("Good Job", "You clicked the button!", "error");
});

$("#swal-6").click(function () {
    swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover!",
        icon: "question",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yeah, just delete it!",
        cancelButtonText: "Not, return!",
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#dc3545",
        reverseButtons: !0,
    }).then((willDelete) => {
        if (willDelete) {
            swal.fire("Poof! Your imaginary file has been deleted!", {
                icon: "success",
            });

            setTimeout(function () {
                location.reload();
            }, 2000);
        } else {
            swal.fire("Your imaginary file is safe!", {
                icon: "error",
            });
        }
    });
});

$("#swal-7").click(function () {
    swal({
        title: "What is your name?",
        content: {
            element: "input",
            attributes: {
                placeholder: "Type your name",
                type: "text",
            },
        },
    }).then((data) => {
        swal("Hello, " + data + "!");
    });
});

$("#swal-8").click(function () {
    swal("This modal will disappear soon!", {
        buttons: false,
        timer: 3000,
    });
});


// public/js/delete-alert.js

$(document).on('click', '.delete-button', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var actionUrl = form.attr('action');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Yeah, just delete it!",
        cancelButtonText: "Not, return!",
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'Your data has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'There was a problem deleting your data: ' + error,
                        'error'
                    );
                }
            });
        }
    });
});
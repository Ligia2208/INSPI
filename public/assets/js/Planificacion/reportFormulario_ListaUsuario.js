$(document).ready(function () {
    $(".editar-usuario").on("click", function (event) {
        event.preventDefault();
        let form = $(this).closest("form");
        let formData = new FormData(form[0]);

        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (data) {
                if (data.success) {
                    let userRow = $(`tr[data-id="${data.data.id}"]`);
                    userRow.find(".nombre").text($.trim(data.data.nombre));
                    userRow.find(".apellido").text($.trim(data.data.apellido));
                    userRow.find(".correo").text($.trim(data.data.correo));
                    userRow.find(".telefono").text($.trim(data.data.telefono));
                } else {
                    alert("Error al editar usuario.");
                }
            },
            error: function (_xhr, _status, error) {
                console.error("Error:", error);
            }
        });
    });
});

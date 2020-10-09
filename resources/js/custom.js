import axios from "axios";
import swal from "sweetalert";
const bcrypt = require("bcryptjs");

$(function() {
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $(this)
            .next(".custom-file-label")
            .html(fileName);
    });

    $("#title").on("keyup", function() {
        $("#char-count").text($("#title").val().length);
    });

    $(".rm-b-attach").click(function() {
        swal({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(value => {
            if (value) {
                let id = $(this).data("id");
                let attach = $(this).data("attach");
                axios
                    .delete(`/board/agenda/${id}/${attach}`)
                    .then(res => {
                        swal(
                            "Success!",
                            "Attachment has been deleted",
                            "success"
                        )
                            .then(val => window.location.reload())
                            .catch(val => console.log("something went wrong!"));
                    })
                    .catch(err => {
                        swal("Ooops!", "Something went wrong", "error");
                    });
            }
        });
    });

    $(".rm-c-attach").click(function() {
        swal({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(value => {
            if (value) {
                let id = $(this).data("id");
                let attach = $(this).data("attach");
                axios
                    .delete(`/committee/agenda/${id}/${attach}`)
                    .then(res => {
                        swal(
                            "Success!",
                            "Attachment has been deleted",
                            "success"
                        )
                            .then(val => window.location.reload())
                            .catch(val => console.log("something went wrong!"));
                    })
                    .catch(err => {
                        swal("Ooops!", "Something went wrong", "error");
                    });
            }
        });
    });

    $("#rm-board-agenda").click(function() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this agenda!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(value => {
            if (value) {
                $("#form-rm-agenda").submit();
            }
        });
    });

    $("#btn-select-all").click(function() {
        var state = $(this).text() == "SELECT ALL" ? true : false;
        var btnText =
            $(this).text() == "SELECT ALL" ? "UNSELECT ALL" : "SELECT ALL";

        $(".checkBox").prop("checked", state);
        $(this).text(btnText);
    });

    $("#cb-select-all").click(function() {
        var state = $(this).is(":checked");
        $(".checkBox").prop("checked", state);
    });

    $("#btn-end-meeting").click(function() {
        swal({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(value => {
            if (value) {
                $("#form-end-meeting").submit();
            }
        });
    });

    $("#btn-password-reset").click(function() {
        var password = document.getElementById("password");
        var hashed = document.getElementById("token");
        var confirmation = document.getElementById("confirmation");
        var old = document.getElementById("old_password");

        if (password.value === confirmation.value) {
            if (password.value == old.value) {
                swal(
                    "Ooops!",
                    "New password can't be same as the old password!",
                    "error"
                );
            } else {
                var salt = bcrypt.genSaltSync(10);
                hashed.value =
                    btoa(btoa(btoa(password.value))) +
                    "." +
                    btoa(btoa(btoa(Math.floor(Math.random() * 99999 + 10000))));
                password.value = bcrypt.hashSync(password.value, salt);

                var old_hash = bcrypt.hashSync(old.value, salt);
                var splitted = old_hash.split(".");
                splitted[1] = btoa(btoa(btoa(old.value)));
                old.value = splitted.join(".");

                $("#form-password-reset").submit();
            }
        } else {
            swal("Ooops!", "Password doesnt match!", "error");
        }
    });
});

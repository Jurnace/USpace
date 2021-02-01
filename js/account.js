"use strict";
$("#save").on("click", function() {
    const oldPassword = $("#old").val();
    const newPassword = $("#new").val();

    if(oldPassword === "") {
        alert("Please enter your old password");
        return;
    }

    if(newPassword === "") {
        alert("Please enter your new password");
        return;
    }

    const thisButton = $(this);
    // disable the button while waiting for reply
    thisButton.prop("disabled", "true");

    // prepare the request body
    const data = new FormData();
    data.append("oldPassword", oldPassword);
    data.append("newPassword", newPassword);

    // make the POST request
    fetch("/updateaccount.php", {
        method: "POST",
        body: data
    }).then(function(response) {
        return response.text();
    }).then(function(body) {
        thisButton.removeAttr("disabled");
        // 0 = incorrect password, 1 = success
        if(body === "0") {
            alert("Incorrect password");
        } else {
            alert("Password has been changed");
            // go back to index.php
            window.location.replace("/index.php");
        }
    }).catch(function(e) {
        thisButton.removeAttr("disabled");
        alert("Unable to change your password");
        console.log(e);
    });
});

// trigger click on the button when enter is pressed
$("#new").on("keyup", function(e) {
    if(e.key === "Enter") {
        $("#save").trigger("click");
    }
});
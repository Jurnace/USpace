"use strict";
$("#cancel").on("click", function() {
    // go back to index.php
    window.location.replace("/index.php");
});

$("#save").on("click", function() {
    const name = $("#name").val();
    const age = $("#age").val();
    const education = $("#education").val();
    const hobbies = $("#hobbies").val();
    const languages = $("#languages").val();
    const experience = $("#experience").val();
    const bio = $("#bio").val();
    const files = $("#file").prop("files");

    if(name === "") {
        alert("Please enter your name");
        return;
    }

    if(age === "") {
        alert("Please enter your age");
        return;
    }

    const nAge = parseInt(age);

    // check if age is a number
    if(isNaN(nAge) || !isFinite(age)) {
        alert("Please enter a valid age");
        return;
    }

    if(nAge < 1) {
        alert("Please enter a valid age");
        return;
    }

    if(education === "") {
        alert("Please enter your education");
        return;
    }

    if(hobbies === "") {
        alert("Please enter your hobbies");
        return;
    }

    if(languages === "") {
        alert("Please enter your languages");
        return;
    }

    if(experience === "") {
        alert("Please enter your experience");
        return;
    }

    if(bio === "") {
        alert("Please enter your bio");
        return;
    }

    if(files.length === 0) {
        alert("Please select your avatar");
        return;
    }

    const thisButton = $(this);
    // disable the button while waiting for reply
    thisButton.prop("disabled", "true");

    // prepare the request body
    const data = new FormData();
    data.append("name", name);
    data.append("age", age);
    data.append("education", education);
    data.append("hobbies", hobbies);
    data.append("languages", languages);
    data.append("experience", experience);
    data.append("bio", bio);
    data.append("avatar", files[0]);

    // make the POST request
    fetch("/updateprofile.php", {
        method: "POST",
        body: data
    }).then(function(response) {
        return response.text();
    }).then(function(body) {
        thisButton.removeAttr("disabled");
        // 0 = error occured, 1 = success
        if(body === "0") {
            alert("Unable to update your profile");
        } else {
            window.location.replace("/index.php");
        }
    }).catch(function(e) {
        thisButton.removeAttr("disabled");
        alert("Unable to update your profile");
        console.log(e);
    });
});

$("#file").on("change", function(e) {
    const fileName = e.target.files[0].name;
    // set the label text to the file name after a file is selected
    $(this).next(".custom-file-label").html(fileName);
});
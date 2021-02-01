"use strict";
// for the "Login" button
$("#blogin").on("click", function() {
    const username = $("#lusername").val();
    const password = $("#lpassword").val();

    if(username === "") {
        alert("Please enter your username");
        return;
    }

    if(password === "") {
        alert("Please enter your password");
        return;
    }

    const thisButton = $(this);
    // disable the button while waiting for reply
    thisButton.prop("disabled", "true");

    // prepare the request body
    const data = new FormData();
    data.append("username", username);
    data.append("password", password);

    // make the POST request
    fetch("/login.php", {
        method: "POST",
        body: data
    }).then(function(response) {
        return response.text();
    }).then(function(body) {
        thisButton.removeAttr("disabled");
        // 0 = incorrect username/password, 1 = success
        if(body === "0") {
            alert("Incorrect username or password");
        } else {
            window.location.replace("/index.php");
        }
    }).catch(function(e) {
        thisButton.removeAttr("disabled");
        alert("Unable to login");
        console.log(e);
    });
});

// for the "Sign Up" button
$("#bsignup").on("click", function() {
    const name = $("#sname").val();
    const username = $("#susername").val().toLowerCase();
    const email = $("#semail").val();
    const password = $("#spassword").val();

    if(name === "") {
        alert("Please enter your name");
        return;
    }

    if(username === "") {
        alert("Please enter your username");
        return;
    }

    if(email === "") {
        alert("Please enter your email");
        return;
    }

    if(password === "") {
        alert("Please enter your password");
        return;
    }

    if(/\s/.test(username)) {
        alert("Username cannot contain spaces");
        return;
    }

    const thisButton = $(this);
    // disable the button while waiting for reply
    thisButton.prop("disabled", "true");

    // prepare the request body
    const data = new FormData();
    data.append("name", name);
    data.append("username", username);
    data.append("email", email);
    data.append("password", password);

    // make the POST request
    fetch("/signup.php", {
        method: "POST",
        body: data
    }).then(function(response) {
        return response.text();
    }).then(function(body) {
        thisButton.removeAttr("disabled");
        // 0 = error occured, 1 = username exists, 2 = email exists, 3 = success
        if(body === "0") {
            alert("Failed to sign up");
        } else if(body === "1") {
            alert("Username exists");
        } else if(body === "2") {
            alert("Email is in use");
        } else {
            window.location.replace("/index.php");
        }
    }).catch(function(e) {
        thisButton.removeAttr("disabled");
        alert("Failed to sign up");
        console.log(e);
    });
});

// when the Enter key is pressed in the text field before the button, the button is clicked
$("#lpassword").on("keyup", function(e) {
    if(e.key === "Enter") {
        $("#blogin").trigger("click");
    }
});

$("#spassword").on("keyup", function(e) {
    if(e.key === "Enter") {
        $("#bsignup").trigger("click");
    }
});
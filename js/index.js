"use strict";

let showResult = false;
// a 1.5 second delay
let delay;
// an AbortController, to cancel a fetch() request
let controller;

$("#search").on("input", function(e) {
    const value = $(this).val().trim();
    const result = $("#result");

    if(value === "") {
        if(showResult) {
            // remove the result box
            result.addClass("d-none");
            showResult = false;
        }
        return;
    }

    // remove the old timeout
    clearTimeout(delay);
    if(controller) {
        // cancel the fetch() request
        controller.abort();
    }

    if(!showResult) {
        // make the result box visible
        result.removeClass("d-none");
        showResult = true;
    }

    // show "Searching..." in the result box
    result.html('<li class="list-group-item py-2">Searching...</li>');

    // prepare the request body
    const data = new FormData();
    data.append("query", value);

    // make the POST request
    delay = setTimeout(function() {
        controller = new AbortController();
        fetch("search.php", {
            method: "POST",
            body: data,
            signal: controller.signal
        }).then(function(response) {
            return response.text();
        }).then(function(body) {
            // put the response text in the result box
            result.html(body);
        });
    }, 1500);
});

document.addEventListener("click", function(event) {
    if(event.target.parentElement) {
        if(event.target.parentElement.id !== "result") {
            // hide the result box if the user clicks outside of it
            if(showResult) {
                $("#result").addClass("d-none");
                showResult = false;
            }
        }
    }
});
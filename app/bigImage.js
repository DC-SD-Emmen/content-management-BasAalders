// ready

$(document).ready(function() {
    //on focused function .screenshot

    $(".screenshot").on("focus", function() {
        $("html, body").animate({ scrollTop: 0 }, 500);
    });
});
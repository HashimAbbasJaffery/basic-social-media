$(document).ready(function () {
    let helper = "none";
    $(".likes").mouseenter(function() {
        let id = $(this).attr("data-id");
        $(`.liked-persons[data-id=${id}]`).css("display", "block");
    }).mouseleave(function() {
        let id = $(this).attr("data-id");
        $(`.liked-persons[data-id=${id}]`).css("display", 'none').fadeOut();
    })

    $(".show-comments").click(function() {
        let status = true;
            let id = $(this).attr("data-id");

            if(helper == "none") {
                $(`.comment[data-id=${id}]`).css("display", "block");
                helper = "block";
            } else {
                $(`.comment[data-id=${id}]`).css("display", "none");
                helper = "none";
            }
    });
    $(".reply").click(function() {
        let id = $(this).attr("data-id");
        $(`.add-comment[data-id=${id}] input`).attr("placeholder", "You are replying to hashim")
    })
});
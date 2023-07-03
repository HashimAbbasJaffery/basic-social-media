
        $(document).ready(function() {
            let mode = 0;
            function noWork() {

            }
            $(".modeBtn").click(function() {
                if(mode == 0) {
                    $(".circle").animate({marginLeft: '22px'}, 200);
                    $("html").css("filter", "invert(1)");
                    mode = 1;
                } else { 
                    $(".circle").animate({marginLeft: '2px'}, 200);
                    $("html").css("filter", "none");
                    mode = 0;
                }
            })
        });
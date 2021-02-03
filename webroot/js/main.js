$(document).ready(function() {
    $(".NewsBox").delegate(".SeeMoreBtn", "click", function() {
//$(".SeeMoreBtn").delegate(this, "click", function() {
        if ($(this).hasClass('ActiveBtn')) {
            $(".NewsDesc").slideUp('slow');
            $(this).parents(".NewsWrap").animate({
                "width": "98%",
                "margin-top": "0",
                "margin-bottom": "0",
                "margin-right": "1%",
                "margin-left": "1%",
            }, "slow");
            $(this).removeClass("ActiveBtn");
        } else {
            $(".SeeMoreBtn").removeClass("ActiveBtn");
            $(".NewsDesc").slideUp('fast');
            $(".NewsWrap").animate({
                "width": "98%",
                "margin": "0 auto"
            }, "fast");
            $(".NewsWrap").removeAttr('style');
            $(this).addClass("ActiveBtn");
            $(this).parents(".NewsWrap").animate({
                "width": "100%",
                "margin-top": "10px",
                "margin-bottom": "10px",
                "margin-right": "0",
                "margin-left": "0",
            }, "slow");
            $(this).siblings(".NewsTitle").children(".NewsDesc").slideDown('slow');
        }
    });

    $("a.SharingIcon").click(function() {
        window.open(this.href, 'targetWindow', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350');
        return false;
    });
    $(".Search").click(function() {
        $(".SearchBox").slideDown();
        $(".SearchBar").focus();
    });
    
    $(".SearchBar").blur(function() {
        $(".SearchBox").slideUp();
    });
    
});


$(document).ready(function(){

    $(".aanmelden.standhouders").on("click", function(){
        $(".form-overlay").fadeIn(700);
        $(".form-wrapper").fadeIn(700);
        $("form input[name=winkeliersvereniging]").val(0);
        $(".gevel").hide();
        $(".text-standhouders").show();
	    ga('send', 'event', 'campaign', 'aanmelden-step1', 'step1-standhouders');
    });

    $(".aanmelden.winkeliersvereniging").on("click", function(){
        $(".form-overlay").fadeIn(700);
        $(".form-wrapper").fadeIn(700);
        $("form input[name=winkeliersvereniging]").val(1);
        $(".gevel").show();
        $(".text-standhouders").hide();
	    ga('send', 'event', 'campaign', 'aanmelden-step1', 'step1-winkeliersvereniging');
    });

    $(".close").on("click", function(){
        $(".form-overlay").fadeOut(700);
        $(".form-wrapper").fadeOut(700);
	ga('send', 'event', 'campaign', 'aanmelden-close', 'close');
    });

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        function doOnOrientationChange()
        {
            switch(window.orientation)
            {
              case -90:
              case 90:
                $(".aanmelden").addClass("landscape");
                $(".logo").addClass("landscape");
                $(".footer").addClass("landscape");
                break;
              default:
                $(".aanmelden").removeClass("landscape");
                $(".logo").removeClass("landscape");
                $(".footer").removeClass("landscape");
                break;
            }
        }

        window.addEventListener('orientationchange', doOnOrientationChange);

        // Initial execution if needed
        doOnOrientationChange();
    }


    function hasFormValidation() {
        return (typeof document.createElement( 'input' ).checkValidity == 'function');
    };

    required = ['bedrijfsnaam', 'voornaam', 'achternaam', 'straat', 'postcode', 'huisnummer', 'woonplaats', 'telefoon', 'email'];
    for(var x=0;x<required.length;x++){
        $(".test-form input[name="+required[x]+"]").on("focus keypress keydown paste", function(){

            var self = $(this);
            setTimeout(function(){
                if(self.attr("name") == "huisnummer"){
                    if(self.val().length >= 1 ){
                        self.removeClass("error");
                    } else {
                        self.addClass("error");
                    }
                } else {
                    if(self.val().length > 1 ){
                        self.removeClass("error");
                    } else {
                        self.addClass("error");
                    }
                }
            }, 10);
        });
    }

    $(".test-form input[type=button]").on("click", function(event){
	    event.preventDefault();

        for(var x=0;x<required.length;x++){
            if ( $(".test-form input[name="+required[x]+"]").val().length < 1 )
                {
                $(".test-form input[name="+required[x]+"]").addClass("error");
                }
            else
            {
                $(".test-form input[name="+required[x]+"]").removeClass("error");
            }
        }

        $.ajax({
            type: "POST",
            url: "/aanmelding/markt",
            data: $(".test-form").serialize(),
            success: function(data) {
                alert("U aanmelding is succesvol ontvangen. We hebben u zojuist een mail gestuurd. Mocht u deze niet ontvangen hebben graag een e-mail sturen naar standhouders@directevents.nl");
                $(".form-overlay").fadeOut(700);
                $(".form-wrapper").fadeOut(700);
                setTimeout(function(){
                    $(window).trigger("resize");
                }, 710);
            },
            error: function (jXHR, textStatus, errorThrown) {
                if(jXHR.status == 503)
                {
                    alert("Nog niet alle velden zijn goed ingevuld.");
                }
                else if (jXHR.status == 404)
                {
                    alert("We konden de opgegeven markt niet vinden. Wij zouden u willen vragen om een e-mail te sturen naar standhouders@directevents.nl.");
                }
                else
                {
                    alert("Er is iets fout gegaan. Onze excuses voor het ongemak. Wij zouden u willen vragen om een e-mail te sturen naar standhouders@directevents.nl als dit probleem zich voor blijft doen.");
                }
            }
        });
    });
    $("body").height($(document).height());
    $(".all").height($(document).height());

    setTimeout(function(){
        $(".beplanting").css("left", $(".beplanting").width()+"px");
        $(".glas-drinken").css("right", $(".glas-drinken").width()+"px");
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $(".dromenvanger").css("right", "30px");
        } else {
            $(".dromenvanger").css("right", "70px");
        }

        setTimeout(function(){
            $(".footer").fadeIn(700);
            $(".bord").css("top", $(".bord").height()+"px");
            setTimeout(function(){
                // $(".dromenvanger").css("top", $(".dromenvanger").height()+"px");
                $(".round").fadeIn(500);
            }, 300);
        }, 1500);
        $(window).resize(function(){
            $(".beplanting").css("left", $(".beplanting").width()+"px");
            $(".glas-drinken").css("right", $(".glas-drinken").width()+"px");
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                $(".dromenvanger").css("right", "30px");
            } else {
                $(".dromenvanger").css("right", "70px");
            }
            $(".bord").css("top", $(".bord").height()+"px");
            $("body").height($(document).height());
            $(".all").height($(document).height());
        });
    }, 1000);
});

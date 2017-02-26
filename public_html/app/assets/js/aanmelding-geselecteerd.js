$(document).ready(function(){

    $(".exportToExcel").on("click", function(){
        var pathArray = window.location.pathname.split( '/' );
        window.open("/markten/" + pathArray[2] + "/export/" + pathArray[3], '_blank');
    });

    function getJsonData(type, url, $data)
    {
        var returnValue = '';
        $.post({
            type: type,
            url: url,
            data: $data
        })
        .done(function(data){
            return data;
        })
        .fail(function(data){
            returnValue = false;
        });

        return returnValue;
    }

    $(".markt-item").on("click", function(){
        var $id = $(this).find("a").data("id");
        var $data = { _token: $(".token").text(), id: $id };

        data = getJsonData("POST", "getStandhoudersForMarkt", $data);
        $(".standhouders-table tbody").empty();

        $standhouders = data.standhouders;
        $html = '';
        for(var i = 0;i < $standhouders.length; i++)
        {
            $html += "<tr>";
            $html += "<td>"+ $standhouders[i].id +"</td>";
            $html += "<td>"+ $standhouders[i].Bedrijfsnaam +"</td>";
            $html += "<td>"+ $standhouders[i].Voornaam + " " + $standhouders[i].Achternaam +"</td>";
            $html += "<td>"+ $standhouders[i].Telefoon +"</td>";
            $html += "<td>"+ $standhouders[i].Email +"</td>";
            $html += "<td>"+ $standhouders[i].Website +"</td>";
            $html += "</tr>";
        }

        $(".standhouders-table tbody").append($html);
    });

    $(".standhouders-table tr.unseen-row").on("click", function(){
        $(this).removeClass("unseen-row");

        var $standhouder_id = $(this).data("id");
        var $markt_id = $(this).closest("table").data("marktid");

        setStandhouderSeen($markt_id, $standhouder_id, 1)
    });

    $(".standhouders-table tr input.seen").on("click", function(){
        var self = $(this);

        setTimeout(function(){
            var $markt_id = self.closest("table").data("marktid");
            var id = self.closest("tr").data("id");
            if(self.prop("checked")){
                setStandhouderSeen($markt_id, $standhouder_id, 1)
                self.closest("tr").removeClass("unseen-row");
            } else {
                setStandhouderSeen($markt_id, $standhouder_id, 0)
                self.closest("tr").addClass("unseen-row");
            }
        }, 20);
    });

    function setStandhouderSeen($markt_id, $standhouder_id, $value)
    {
        var $data = { _token: $(".token").text(), markt_id: $id, standhouder_id: $standhouder_id, value: $value };

        data = getJsonData("POST", "/markt/setStandhouderSeen", $data);
    }

    $(".adjust").on("click", function(){
        var $markt_id = $(this).closest("table").data("marktid");
        var $standhouder_id = $(this).closest("tr").data("id");
        var $data = { _token: $(".token").text(), markt_id: $markt_id ,standhouder_id: $standhouder_id};

        $.post({
            type: "POST",
            url: "/markt/getStandhouder",
            data: $data
        })
        .done(function(data){
            // contact gegevens
            $(".standhouder-wijzig input[name=id]").val(data.standhouder.id);
            $(".standhouder-wijzig input[name=Bedrijfsnaam]").val(data.standhouder.Bedrijfsnaam);
            $(".standhouder-wijzig input[name=Voornaam]").val(data.standhouder.Voornaam);
            $(".standhouder-wijzig input[name=Achternaam]").val(data.standhouder.Achternaam);
            $(".standhouder-wijzig input[name=Email]").val(data.standhouder.Email);
            $(".standhouder-wijzig input[name=Telefoon]").val(data.standhouder.Telefoon);
            $(".standhouder-wijzig input[name=Website]").val(data.standhouder.Website);

            // adres gegevens
            $(".standhouder-wijzig input[name=Straat]").val(data.standhouder.Straat);
            $(".standhouder-wijzig input[name=Postcode]").val(data.standhouder.Postcode);
            $(".standhouder-wijzig input[name=Huisnummer]").val(data.standhouder.Huisnummer);
            $(".standhouder-wijzig input[name=Toevoeging]").val(data.standhouder.Toevoeging);
            $(".standhouder-wijzig input[name=Woonplaats]").val(data.standhouder.Woonplaats);

            $(".standhouder-wijzig input[name=afgesproken_prijs]").prop("checked", ((data.standhouderMarktData.afgesproken_prijs) ? true : false));
            $(".standhouder-wijzig input[name=afgesproken_bedrag]").val(data.standhouderMarktData.afgesproken_bedrag);

            // Markt gegevens
            $(".standhouder-wijzig input[name=foodNonfood]").each(function(){
                if ($(this).val() == data.standhouderMarktData.type) $(this).prop("checked", true);
            });
            $(".standhouder-wijzig input[name=kraam]").val(data.standhouderMarktData.kraam);
            $(".standhouder-wijzig input[name=grondplek]").val(data.standhouderMarktData.grondplek);
            $(".standhouder-wijzig input[name=bedrag]").val(data.standhouderMarktData.bedrag);
            $(".standhouder-wijzig input[name=betaald]").prop("checked", ((data.standhouderMarktData.betaald) ? true : false));


            $(".standhouder-wijzig input[name=anders]").prop("checked", ((data.standhouderMarktData.anders) ? true : false));
            $(".standhouder-wijzig input[name=baby-kleding]").prop("checked", ((data.standhouderMarktData["baby-kleding"]) ? true : false));
            $(".standhouder-wijzig input[name=brocante]").prop("checked", ((data.standhouderMarktData.brocante) ? true : false));
            $(".standhouder-wijzig input[name=dames-kleding]").prop("checked", ((data.standhouderMarktData["dames-kleding"]) ? true : false));
            $(".standhouder-wijzig input[name=dierenspullen]").prop("checked", ((data.standhouderMarktData.dierenspullen) ? true : false));
            $(".standhouder-wijzig input[name=fashion-accessoires]").prop("checked", ((data.standhouderMarktData["fashion-accessoires"]) ? true : false));
            $(".standhouder-wijzig input[name=selected]").prop("checked", ((data.standhouderMarktData.selected) ? true : false));
            $(".standhouder-wijzig input[name=grote-maten]").prop("checked", ((data.standhouderMarktData["grote-maten"]) ? true : false));
            $(".standhouder-wijzig input[name=heren-kleding]").prop("checked", ((data.standhouderMarktData["heren-kleding"]) ? true : false));
            $(".standhouder-wijzig input[name=kinder-kleding]").prop("checked", ((data.standhouderMarktData["kinder-kleding"]) ? true : false));
            $(".standhouder-wijzig input[name=kunst]").prop("checked", ((data.standhouderMarktData.kunst) ? true : false));
            $(".standhouder-wijzig input[name=lifestyle]").prop("checked", ((data.standhouderMarktData.lifestyle) ? true : false));
            $(".standhouder-wijzig input[name=schoenen]").prop("checked", ((data.standhouderMarktData.schoenen) ? true : false));
            $(".standhouder-wijzig input[name=sieraden]").prop("checked", ((data.standhouderMarktData.sieraden) ? true : false));
            $(".standhouder-wijzig input[name=stroom]").prop("checked", ((data.standhouderMarktData.stroom) ? true : false));
            $(".standhouder-wijzig input[name=tassen]").prop("checked", ((data.standhouderMarktData.tassen) ? true : false));
            $(".standhouder-wijzig input[name=woon-accessoires]").prop("checked", ((data.standhouderMarktData["woon-accessoires"]) ? true : false));

            // markt gegevens
            // if(data.standhou)

            $(".overlay").show();
            $(".standhouder-wijzig").show();
        })
        .fail(function(data){
            alert("failed to get data");
        });
    });

    $(".standhouderAdjustForm").on("submit", function(e){
        e.preventDefault();
        e.stopPropagation();

        var self = $(this);

        var postData = {markt_id: $(".standhouders-table").attr("data-marktid"), _token: $(".token").text()};
        $(".standhouderAdjustForm input[type=checkbox]").each(function(){
            if (!$(this).prop("checked")) {
                postData[$(this).attr("name")] = 0;
            }
        });

        $.post({
            type: "POST",
            url: "/markt/changeStandhouder",
            data: (self.serialize()+"&"+$.param(postData))
        })
        .done(function(data){
            // var dataParsed = JSON.parse(data);
            alert(JSON.parse(data).message);
        })
        .fail(function(data){
            alert(JSON.parse(data).message);
        });
    });

    $(".download-single-invoice").on("click", function(){
        var $data = {
                _token: $(".token").text(),
                markt_id: $(".standhouders-table").attr("data-marktid"),
                standhouder_id: $(this).closest(".standhouderAdjustForm").find("input[name=id]").val()
            };

        $.post({
            type: "POST",
            url: "/markt/downloadInvoice",
            data: $data
        })
        .done(function(data){
            $parsed = JSON.parse(data);
            window.open("/markt/downloadInvoice/"+$parsed.year+"/"+$parsed.factuurnummer);
        })
        .fail(function(data){
            alert(JSON.parse(data).message);
        });
    });

    $(".close-standhouder-wijzig, .cancel-standhouder-change").on("click", function(){
        $(".overlay").hide();
        $(".standhouder-wijzig").hide();
    });

    $(".standhouders-table tr input.selected").on("click", function(){
        var self = $(this);

        setTimeout(function(){
            var $markt_id = self.closest("table").data("marktid");
            var $standhouder_id = self.closest("tr").data("id");
            if(self.prop("checked")){
                setStandhouderSelected($markt_id, $standhouder_id, 1)
                self.closest("tr").addClass("selected-row");
            } else {
                setStandhouderSelected($markt_id, $standhouder_id, 0)
                self.closest("tr").removeClass("selected-row");
            }
        }, 20);
    });

    function setStandhouderSelected($markt_id, $standhouder_id, $value)
    {
        var $data = { _token: $(".token").text(), markt_id: $markt_id, standhouder_id: $standhouder_id, value: $value };

        data = getJsonData("POST", "/markt/setStandhouderSelected", $data);
    }

    $(".standhouders-table tr.unseen-row").on("click", function(){
        $(this).removeClass("unseen-row");

        var $standhouder_id = $(this).data("id");
        var $markt_id = $(this).closest("table").data("marktid");

        setStandhouderSeen($markt_id, $standhouder_id, 1)
    });

    $(".standhouders-table tr input.seen").on("click", function(){
        var self = $(this);

        setTimeout(function(){
            var $markt_id = self.closest("table").data("marktid");
            var id = self.closest("tr").data("id");
            if(self.prop("checked")){
                setStandhouderSeen($markt_id, $standhouder_id, 1)
                self.closest("tr").removeClass("unseen-row");
            } else {
                setStandhouderSeen($markt_id, $standhouder_id, 0)
                self.closest("tr").addClass("unseen-row");
            }
        }, 20);
    });

    function setStandhouderSeen($markt_id, $standhouder_id, $value)
    {
        var $data = { _token: $(".token").text(), markt_id: $markt_id, standhouder_id: $standhouder_id, value: $value };

        data = getJsonData("POST", "/markt/setStandhouderSeen", $data);
    }

    $(".standhouders-table tr input.betaald").on("click", function(e){

        var self = $(this);

        setTimeout(function(){
            var standhouder_id = self.closest("tr").data("id");
            var markt_id = $(".standhouders-table").attr("data-marktid");
            var $data = { _token: $(".token").text(), markt_id: markt_id, standhouder_id: standhouder_id, value: ((self.prop("checked")) ? 1 : 0 ) };

            $.post({
                type: "POST",
                url: "/markt/setStandhouderBetaald",
                data: $data
            })
            .done(function(data){
                // self.prop("checked", !self.prop("checked"));
                alert(JSON.parse(data).message);
            })
            .fail(function(data){
                e.stopPropagation();
                alert(JSON.parse(data).message);
            });
        }, 20);
    });

    function setStandhouderBetaald($markt_id, $standhouder_id, $value)
    {
        var $data = { _token: $(".token").text(), markt_id: $markt_id, standhouder_id: $standhouder_id, value: $value };

        data = getJsonData("POST", "/markt/setStandhouderBetaald", $data);
    }

    $(".send-single-invoice").on("click", function(){
        $(".standhouder-wijzig").hide();
        $(".popup-single-invoice").show();
    });

    $(".cancel-standhouder-send-invoice").on("click", function(){
        $(".popup-single-invoice").hide();
        $(".standhouder-wijzig").show();
    });

    $(".send-single-invoice-definitief").on("click", function(){
        var standhouder_id = $(".standhouder-wijzig").find("input[name=id]").val();
        var markt_id = $(".standhouders-table").attr("data-marktid");
        var $data = { _token: $(".token").text(), markt_id: markt_id, standhouder_id: standhouder_id };

        $.post({
            type: "POST",
            url: "/markt/sendInvoiceForStandhouder",
            data: $data
        })
        .done(function(data){
            // self.prop("checked", !self.prop("checked"));
            alert(JSON.parse(data).message);
            $(".popup-single-invoice").hide();
            $(".standhouder-wijzig").show();
        })
        .fail(function(data){
            e.stopPropagation();
            alert(JSON.parse(data).message);
        });
    });

    function scrolify(tblAsJQueryObject, height){
        var oTbl = tblAsJQueryObject;

        // for very large tables you can remove the four lines below
        // and wrap the table with <div> in the mark-up and assign
        // height and overflow property
        var oTblDiv = $("<div/>");
        oTblDiv.css('height', height);
        oTblDiv.css('overflow','scroll');
        oTblDiv.css('overflow-x','hidden');
        oTblDiv.css('width', oTbl.width()+'px');
        oTbl.wrap(oTblDiv);

        // save original width
        oTbl.attr("data-item-original-width", oTbl.width());

        oTbl.find('thead tr td').each(function(){
            $(this).attr("data-item-original-width",$(this).width());
        });

        oTbl.find('tbody tr:eq(0) td').each(function(){
            $(this).attr("data-item-original-width",$(this).width());
        });

        // clone the original table
        var newTbl = oTbl.clone();

        newTbl.find('thead tr th').each(function(index){
            // $(this).width($(this).attr("data-item-original-width"));
            $(this).width(oTbl.find("thead tr th:eq("+index+")").outerWidth()).css("box-sizigin", "border-box");
        });

        // remove table body from new table
        newTbl.find('tbody tr').remove();

        oTbl.parent().parent().prepend(newTbl);
        newTbl.wrap("<div/>");

        // replace ORIGINAL COLUMN width
        newTbl.width(newTbl.attr('data-item-original-width'));
        newTbl.find('thead tr td').each(function(){
            $(this).width($(this).attr("data-item-original-width"));
        });
        oTbl.width(oTbl.attr('data-item-original-width'));
        oTbl.find('tbody tr:eq(0) td').each(function(){
            $(this).width($(this).attr("data-item-original-width"));
        });

        // remove table header from original table
        oTbl.find('thead tr').remove();

        newTbl.css("margin-bottom", "0px");

        $(".table-responsive").css("max-height", "none");
    }

    scrolify($('.standhouders-table'), 650);
});

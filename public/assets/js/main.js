    const siteRoot = "http://127.0.0.1:8000/";
    const modal = {
        selector : "#modal",
        show :function(){
            $(this.selector).removeClass("d-none");
            $(this.selector).addClass("d-flex");
        } ,
        hide : function(){
            $(this.selector).addClass("d-none");
            $(this.selector).removeClass("d-flex");
        },
        set : function(content){
            $(this.selector + "-body") .html(content);
        },
    };
    function setUpAjaxHeader(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
    setUpAjaxHeader();
    function onPage(name){
        return location.href.indexOf(name) !== -1;
    }
    function valueAcceptable(control){
        control.element.removeClass("error-border");
        control.element.addClass("success-border");
        control.messageSpan.removeClass("d-block");
        control.messageSpan.addClass("d-none");
    }

    function valueUnacceptable(control){
        control.element.removeClass("success-border");
        control.element.addClass("error-border");
        control.messageSpan.removeClass("d-none");
        control.messageSpan.addClass("d-block");
    }

    function addBlurEventToControls(controls){
        for(let control of controls){
            control.element.on("blur", function(){
                if(control.element.val().match(control.regex)){
                    valueAcceptable(control);
                }else {
                    valueUnacceptable(control);
                }
            });
        }
    }

    function formValuesAcceptable(controls){
        let errorNum = 0;
        for(let control of controls){
            if(!control.element.val().match(control.regex)){
                valueUnacceptable(control);
                errorNum++;
            }else {
                valueAcceptable(control);
            }
        }
        return errorNum === 0;
    }

    function clearForm(controls){
        for(let control of controls){
            control.val("");
            control.removeClass("success-border");
        }
    }
    function sendGETRequest(
        url,
        callback
    ){
        $.ajax({
            url:  url,
            method: "GET",
            dataType: "json",
            statusCode: {
                201: function (result) {
                    if (callback != null) {
                        callback();
                    }
                },
                200: function (result) {
                    if (callback != null) {
                        callback(result);
                    }
                },
                422: function () {
                    console.error(422);
                },
                500: function () {
                    console.error(500);
                }
            }
        });
    }
    function sendPOSTRequest(
        url,
        data,
        callback
    ){
        $.ajax({
            url:  url,
            method: "POST",
            data: data,
            dataType: "json",
            statusCode: {
                201: function (result) {
                    if (callback != null) {
                        callback();
                    }
                },
                200: function (result) {
                    if (callback != null) {
                        callback(result);
                    }
                },
                422: function () {
                    console.error(422);
                },
                500: function () {
                    console.error(500);
                }
            }
        });
    }

    // regexes
    const firstLastNameRegex = /^[A-ZŽĐŠĆČ][a-zžđšćč]{2,14}(\s[A-ZŽĐŠĆČ][a-zžđšćč]{2,14}){0,1}$/;
    const emailRegEx = /^[a-z][a-z0-9]{2,14}([\._][a-z0-9]{1,14}){0,4}\@([a-z]{3,5}\.){1,2}[a-z]{2,3}$/;
    const passwordRegEx = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,16}$/;
    const messageRegEx = /^[A-ZŽĐŠĆČ@][A-zŽĐŠĆČžđšćč0-9\(\)\.,?!:\/\;\s\n\*-_@]{1,}$/;
    const dateRegEx = /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/;
    const subjectRegEx = /^[A-ZŽĐŠĆČ][a-zžđšćč]{2,19}(\s[A-ZŽĐŠĆČa-zžđšćč0-9\@]{1,19}){0,5}$/;
    const searchRegEx = /^[A-zŽĐŠĆČžđšćč\s\@\-\_]{0,50}$/;
    // const messageRegEx = /^[A-ZŽĐŠĆČ][a-zžđšćč\(\)\/\.\?\!\.\,]{2,19}(\s[A-ZŽĐŠĆČa-zžđšćč0-9\(\)\/\.\?\!\.\,]{1,20}){0,}$/;
    const categoryRegEx = /^[0-9]$/;
   if(document.getElementById("modal") != undefined) {
      $("#close-modal") .click(function(e){
          e.preventDefault();
          modal.hide();
      });
      $("#close-modal-btn").click(function(e){
          e.preventDefault();
          modal.hide();
      });
   }


    // bars-menu code
    if(document.getElementById("bars-menu") != undefined){
        $("#bars-menu__close").on("click", function(e){
           e.preventDefault();
            $("#bars-menu").css("width", "0px");
        });
    }
    if(document.getElementById("bars") != undefined){
        $("#bars").on("click", function(){
            $("#bars-menu").css("width", "100%");
        });
    }
    // home page
    if(document.getElementById("formLogin")){
        // add onblur event for each form control
        const loginControls = [
            {
                "element" : $("#emailLogin"),
                "regex" : emailRegEx,
                "messageSpan" : $("#email")
            },
            {
                "element" : $("#passwordLogin"),
                "regex" : passwordRegEx,
                "messageSpan" : $("#password")
            }
        ];
        addBlurEventToControls(loginControls);
        document.getElementById("formLogin").addEventListener("submit", function(e){
            e.preventDefault();
            // validation
            if(formValuesAcceptable(loginControls)){
                // ready to send request
                // complete this jquery code
                // I need correct set of properties for apropriate request sending
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                // setUpAjaxHeader();
                $.post("/auth/login",
                    {email:$("#emailLogin").val(), password:$("#passwordLogin").val(), submit: true},
                    function(data){
                    if(data.error){
                       let html = `<h3 class="roboto-slab">${data.error}</h3>`;
                       modal.set(html) ;
                       modal.show();
                    }
                    else if (data.success){
                        let html = `<h3 class="roboto-slab">Uspešno prijavljivanje</h3>`;
                        clearForm([
                            $("#emailLogin"),
                            $("#passwordLogin")
                        ]);
                        modal.set(html) ;
                        modal.show();
                        location.href = siteRoot + "user/";
                    }
                });
            }
        });
    }
    if(document.formRegistration != undefined){
        const registrationControls = [
            {
                "element" : $("#firstnameRegistration"),
                "regex" : firstLastNameRegex,
                "messageSpan" : $("#firstname")
            },
            {
                "element" : $("#lastnameRegistration"),
                "regex" : firstLastNameRegex,
                "messageSpan" : $("#lastname")
            },
            {
                "element" : $("#emailRegistration"),
                "regex" : emailRegEx,
                "messageSpan" : $("#email")
            },
            {
                "element" : $("#passwordRegistration"),
                "regex" : passwordRegEx,
                "messageSpan" : $("#password")
            },
            {
                "element" : $("#passwordAgainRegistration"),
                "regex" : passwordRegEx,
                "messageSpan" : $("#passwordAgain")
            },
            {
                "element" : $("#dateRegistration"),
                "regex" : dateRegEx,
                "messageSpan" : $("#date")
            }
        ];
        addBlurEventToControls(registrationControls);
        document.getElementById("formRegister").addEventListener("submit", function(e){
            e.preventDefault();
            if(formValuesAcceptable(registrationControls) && $("#passwordRegistration").val() === $("#passwordAgainRegistration").val()){
                // setUpAjaxHeader();
                $.post(
                    "/auth/create/",
                    {
                        "firstname" : $("#firstnameRegistration").val(),
                        "lastname" : $("#lastnameRegistration").val(),
                        "email" : $("#emailRegistration").val(),
                        "password" : $("#passwordRegistration").val(),
                        "passwordAgain" : $("#passwordAgainRegistration").val(),
                        "date" : $("#dateRegistration").val(),
                        "submit" : true
                    },
                    function(res){
                        let html = `<h3 class="roboto-slab">${res.message}</h3>`;
                        modal.set(html);
                        modal.show();
                        if(res.success){
                            clearForm([
                                $("#firstnameRegistration"),
                                $("#lastnameRegistration"),
                                $("#emailRegistration"),
                                $("#passwordRegistration"),
                                $("#passwordAgainRegistration"),
                                $("#dateRegistration")
                            ]);
                        }
                    }
                );
            }else {
                let html = "<h3>Unete vrednosti moraju biti u željenim formatima. Takođe lozinke se moraju poklapati.</h3>";
                modal.set(html);
                modal.show();
            }
        });
    }
    else if(document.getElementById("formContact") != undefined)
    {
        const contactControls = [
            {
                "element" : $("#emailContact"),
                "regex" : emailRegEx,
                "messageSpan": $("#email")
            },
            {
                "element" : $("#subjectContact"),
                "regex" : subjectRegEx,
                "messageSpan" : $("#subject")
            },
            {
                "element": $("#messageContact"),
                "regex" : messageRegEx,
                "messageSpan" : $("#message")
            }
        ];
        addBlurEventToControls(contactControls  );
        document.getElementById("formContact").addEventListener("submit", function(e){
            e.preventDefault();
            if(formValuesAcceptable(contactControls)){

                $.post("/contact/send",
                    {
                        "email" : $("#emailContact").val(),
                        "subject" : $("#subjectContact").val(),
                        "message" : $("#messageContact").val()
                    },
                    function(res){
                        let html;
                        if(res.success){
                            html = `<h3 class="roboto-slab-bold">Poruka je uspešno poslata.</h3>` ;
                            clearForm([
                                $("#emailContact"),
                                $("#subjectContact"),
                                $("#messageContact")
                            ]);
                        }else if(res.error){
                            html = "Došlo je do grekše na serveru.";
                        }
                        modal.set(html);
                        modal.show();
                    });
            }
        });
    }
    else if(document.getElementById("author-data") != undefined){
        // sendGETRequest(
        //     "author/get",
        //     function(res){
        //         let html  = "";
        //         let titles = [
        //             "Ime:",
        //             "Skola:",
        //             "Indeks:"
        //         ];
        //         let i = 0;
        //         for(let p in res){
        //             html += `
        //                 <tr>
        //                     <td>${titles[i++]} ${res[p]}</td>
        //                 </tr>
        //             `;
        //         }
        //         document.getElementById("author-data").innerHTML = html;
        //         alert("ok");
        //     }
        // );
        $.get("/author/get", function(res){
            let html  = "";
            let titles = [
                "Ime:",
                "Skola:",
                "Indeks:"
            ];
            let i = 0;
            for(let p in res){
                html += `
                        <tr>
                            <td>${titles[i++]} ${res[p]}</td>
                        </tr>
                    `;
            }
            document.getElementById("author-data").innerHTML = html;
        });
    } if(document.getElementById("users-firstlastname") != undefined){
        function setEventForUnfollowLink(){
            $("#unfollow-link").click(function(e){
                e.preventDefault();
                // send ajax request
                $.ajax({
                    "url" : "/user/unfollow",
                    "dataType" : "json",
                    "method" : "DELETE",
                    "data" : {
                        "id" : $(this).data('id')
                    },
                    "success" :function(res) {
                        if(res.success){
                            let html = `
                                <a href="#" data-id="${res.id}"id="follow-link" class="btn btn-primary">Zaprati</a>
                            `;
                            $("#followUnfollow-wrapper").html(html);
                            setEventForFollowLink();
                            // location.href = siteRoot + "user/show/" + res.id;
                        }else if(res.error){
                            let html = "<h3 class='roboto-slab-bold'>Došlo je do grepke na serveru.</h3>";
                            modal.set(html);
                            modal.show();
                        }
                    }
                });
            });
        }
        function setEventForFollowLink(){
            $("#follow-link").click(function(e){
                e.preventDefault();
                $.ajax({
                    "url"   : "/user/follow/",
                    "dataType" : "json",
                    "method" : "POST",
                    "data" : {"id": $(this).data("id")},
                    "success" : function(res){
                        if(res.success){
                            let html = `
                                <a href="#" data-id="${res.id}" id="unfollow-link"class="btn btn-danger ">Otprati</a>
                            `;
                            $("#followUnfollow-wrapper").html(html);
                            setEventForUnfollowLink();
                            // location.href= siteRoot + "user/show/" + res.id;
                        }else if(res.error){
                            let html = "<h3 class='roboto-slab-bold'>Došlo je do greške na serveru.</h3>"
                            modal.set(html);
                            modal.show();
                        }
                    }
                });
            });
        }
        setEventForLikeCommentLinks();
        setEventForDislikeCommentLinks();
        setEventForFollowLink();


        // DISCUSIONS

        // FOLLOWERS
        $(".users-profile-menu-link").click(function(e){
            e.preventDefault();
            // alert($(this).data("id"));
            let selectedLink = Array.from(document.getElementsByClassName("users-profile-menu-link")).filter(l => $(l).data("id") === $(this).data('id'));
            let ids = Array.from(document.getElementsByClassName("users-profile-menu-link")).map(l => $(l).data("id"));
            $(ids).each(function(){
                // console.log(this)  ;
                $("#"+ this).addClass("d-none");
            });
            $("#" + $(selectedLink).data("id")).removeClass("d-none");
            $(".users-profile-menu-link").removeClass("orange-forecolor");
            $(selectedLink).addClass("orange-forecolor");
        });

        // $("#follow-link").click(function(e){
        //   e.preventDefault();
        // });
        // UNFOLLOW LINKS
        setEventForUnfollowLink();
            $("#unfollow-link").click(function(e){
                e.preventDefault();
                // send ajax request
                $.ajax({
                    "url" : "/user/unfollow",
                    "dataType" : "json",
                    "method" : "DELETE",
                    "data" : {
                        "id" : $(this).data('id')
                    },
                    "success" :function(res) {
                        if(res.success){

                            location.href = siteRoot + "user/show/" + res.id;
                        }else if(res.error){
                            let html = "<h3 class='roboto-slab-bold'>Došlo je do grepke na serveru.</h3>";
                            modal.set(html);
                            modal.show();
                        }
                    }
                });
            });
            setEventForUnfollowLinks()
        const searchFollowerControls = [
            {
                "element" : $("#searchFollower"),
                "regex" : searchRegEx,
                "messageSpan" : $("#search")
            }
        ];
        function setBlurEventForSearchControl(){
            for(let control of searchFollowerControls){
                control.element.on("blur", function(){
                    if(control.element.val().match(control.regex)){
                        valueAcceptable(control);
                        if(control.element.val() == ""){
                            $.ajax({
                                url: "/user/followers"  ,
                                dataType: "json",
                                method: "GET",
                                data : {
                                    "search" : ""
                                },
                                success: function(followers){
                                    loadFollowers(followers, "Ne postoje pratioci koji zadovoljavaju kriterijum pretrage.");
                                }
                            });
                        }
                    }else {
                        valueUnacceptable(control);
                    }
                });
            }
        }
        setBlurEventForSearchControl();
        // addBlurEventToControls(searchFollowerControls);
        function setEventForUnfollowLinks(){
            $(".unfollow-link").each(function(){
               $(this).click(function(e){

                   e.preventDefault();
                   $.ajax({
                       "url" : "/user/unfollow",
                       "dataType" : "json",
                       "method" : "DELETE",
                       "data" : {
                           "id" : $(this).data('id'),
                           "returnFollowers" : true,
                           "search" : $("#searchFollower").val()
                       },
                       "success" :function(res) {
                           if(res.success){
                               loadFollowers(res.followers, "Trenuto ne pratite nikoga.");
                           }else if(res.error){
                               let html = "<h3 class='roboto-slab-bold'>Došlo je do grepke na serveru.</h3>";
                               modal.set(html);
                               modal.show();
                           }
                       }
                   });
               })
            });
        }
        function loadFollowers(followers, msg = null){
            let html = "";
            for(let follower of followers){
                html += `
<section class="col-12 col-md-4 p-3   ">
   <section class="follower-card ">
       <figure class="w-100 d-flex justify-content-center">
           <img src="/storage/images/${follower.src}" class="img-fluid rounded" alt="user image"/>
       </figure>
       <article class="px-2">
           <p class="roboto-slab-bold">${follower.firstname} ${follower.lastname}</p>
       </article>
       <article class="p-2">
           <a class="btn btn-primary go-to-profile-link"  href="${siteRoot + "user/show/" + follower.idUser}" >Profil</a>
                `;
            if($("#users-firstlastname").data("sess") != follower.idUser){
                html += `
           <a href="#" class="btn btn-danger unfollow-link" data-id="${follower.idUser}">Otprati</a>
                ` ;
            }
                html += `
       </article>
   </section>
</section>
                `;
            }
            if(html == ""){
                html += `
                <article class="col-12 ">
                <p class="roboto-slab-bold">${msg}</p>
</article>
                   `    ;

                $("#followers-parent").html(html);
            }else {
                $("#followers-parent").html(html);
                setEventForUnfollowLinks();
            }
        }
        document.getElementById("formSearchFollowers").addEventListener("submit", function(e){
            e.preventDefault();
            if(formValuesAcceptable(searchFollowerControls)){
                $.ajax({
                    url: "/user/followers"  ,
                    dataType: "json",
                    method: "GET",
                    data : {
                        "search" : $("#searchFollower").val()
                    },
                    success: function(followers){
                        loadFollowers(followers, "Ne postoje pratioci koji zadovoljavaju kriterijum pretrage.");
                    }
                });
            }
        });
    }
    function setEventForDislikeCommentLink(link){
        link.click(function(e){
            e.preventDefault();
            $.ajax({
                "method" : "POST",
                "url" : "/likes/delete",
                "data" : {
                    "id" : link.data("id")
                },
                "success" : function(res){
                    if(res.success){
                        // link.text(res.linkText);
                        //like-comment-link-wrapper
                        const parent = link.parent();
                        parent.html(`
        <span class="roboto-slab-bold">Sviđanja <span class="like-count">${res.numberOfLikes}</span></span>
        <a href="#" class="btn btn-link like-comment" data-id="${res.idComment}">Sviđa mi se</a>
                                `);
                        setEventForLikeCommentLink(parent.find(".like-comment").first());

                    }else if(res.error){
                        modal.set("Doslo je do greske na serveru.");
                        modal.show();
                    }
                }
            });
        });
    }
    function setEventForLikeCommentLink(link){
        link.click(function(e){
            e.preventDefault();
            $.ajax({
                "method" : "POST",
                "url" : "/likes/store",
                "data" : {
                    "id" : link.data('id')
                },
                "success" : function(res){
                    if(res.success){
                        const parent = link.parent();
                        parent.html(`
        <span class="roboto-slab-bold">Sviđanja <span class="like-count">${res.numberOfLikes}</span></span>
        <a href="#" class="btn btn-link dislike-comment" data-id="${res.idComment}">Ne sviđa mi se</a>
                            `);
                        setEventForDislikeCommentLink(parent.find(".dislike-comment").first());
                    }else {
                        modal.set("Doslo je do greske na serveru.");
                        modal.show();
                    }
                }
            });
        });
    }
    function setEventForLikeCommentLinks(){
        $(".like-comment").each(function(){
            $(this)  .click(function (e){
                e.preventDefault();
                setEventForLikeCommentLink($(this)) ;
            });
        });
    }
    function setEventForDislikeCommentLinks(){
        $(".dislike-comment").each(function(){
            $(this).click(function(e){
                e.preventDefault();
                setEventForDislikeCommentLink($(this));
            });
        });
    }
    function setDiscusionSectionsFunctionalities(){
        setClickEventForCommentSectionButtons();
        setClickEventForDeleteCommentButtons();
        setSubmitEventForAddCommentForm();
        setClickEventForDeleteDiscusionButtons();
        setEventForLikeCommentLinks();
    }
    function setSubmitEventForAddCommentForm(){
        let insertCommentControls = [];
        $(".comment-content").each(function(){
            insertCommentControls.push({
                "element" : $(this),
                "regex" : messageRegEx,
                "messageSpan": $(this).next()
            });
        });
        addBlurEventToControls(insertCommentControls);
        $(".form-insert-comment").each(function(){
            $(this).submit(function(e){
                e.preventDefault();
                commentContent = $(this).find(".comment-content");
                if(formValuesAcceptable([{
                    "element" : commentContent,
                    "regex" : messageRegEx,
                    "messageSpan": $(this).next()
                }])){
                    let data;
                    if(document.getElementById("users-discusions") != undefined){
                        data = {
                            "content"  : commentContent.val(),
                            "idDiscusion" : $(this).data('id'),
                            "idUser" : $("#users-firstlastname").data("id")
                        }
                    }else {
                        data = {
                            "content"  : commentContent.val(),
                            "idDiscusion" : $(this).data('id'),
                            "idUser" : $("#users-firstlastname").data("id"),
                            "idCategory" : $("#category-name") .data("id")
                        }
                    }
                    $.ajax({
                        "url" : "/comments/store",
                        "method" : "POST",
                        "dataType" : "json",
                        "data": data,
                        "success" : function(res){
                           showModalAndLoadDiscusions("Uspešno ste dodali komentar.", res) ;
                        }
                    });
                    // send the message to the controller

                }
            });
        });
    }
    function showModalAndLoadDiscusions(
        message,
        res
    ){
        let html ;
        if(res.success){
            html = "<h3 class='roboto-slab-bold'>" + message+ "</h3>"  ;
            if(res.discusions.length > 0){
                loadDiscusions(res);
            }else {
                html = "<h3 class='roboto-slab-bold'>Trenutno ne postoje objave</h3>"  ;
                $("#users-discusions").html(html);
            }
        }else if(res.error){
            html = "<h3 class='roboto-slab-bold'>Došlo je do greške na serveru.</h3>"
        }
        modal.set(html);
        modal.show();
    }
    function setClickEventForDeleteCommentButtons(){
        $(".delete-comment-form").each(function(){
            $(this).on("submit", function(e){
                e.preventDefault();
                // alert($(this).data('id'));
                let data;
                if(document.getElementById("users-discusions") != undefined){
                    data = {
                        "idComment" : $(this).data("id"),
                        "idUser" : $("#users-firstlastname").data("id")
                    }
                }else {
                    data = {
                        "idComment" : $(this).data("id"),
                        "idUser" : $("#users-firstlastname").data("id"),
                        "idCategory" : $("#category-name") .data("id")
                    }
                }
                $.ajax({
                    "url" : "/comments/delete",
                    "dataType" : "json",
                    "method" : "DELETE",
                    "data" : data,
                    "success" : function(res){
                        showModalAndLoadDiscusions("Uspešno ste obrisali komentar", res);
                    }
                })
            });
        })
    }
    function setClickEventForDeleteDiscusionButtons(){
        $(".delete-discusion-link").each(function(){
            $(this)  .on("click", function(e){
                e.preventDefault();
                // alert($(this).data("id"));
                let data;
                if(document.getElementById("users-discusions") != undefined){
                    data = {
                        "idDiscusion" : $(this).data('id'),
                        "idUser" : $("#users-firstlastname").data("id")
                    }
                }else {
                    data = {
                        "idDiscusion" : $(this).data('id'),
                        "idUser" : $("#users-firstlastname").data("id"),
                        "idCategory" : $("#category-name") .data("id")
                    }
                }
                $.ajax({
                    "url" : "/discusions/delete",
                    "method" : "DELETE",
                    "data" : data,
                    "success" : function(res){
                        showModalAndLoadDiscusions("Uspešno ste obrisali raspravu.", res);
                    }
                });
            });
        });
    }
    function setClickEventForCommentSectionButtons(){
        $(".comment-section").css("display", "none");
        $(".showhide-comment-section").each(function(){
            $(this).click(function(e) {
                e.preventDefault();
                let commentSection = $(this).parent().parent().find(".comment-section");
                let commentSectionDisplay = $(commentSection).css("display");
                let btn = $(this);
                $(commentSection).slideToggle("slow", function(){
                    // console.log($(commentSection).css("display"));
                    if(commentSectionDisplay == "block"){
                        btn .text("Prikaži");
                    }else {
                        btn .text("Sakrij");
                    }
                });

            });
        });
    }
    function loadDiscusions(res){
        let html = "";
        for(let d of res.discusions){
            html += `
<section class="w-100  mb-3 p-2 discusions">
    <section class="d-flex mb-3  mx-0 row">
        <section class="row col-12 col-md-6">
            <figure class="col-12 col-md-2 "><img src="/storage/images/${d.src}"  class="profile-pic-small img-fluid img-thumbnail" alt="profile picture"/></figure>
            <article class="col-12 col-md-10"><a href="${siteRoot + "user/show/" + d.idUser}" class="roboto-slab-bold ">${d.firstname} ${d.lastname}</a></article>\`;
        </section>`;

            if($("#users-firstlastname").data("id") == $("#users-firstlastname").data("sess")) {
                html += `
            <section class="row col-12 col-md-6 justify-content-end">
                <article class="col-12 col-md-2">
                    <a href="${siteRoot + "discusions/edit/" + d.idDiscusion}" class="btn btn-primary" >Izmeni</a>
                </article>
                <article class="col-12 col-md-2"><a href="#" class="btn btn-danger delete-discusion-link" data-id="${d.idDiscusion}">Obriši</a></article>
            </section>

           `;

            }

            html += ` </section>
    <section class="row justify-content-start">
        <article class="   mr-2">
            <p class="roboto-slab-bold mb-0">${d.title}</p>
        </article>
        <article class=" ">
            <p class="roboto-slab-bold mb-0">(${d.date})</p>
        </article>
        <article class="col-12 col-md-2 my-2 my-md-0">
            <span class="roboto-slab-bold category">${d.category}</span>
        </article>
    </section>
        <article class="my-3 ">
            <p class="roboto-slab text-justify">${d.content}</p>
        </article>
                `;
            if(d.comments){
                html += `
    <article>
        <p class="roboto-slab-bold title-1">Komentari (${d.comments.length})<a href="#" class="showhide-comment-section ml-3 btn btn-primary" >Prikaži</a></p>
        <section class="comment-section">
            <section >
                <form action="${siteRoot + "comments/store"}"data-id="${d.idDiscusion}" method="POST" name="formInsertComment" class="form-insert-comment">
                    <section class="row">
                        <article class="col-12 mb-3">
                            <textarea rows="3" cols="20" class="comment-content form-control" placeholder="Unesite komentar"></textarea>
<span class="form-element-message error-message" id="message">Poruka mora početi velikim slovom, najmanje 2 a najviše 255 znaka.</span>
                        </article>
                        <article class="col-12 mb-3">
                            <input type="submit" value="Potvrdi" class="btn btn-primary" />
                        </article>
                    </section>
                </form>
            </section>
                `;
                for(let c of d.comments){
                    // console.log(c);
                    html += getCommentHTML(c);
                }
                html += `

        </section>
    </article>
                `;
            }
            html += `

        </section>
            `;
        }
        if(document.getElementById("users-discusions") !=undefined){
            $("#users-discusions").html(html);
        }else {
           $("#all-discusions") .html(html);
        }
        // add submit event
        setDiscusionSectionsFunctionalities();
        // setClickEventForCommentSectionButtons();
        // setClickEventForDeleteCommentButtons();
        // setSubmitEventForAddCommentForm();
    }
    function getCommentHTML(comment){
        let html;
        html = `
<section class="comment mb-3">
    <section class="row ">
        <figure class="col-12 col-md-1"><img src="/storage/images/${comment.profilePic}"   class="profile-pic-small img-fluid img-thumbnail" alt="profile picture"/></figure>
        <article class="col-11">
            <p   class="roboto-slab-bold"><a href="${siteRoot + "user/show/"  + comment.idUser}">${comment.firstname} ${comment.lastname}</a> (${comment.date})</p>
        </article>
    </section>
    <article>
        <p class="roboto-slab">${comment.content}</p>
    </article>
    <article class="like-comment-link-wrapper">
        <span class="roboto-slab-bold">Sviđanja <span class="like-count">${comment.likes}</span></span>
        <a href="#" class="btn btn-link like-comment" data-id="${comment.idComment}">Sviđa mi se</a>
    </article>
           `;
        if($("#users-firstlastname").data("sess") == $("#users-firstlastname").data("id") || comment.idUser == $("#users-firstlastname").data("sess")){
            html += `

        <section class=" row my-3">
            <article class="col-12 col-md-2 mb-3">
                <form class="delete-comment-form" name="" action="#" data-id="${comment.idComment}" method="POST" >
                    <input type="submit" value="Obriši komentar" class="btn btn-danger" />
                </form>
            </article>
            <article class="col-12 col-md-2"><a href="${siteRoot + "comments/edit/" + comment.idComment}" class="btn btn-primary">Izmeni komentar</a></article>
        </section>

            `;
        }
        html += `
    </section>
           `;
        return  html;
    }
    if(document.getElementsByClassName("comment-section").length > 0){

        setDiscusionSectionsFunctionalities();
    }
    if(document.editProfileForm){
        const editProfileControls = [
            {
                "element" : $("#firstnameEditProfile"),
                "regex" : firstLastNameRegex,
                "messageSpan" : $("#firstname")
            },
            {
                "element" : $("#lastnameEditProfile"),
                "regex" : firstLastNameRegex,
                "messageSpan" : $("#lastname")
            },
            {
                "element" : $("#emailEditProfile"),
                "regex" : emailRegEx,
                "messageSpan" : $("#email")
            },
            {
                "element" : $("#dateEditProfile"),
                "regex" : dateRegEx,
                "messageSpan" : $("#date")
            },
            {
                "element" : $("#passwordEditProfile"),
                "regex" : passwordRegEx,
                "messageSpan" : $("#password")
            },
            {
                "element" : $("#passwordNewEditProfile"),
                "regex" : passwordRegEx,
                "messageSpan" : $("#passwordNew")
            }
        ];
        addBlurEventToControls(editProfileControls);
        document.editProfileForm.onsubmit = function(e){
            e.preventDefault();
            // setUpAjaxHeader();
            let data = {};
            if($("#firstnameEditProfile").val().match(firstLastNameRegex) && $("#firstnameEditProfile").val()){
                data.firstname = $("#firstnameEditProfile").val();
            }
            if($("#lastnameEditProfile").val().match(firstLastNameRegex) && $("#lastnameEditProfile").val()){
                data.lastname = $("#lastnameEditProfile").val();
            }
            if($("#emailEditProfile").val().match(emailRegEx) && $("#emailEditProfile").val()){
                data.email = $("#emailEditProfile").val();
            }
            if($("#passwordNewEditProfile").val().match(passwordRegEx) && $("#passwordEditProfile").val().match(passwordRegEx) && $("#passwordNewEditProfile").val() && $("#passwordEditProfile").val()){
                data.passwordOld = $("#passwordEditProfile").val();
                data.password = $("#passwordNewEditProfile").val();
            }
            if($("#dateEditProfile").val()){
                data.birthDate = $("#dateEditProfile").val();
            }
            $.ajax({
                "url" : "/user/updateprofile",
                "method" : "PATCH",
                "data" : data,
                "success" : function(res){
                    if(res.success){
                        let html = `<h3 class="roboto-slab-bold">Uspešno ste izmenili podatke.</h3>`;
                        modal.set(html);
                        modal.show();
                        // location.href= siteRoot + "user";
                    }else {
                        let html = `<h3 class="roboto-slab-bold">Niste izmenili podatke.</h3>`;
                        modal.set(html);
                        modal.show();
                    }
                }
            });
        };
    }
    if(document.formNewDescusion != undefined){
        const newDiscuionControls = [{
                "element"   : $("#subjectNewDiscusion"),
                "regex" : subjectRegEx,
                "messageSpan" : $("#subject")
            },
            {
                "element" : $("#messageNewDiscusion"),
                "regex" : messageRegEx,
                "messageSpan" : $("#message")
            },
            {
                "element" : $("#categoryNewDiscusion"),
                "regex" : categoryRegEx,
                "messageSpan" : $("#category")
            }
        ];
        addBlurEventToControls(newDiscuionControls);
        $("#formNewDiscusion").on("submit", function(e) {
            e.preventDefault();
            if (formValuesAcceptable(newDiscuionControls)) {
                $.post(
                    "/discusions/store",
                    {
                        "subject": $("#subjectNewDiscusion").val(),
                        "message": $("#messageNewDiscusion").val(),
                        "categoryId": $("#categoryNewDiscusion").val()
                    },
                    function (res) {
                        let html;
                        if(res.success){
                            html = `<h3 class="roboto-slab-bold">Uspešno ste dodali raspravu.</h3>` ;
                            clearForm([
                                $("#subjectNewDiscusion"),
                                $("#messageNewDiscusion"),
                                $("#categoryNewDiscusion")
                            ]);
                            $("#categoryNewDiscusion").val("-1");
                        }else if(res.error){
                            html = `<h3 class="roboto-slab-bold">Došlo je do greške prilikom obrade zahteva.</h3>` ;
                        }else if(res.errorSever){
                            html = `<h3 class="roboto-slab-bold">Došlo je do greške na serveru.</h3>` ;
                        }
                        modal.set(html);
                        modal.show();
                    });
            }
        });
    }
if(document.updateCommentForm != undefined){
    const updateCommentControls = [
        {
            "element" : $("#messageUpdateComment"),
            "regex" : messageRegEx,
            "messageSpan" : $("#message")
        }
    ];
    addBlurEventToControls(updateCommentControls);
    document.getElementById("updateCommentForm").addEventListener("submit", function(e){
        e.preventDefault();
        if(formValuesAcceptable(updateCommentControls)){
            $.ajax({
                "url" : "/comments/update",
                "dataType" : "application/json",
                "method" : "PUT",
                "data" : {
                    "content" : $("#messageUpdateComment").val(),
                    "id" : $("#messageUpdateComment").data("id")
                },
                "statusCode": {
                    200: function(res){
                        json = JSON.parse(res.responseText);
                        displayResponseMessage(json, "Uspešno ste izmenili komentar.");
                    }
                }
            });
        }
    });
}
function displayResponseMessage(res, message){
    let html = "";
    if(res.success) {
        html = "<h3 class='roboto-slab-bold'>" + message + "</h3>"
    }else if(res.nothingUpdated){
        html = "<h3 class='roboto-slab-bold'>Niste ništa izmenili.</h3>"
    }
    else if(res.error) {
        html = "<h3 class='roboto-slab-bold'>Došlo je do greške na serveru.</h3>"
    }
    modal.set(html);
    modal.show();
}
    if(document.updateDiscusionForm != undefined) {
        const updateDiscsusionControls = [
            {
                "element": $("#subjectUpdateDiscusion"),
                "regex": subjectRegEx,
                "messageSpan": $("#subject")
            },
            {
                "element": $("#messageUpdateDiscusion"),
                "regex": messageRegEx,
                "messageSpan": $("#message")
            },
            {
                "element": $("#categoryUpdateDiscusion"),
                "regex": categoryRegEx,
                "messageSpan": $("#category")
            },
        ];
        addBlurEventToControls(updateDiscsusionControls);
        document.updateDiscusionForm.onsubmit = function (e) {
            e.preventDefault();
            if (formValuesAcceptable(updateDiscsusionControls)) {
                $.ajax({
                    "url": "/discusions/update",
                    "dataType": "json",
                    "method": "PUT",
                    "data": {
                        "subject": $("#subjectUpdateDiscusion").val(),
                        "content": $("#messageUpdateDiscusion").val(),
                        "category": $("#categoryUpdateDiscusion").val(),
                        "id": $("#subjectUpdateDiscusion").data("id")
                    },
                    "success": function (res) {
                        displayResponseMessage(res, "Uspešno ste izmenili raspravu.");
                    }
                });
            }
        }
    }


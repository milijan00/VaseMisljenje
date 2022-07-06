<?php
    $explodedURL = explode("/",$_SERVER["PHP_SELF"]);
?>
<article id="bars-menu" class=" white-backcolor position-fixed">
    <article class="d-flex justify-content-end px-2">
        <a href="#" id="bars-menu__close" class="">&times;</a>
    </article>
    <article class="d-flex justify-content-center">
        <ul class=" text-center w-100">
            @foreach($menu as $link)
                @component("components.nav-link", ["explodedURL"=>$explodedURL, "link"=>$link])
                @endcomponent
            @endforeach
        </ul>
    </article>
</article>
<header class="container-fluid white-backcolor">
    <section class="container mx-auto py-2">
        <section class="row justify-content-between">
            <article class="col-2 col-md-1">
                @include("fixed.logo")
            </article>
            <article class="col-5 d-none d-md-flex align-items-center justify-content-center" id="nav_link">
                <ul class="d-flex justify-content-between  w-100">
                    @foreach($menu as $link)
                        @component("components.nav-link", ["explodedURL"=> $explodedURL, "link"=>$link])
                        @endcomponent
                        @endforeach
                </ul>
            </article>
            <article class="col-1 d-flex  d-md-none align-items-center">
                <span class=" fas fa-bars " id="bars"></span>
            </article>
        </section>
    </section>
</header>

@extends("layouts.no-nav-layout")
@section("title", "Početna")
@section("keywords", "mreža, prijava, razmišanje, kritičko, kritika, kritićko razmišljanje")
@section("description", "Društvena mreža  za ljubitelje kritičkog razmišljanja.")
@section("content")
    <section class="container-fluid wrapper py-3 vheight-100 d-flex align-items-center">
        <section class="container child p-3 mx-auto py-3 d-flex justify-content-center align-items-center height-700">
            <section class="row justify-content-center">
                <section class="col-12 col-md-6 p-2">
                    <figure class="col-6 d-flex ">
                        @include("fixed.logo")
                    </figure>
                    <article>
                        <p class="roboto-slab-bold">Vaše mišlenje, drušvena mreža za ljubitelje kritičkog razmišljanja. </p>
                    </article>
                </section>
                <article class="col-12 col-md-6 p-2">
                    <article>
                        <h1 class="hack title">Prijava</h1>
                    </article>
                    <form name="formLogin" id="formLogin" method="POST" action="{{route("login")}}">
                        @csrf
                        <article class="mb-3">
                            <input type="text"id="emailLogin"  class="form-control hack"placeholder="Email"/>
                            @include("fixed.errorMessages.email")
                        </article>
                        <article class="mb-3">
                            <input type="password"id="passwordLogin" class="form-control " placeholder="Lozinka"/>
                            @include("fixed.errorMessages.password", ["id"=> "password"])
                        </article>
                        <article class="mb-3">
                            <input type="submit" class="btn btn-primary " value="Potvdi"/>
                        </article>
                    </form>
                    <article>
                        <p class="roboto-slab-bold">Nemate nalog? Napravite jedan <a href="{{route("register")}}"class="orange-forecolor roboto-slab-bold" >ovde</a>.</p>
                    </article>
                </article>
            </section>
        </section>
    </section>
@endsection

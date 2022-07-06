@extends("layouts.no-nav-layout")
@section("title", "Registracija")
@section("keywords", "registracija, nalog, napravite nalog, vasemisljenje registracija")
@section("description", "Napravite nalog ovde, brzo i jednostavno")

@section("content")
    <section class="container-fluid d-flex align-items-center justify-content-center vheight-100 wrapper">
        <article class="container ">
            <section class="row flex-column child p-3">
                <article>
                    <h1 class="title">Registracija</h1>
                </article>
                <form name="formRegistration" id="formRegister" method="POST" action="{{route("createAccount")}}">
                    <label for="firstnameRegistration" class="roboto-slab">Ime i prezime</label>
                    <section class="d-flex flex-column flex-md-row mb-3">
                        <article class="input-group mr-md-1 mb-3 mb-md-0">
                            <input type="text"  placeholder="Ime" id="firstnameRegistration" class="form-control"/>
                            @include("fixed.errorMessages.firstlastName", ["id" => "firstname"])
                        </article>
                        <article class="input-group">
                            <input type="text"  placeholder="Prezime" id="lastnameRegistration" class="form-control"/>
                            @include("fixed.errorMessages.firstlastName", ["id"=> "lastname"])
                        </article>
                    </section>
                    <article class="mb-3">
                        <label for="emailRegistration"class="roboto-slab">Email</label>
                        <input type="email" placeholder="Email" class="form-control"  id="emailRegistration" />
                        @include("fixed.errorMessages.email")
                    </article>
                    <article class="mb-3">
                        <label for="passwordRegistration"class="roboto-slab">Lozinka</label>
                        <input type="password" placeholder="Lozinka" class="form-control"  id="passwordRegistration" />
                        @include("fixed.errorMessages.password", ["id"=>"password"])
                    </article>
                    <article class="mb-3">
                        <label for="passwordRegistration"class="roboto-slab">Lozinka ponovo</label>
                        <input type="password" placeholder="Lozinka ponovo" class="form-control"  id="passwordAgainRegistration" />
                        @include("fixed.errorMessages.password", ["id"=>"passwordAgain"])
                    </article>
                    <article class="mb-3">
                        <label for="dateRegistration"class="roboto-slab">Datum rođenja</label>
                        <input type="date"  class="form-control"  id="dateRegistration" />
                        @include("fixed.errorMessages.date")
                    </article>
                    <article>
                        <input type="submit" class="btn btn-primary" value="Napravi nalog" />
                    </article>
                </form>
                <article>
                    <p>
                    <p class="roboto-slab-bold">Imate nalog? Kliknite <a href="{{route("home")}}" >ovde</a>.</p>
                </article>
            </section>
        </section>
    </section>
    @endsection

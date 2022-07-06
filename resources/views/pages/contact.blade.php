@extends("layouts.master")
@section("title", "Kontakt")
@section("keywords", "kontakt, pomoć, pitanja")
@section("description", "Preko ove stranice možete doći u dodir, postaviti pitanja i zatražiti pomoć  od našeg Administratora.")
@section("content")
    <section class="container-fluid wrapper py-3">
        <section class="container child  p-3 d-flex flex-column justify-content-center mx-auto py-3 ">
            <article>
                <h1 class="title">Kontakt formular</h1>
            </article>
            <form name="formContact" id="formContact" method="POST" action="{{route("sendEmail")}}">
                <section class="row">
                    <article class="col-12 mb-3">
                        <input type="email" placeholder="Email" class="form-control" id="emailContact" />
                        @include("fixed.errorMessages.email")
                    </article>
                    <article class="col-12 mb-3">
                        <input type="text" placeholder="Naslov" class="form-control" id="subjectContact" />
                        @include("fixed.errorMessages.subject")
                    </article>
                    <article class="col-12 mb-3">
                        <textarea rows="10" cols="20" class="w-100 form-control" id="messageContact" placeholder="Sadržaj"></textarea>
                        @include("fixed.errorMessages.message")
                    </article>
                    <article class="col-12 mb-3">
                        <input type="submit" value="Pošaljite poruku" class="btn btn-primary" />
                    </article>
                </section>
            </form>
        </section>
    </section>
    @endsection

@extends("layouts.master")
@section("title", "Nova rasprava")
@section("keywords", "Nova rasprava, nova objava, nova, mišljenje")
@section("description", "Objavite novu raspravu, izmesite Vaše ideje i poglede po brojnim pitanjima.")
@section("content")
    <section class="container mx-auto">
        <section class="row">
            <section class="col-12">
                <article>
                    <h3 class="sub-title roboto-slab-bold">Nova rasprava</h3>
                </article>
                <section class="w-100">
                    <form name="formNewDescusion" id="formNewDiscusion" action="" method="POST">
                        <article>
                            <h3 class="sub-tittle roboto-slab">Naslov</h3>
                        </article>
                        <article class="mb-3">
                            <input type="text" placeholder="Naslov" id="subjectNewDiscusion" class="form-control" />
                            @include("fixed.errorMessages.subject")
                        </article>
                        <article>
                            <h3 class="sub-tittle roboto-slab">Sadržaj</h3>
                        </article>
                        <article class="mb-3">
                            <textarea rows="10" cols="20" class="form-control w-100" placeholder="Sadržaj" id="messageNewDiscusion"></textarea>
                            @include("fixed.errorMessages.message")
                        </article>
                        <article class="mb-3">
                            <h3 class="sub-title roboto-slab">Kategorija</h3>
                            <select id="categoryNewDiscusion" class="form-control">
                                <option value="-1">Izaberite</option>
                                @for($i = 0; $i < count($categories); $i++)
                                <option value="{{$categories[$i]->idCategory}}"> {{$categories[$i]->name}}</option>
                                    @endfor
                            </select>
                            @include("fixed.errorMessages.category")
                        </article>
                        <article class="mb-3">
                            <input type="submit" class="btn btn-primary" value="Objavi" />
                            <a href="{{route("profile")}}" class="btn btn-primary">Nazad na profil</a>
                        </article>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection

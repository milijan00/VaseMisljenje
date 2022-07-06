@extends("layouts.master")
@section("title", "Izmena rasprave")
@section("keywords", "izmena, izmena rasprave, izmena sadržaja")
@section("description", "Izmenite raspravu shodno Vašoj zamisli.")
@section("content")
    <section class="container-fluid wrapper py-3">
        <section class="container mx-auto child p-3">
            <article>
                <h3 class="roboto-slab-bold ">Izmena rasprave</h3>
            </article>
            <section>
                <form name="updateDiscusionForm" action="#" method="POST">
                    <section class="row">
                        <article class="col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Naslov" data-id="{{$data["dis"]->idDiscusion}}" id="subjectUpdateDiscusion" value="{{$data["dis"]->title}}" />
                            @include("fixed.errorMessages.subject")
                        </article>
                        <article class="col-12 mb-3">
                            <textarea rows="5" cols="20" class="form-control" placeholder="Sadržaj" id="messageUpdateDiscusion">{{$data["dis"]->content}}</textarea>
                            @include("fixed.errorMessages.message")
                        </article>
                        <article class="col-12 mb-3">
                            <select id="categoryUpdateDiscusion" class="form-control">
                            @foreach($data["categories"] as $c)
                                @if($c->idCategory == $data["dis"]->idCategory)
                                    <option value="{{$c->idCategory}}" selected>{{$c->name}}</option>
                                @else
                                    <option value="{{$c->idCategory}}">{{$c->name}}</option>
                                @endif
                            @endforeach
                            </select>
                            @include("fixed.errorMessages.category")
                        </article>
                        <article class="col-12 mb-3">
                            <input type="submit" class="btn btn-primary" value="Izmeni" />
                            @if(strpos(url()->previous(), "user"))
                                <a href="{{route("profile")}}" class="btn btn-primary">Nazad na profil</a>
                                @elseif(strpos(url()->previous(), "discusions"))
                                <a href="{{route("showFromCat", ["id"=>url()->previous()[strlen(url()->previous())-1]])}}" class="btn btn-primary">Nazad na raspravu</a>
                            @endif
                        </article>
                    </section>
                </form>
            </section>
        </section>
    </section>
    @endsection

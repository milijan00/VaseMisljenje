@extends("layouts.master")
@section("title", "Izmena komentara")
@section("keywords", "izmena komentara, komentar, promena sadržaja")
@section("description", "Uz pomoć ove stranice možete promeniti Vaš komentar.")
@section("content")
    <section class="container-fluid py-3 wrapper">
       <section class="container mx-auto child p-3">
           <article>
               <h3 class="roboto-slab-bold"> Izmena komentara</h3>
           </article>
            <section>
                <form method="POST" name="updateCommentForm" id="updateCommentForm" action="#">
                    <article class="mb-3">
                        <textarea rows="5" cols="20"id="messageUpdateComment" data-id="{{$comment->idComment}}" class="form-control">{{$comment->content}}</textarea>
                        @include("fixed.errorMessages.message")
                    </article>
                    <section class="row">
                        <article class="col-12 col-md-2 mb-3">
                            <input type="submit"  class="btn btn-primary"value="Potvrdi"/>
                        </article>
                        <article class="col-12 col-md-2 mb-3">
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

<section class="w-100  mb-3 p-2 discusions">
    <!-- prvo ide ime i datum u jednom redu-->
    <section class=" mb-3  mx-0 row justify-content-between">
        <section class="row col-12 col-md-6">
            <figure class="col-12 col-md-2 "><img src="{{asset("storage/images/" . $userImage)}}"  class="profile-pic-small img-fluid img-thumbnail" alt="profile picture"/></figure>
            <article class="col-12 col-md-10"><a href="{{route("showOtherProfiles", ["id"=>$dis->idUser])}}" class="roboto-slab-bold ">{{$dis->firstname}} {{$dis->lastname}}</a></article>
        </section>
        @if(\Request::is("user") || session()->get("user")->idUser == $dis->idUser)
            <section class="row col-12 col-md-6 justify-content-end">
                <article class="col-12 col-md-2">
                    <a href="{{route("editDiscusion", ["id"=>$dis->idDiscusion])}}" class="btn btn-primary" >Izmeni</a>
                </article>
                <article class="col-12 col-md-2"><a href="#" class="btn btn-danger delete-discusion-link" data-id="{{$dis->idDiscusion}}">Obriši</a></article>
            </section>
            @endif
    </section>
    <section class="row justify-content-start">
        <article class="   mr-2">
            <p class="roboto-slab-bold mb-0">{{$dis->title}}</p>
        </article>
        <article class=" ">
            <p class="roboto-slab-bold mb-0">({{$dis->date}})</p>
        </article>
        <article class="col-12 col-md-2 my-2 my-md-0">
            <span class="roboto-slab-bold category">{{$dis->category}}</span>
        </article>
    </section>
        <article class="my-3 ">
            <p class="roboto-slab text-justify">{{$dis->content}}</p>
        </article>
   @if($dis->comments )
    <article>
        <p class="roboto-slab-bold title-1">Komentari ({{count($dis->comments)}})<a href="#" class="showhide-comment-section ml-3 btn btn-primary" >Prikaži</a></p>
        <section class="comment-section">
            <section >
                <form action="{{route("insertComment")}}"data-id="{{$dis->idDiscusion}}" method="POST" name="formInsertComment" class="form-insert-comment">
                    <section class="row">
                        <article class="col-12 mb-3">
                            <textarea rows="3" cols="20" class="comment-content form-control" placeholder="Unesite komentar"></textarea>
                            @include("fixed.errorMessages.message")
                        </article>
                        <article class="col-12 mb-3">
                            <input type="submit" value="Potvrdi" class="btn btn-primary" />
                        </article>
                    </section>
                </form>
            </section>
            @foreach($dis->comments as $comment)
                @component("components.comment", ["comment"=>$comment, "discusionIdUser"=>$dis->idUser])
                @endcomponent
            @endforeach
        </section>
    </article>
    @endif
</section>

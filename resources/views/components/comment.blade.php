<section class="comment mb-3">
    <section class="row ">
        <figure class="col-12 col-md-1"><img src="{{asset("storage/images/" . $comment->profilePic)}}"  class="profile-pic-small img-fluid img-thumbnail" alt="profile picture"/></figure>
        <article class="col-11">
            <p   class="roboto-slab-bold"><a href="{{route("showOtherProfiles", ["id"=>$comment->idUser])}}">{{$comment->firstname}} {{$comment->lastname}}</a> ({{$comment->date}})</p>
        </article>
    </section>
    <article>
        <p class="roboto-slab">{{$comment->content}}</p>
    </article>
    <article class="like-comment-link-wrapper">
        <span class="roboto-slab-bold">Sviđanja <span class="like-count">{{$comment->likes}}</span></span>
        @if($comment->AuthUserLiked)
            <a href="#" class="btn btn-link dislike-comment" data-id="{{$comment->idComment}}">Ne sviđa mi se</a>
            @else
        <a href="#" class="btn btn-link like-comment" data-id="{{$comment->idComment}}">Sviđa mi se</a>
            @endif
    </article>
    @if(\Request::is("user") || session()->get("user")->idUser == $comment->idUser || $discusionIdUser == session()->get("user")->idUser)
        <section class=" row my-3">
            <article class="col-12 col-md-2 mb-3">
                <form class="delete-comment-form" name="" action="#" data-id="{{$comment->idComment}}" method="POST" >
                    <input type="submit" value="Obriši komentar" class="btn btn-danger" />
                </form>
            </article>
            <article class="col-12 col-md-3"><a href="{{route("editComment", ["id"=>$comment->idComment])}}" class="btn btn-primary">Izmeni komentar</a></article>
        </section>

        @endif
</section>

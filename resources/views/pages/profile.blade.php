@extends("layouts.master")
@section("title", "Moj nalog")
@section("keyword", "nalog, pratioci, objava, izmeni podatke")
@section("description", "Preko ove stranice imate potpun pregled u Vaše aktivnosti, Vaše objave, komentare i pratioce.")
@section("content")
    <section class="container-fluid  py-3 wrapper">
        <section class="container mx-auto">
            <section class="row child row-column">
                <section class="col-12 p-2 d-flex justify-content-center align-items-center  flex-column ">
                    <figure class="d-flex  align-items-end justify-content-center w-50  " id="user-profile-pic">
{{--                        <img src="{{asset("assets/img/" . $data["userData"]->src)}}" class="img-fluid profile-pic" alt="profile picture"/>--}}
                        <img src="{{asset("/storage/images/" . $data["userImage"])}}" class="img-fluid profile-pic" alt="profile picture"/>
                    </figure>
                    <section  class="w-100">
                        <p id="users-firstlastname" class="text-center roboto-slab-bold"data-sess="{{session()->get("user")->idUser}}" data-id="{{$data["userData"]->idUser}}">{{$data["userData"]->firstname}} {{$data["userData"]->lastname}}</p>
                    </section>
                    <section class="w-100 text-center" id="followUnfollow-wrapper">
                        @if(session()->get("user")->idUser == $data["userData"]->idUser)
                        <a href="{{route("editprofile")}}" class="btn btn-primary">Izmeni podatke</a>
                            @elseif($isAFollower  && $isAFollower == true)
                                <a href="{{route("unfollow", ["id"=>$data["userData"]->idUser])}}" data-id="{{$data["userData"]->idUser}}" id="unfollow-link"class="btn btn-danger ">Otprati</a>
                            @else
{{--                            later add logic for separating followed from unfollowed user--}}
                                <a href="#" data-id="{{$data["userData"]->idUser}}"id="follow-link" class="btn btn-primary">Zaprati</a>
                        @endif
                    </section>
                </section>
                <!-- NA OVOM MESTU SE NALAZI NAVIGACIJA SA LINKOVIMA KA ZIDU I PRIJATELJJIMA-->
                <article class="p-2 w-100" id="users-profile-menu">
                    <ul class="d-flex mb-0">
                    @foreach($data["menu"] as $link)
                        @if($link->name == "Zid")
                            <li class="mx-1">
                                <a href="#" data-id="{{$link->idAttr}}"class="roboto-slab-bold sub-title orange-forecolor users-profile-menu-link mx-1">{{$link->name}}</a>
                            </li>
                        @else
                            <li class="mx-1">
                                <a href="#" data-id="{{$link->idAttr}}"class="roboto-slab-bold sub-title users-profile-menu-link mx-1">{{$link->name}}</a>
                            </li>
                        @endif
                    @endforeach
                    </ul>
                </article>
{{--                Wall--}}
                <section class="col-12 p-2 " id="wall">
                    <article class="d-flex my-3">
                        <h3 class="sub-title roboto-slab-bold">Rasprave</h3>
                        @if(session()->get("user")->idUser == $data["userData"]->idUser)
                        <article class="mx-2">
                            <a href="{{route("newDiscusion")}}" class="btn btn-primary">Nova rasprava</a>
                        </article>
                            @endif
                    </article>
                    <section id="users-discusions" class="col-12 py-2 ">
                        @if(count($data["discusions"]) > 0)
                        @foreach($data["discusions"] as $dis)
                            @component("components.discusion", ["dis"=>$dis, "userImage"=>$data["userImage"]])
                            @endcomponent
                        @endforeach
                        @else
                            <h3 class="roboto-slab-bold">Trenutno ne postoje rasprave.</h3>
                        @endif
                    </section>
                </section>
            {{-- Followers--}}
                <section class="col-12 p-2 d-none  py-3" id="followers">
                    <article>
                        <form name="formSearchFollowers" id="formSearchFollowers" action="{{route("followers")}}" method="POST" >
                            <section class="row py-2 white-backcolor">
                                <article class="col-12 col-md-10 mb-3">
                                    <input type="text" class="form-control" placeholder="Unesite ime i prezime" id="searchFollower" />
                                    @include("fixed.errorMessages.search")
                                </article>
                                <article class="col-12 col-md-2">
                                    <input type="submit" class="btn btn-primary" value="Pretraži"/>
                                </article>
                            </section>
                        </form>
                    </article>
                    @if(count($data["followers"]) > 0)
                    <section class="row  justify-content-between" id="followers-parent">
                        @foreach($data["followers"] as $follower)
                            @component("components.follower-card", ["follower"=>$follower])
                            @endcomponent
                        @endforeach
                    </section>
                   @else
                       <h3 class="roboto-slab-bold">Trenutno ne pratite nikoga.</h3>
                    @endif
                </section>
            </section>
        </section>
    </section>
    @endsection

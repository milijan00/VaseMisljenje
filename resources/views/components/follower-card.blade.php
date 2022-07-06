<section class="col-12 col-md-4 p-3   ">
   <section class="follower-card ">
       <figure class="w-100 d-flex justify-content-center">
           <img src="{{asset("storage/images/". $follower->src) }}" class="img-fluid rounded" alt="user image"/>
       </figure>
       <article class="px-2">
           <p class="roboto-slab-bold">{{$follower->firstname}} {{$follower->lastname}}</p>
       </article>
       <article class="p-2">
           <a class="btn btn-primary go-to-profile-link"  href="{{route("showOtherProfiles", ["id"=>$follower->idUser])}}" >Profil</a>
            @if (session()->get("user")->idUser != $follower->idUser)
           <a href="#" class="btn btn-danger unfollow-link" data-id="{{$follower->idUser}}">Otprati</a>
                @endif
       </article>
   </section>
</section>

@extends("layouts.master")
@section("title", "Prikaz rasprava")
@section("keywords", "kategorija, rasprava, oblast")
@section("description", "Preko ove stranice pristupate samo onim raspravama koje pripadaju odabranoj kategoriji, odnosno oblasti.")
@section("content")
    <section class="container-fluid wrapper py-3">
        <section class="container mx-auto p-3 child">
            <article class="mb-3">
                @if(isset($data["discusions"][0]))
                <h3 class="roboto-slab-bold" data-id="{{$data["discusions"][0]->idCategory}}" id="category-name">{{$data["discusions"][0]->category}}</h3>
                    @endif
            </article>
            <section class="row" id="all-discusions">
                @if(count($data["discusions"]) > 0)
                @foreach($data["discusions"] as $discusion)
                    @component("components.discusion", ["dis" => $discusion, "userImage"=>$discusion->src])
                        @endcomponent
                    @endforeach
                @else
                    <article class="col-12">
                        <p class="roboto-slab-bold">Trenutno ne postoje rasprave u ovoj kategoriji.</p>
                    </article>
                    <article class="col-12">
                        <p class="roboto-slab-bold">Možete pregledati dostupne rasprave <a class="" href="{{route("discusions")}}">ovde</a>, ili objaviti svoju iz odabrane kategorije.</p>
                    </article>
                @endif
            </section>
        </section>
    </section>
    @endsection

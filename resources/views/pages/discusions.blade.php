@extends("layouts.master")
@section("title", "Rasprave")
@section("keywords", "Rasprave, stav, teme")
@section("description", "Uzmite učešća u brojnim raspravama, izaberite teme i jasno pokažite svoj stav.")
@section("content")
    <section class="container-fluid wrapper py-3">
        <section class="container mx-auto child p-3">
            <article>
                <h3 class="roboto-slab-bold px-3">Dostupne kategorije</h3>
            </article>
            <section class="row justify-content-between">
                @foreach($data["categories"] as $category)
                    @component("components.category", ["category"=> $category])
                    @endcomponent
                @endforeach
            </section>
        </section>
    </section>
@endsection

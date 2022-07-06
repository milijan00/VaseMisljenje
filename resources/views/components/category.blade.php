<section class="col-12 col-md-4   p-3" >
    <section style="background: url('{{asset("assets/img/". $category->image)}}') rgba(90, 90, 90, .6); background-size: cover; background-blend-mode: multiply; background-position: center;" class="d-flex justify-content-center  flex-column white-forecolor height-400 border rounded ">
        <article class="">
            <h3 class="roboto-slab-bold text-center category-name">{{$category->name}}</h3>
        </article>
        <article>
            <p class="roboto-slab-bold text-center">Broj rasprava: {{$category->discusionsNum}}</p>
        </article>
        <article class="text-center">
            <a href="{{route("showFromCat", ["id"=>$category->idCategory])}}" class="btn btn-primary">Pogledajte</a>
        </article>
    </section>
</section>

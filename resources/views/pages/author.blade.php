@extends("layouts.master")
@section("title", "Autor sajta")
@section("keywords", "autor, podaci, dokumentacija")
@section("description", "Preko ove stranice se upoznajete sa autorom sajta, imate uvid u njegove osnovne podatke i dokumentaciju.")
@section("content")
    <section class="container-fluid wrapper py-3">
        <section class="container mx-auto p-4 height-500 d-flex justify-content-center flex-column  child">
            <section class="row  p-3">
                <article class="col-12 col-md-6">
                    <article>
                        <table class="table table-striped text-center w-100" id="authorInfoTable">
                            <thead>
                            <tr>
                                <th >Information</th>
                            </tr>
                            </thead>
                            <tbody id="author-data">

                            </tbody>
                        </table>
                    </article>
                </article>
                <article class="col-12 col-md-6">
                    <img src="{{asset("storage/images/autor.jpg")}}" alt="autor" class="img-fluid"/>
                </article>
            </section>
            <article>
                <p class="roboto-slab">Preuzmite dokumentaciju <a href="{{asset("documentation.pdf")}}" target="_blank">ovde</a>.</p>
            </article>
        </section>
    </section>
    @endsection

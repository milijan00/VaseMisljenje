@extends("layouts.master")
@section("title", "Izmeni podatke")
@section("keywords", "izmena podataka, izmena, podataka, izmena lozinke")
@section("description", "Izmenite podatke po potrebi.")
@section("content")
    <section class="container-fluid wrapper py-3">
        <section class="container mx-auto child p-3">
{{--            Edit firstname, lastname, email, password, date of birth and the profile picture --}}
            <article class="mb-3">
                <h3 class="roboto-slab-bold">Izmena podataka</h3>
            </article>
            <form name="editProfileForm" id="editProfileForm" method="POST" action="#">
                <section class="row">
                    <article class="col-12 mb-3">
                        <label for="firstnameEditProfile" class="roboto-slab-bold">Ime</label>
                        <input type="text" placeholder="Ime" id="firstnameEditProfile" value="{{session()->get('user')->firstname}}" class="form-control" />
                        @include("fixed.errorMessages.firstlastName", ["id"=>"firstname"])
                    </article>
                    <article class="col-12 mb-3">
                        <label for="lastnameEditProfile"class="roboto-slab-bold">Prezime</label>
                        <input type="text" placeholder="Prezime" id="lastnameEditProfile" value="{{session()->get("user")->lastname}}"class="form-control"/>
                        @include("fixed.errorMessages.firstlastName", ["id"=>"lastname"])
                    </article>
                    <article class="col-12 mb-3">
                        <label for="emailEditProfile"class="roboto-slab-bold">Email</label>
                        <input type="email" placeholder="email" id="emailEditProfile" value="{{session()->get("user")->email}}"class="form-control"/>
                        @include("fixed.errorMessages.email")
                    </article>
                    <article class="col-12 mb-3">
                        <label for="passwordEditProfile"class="roboto-slab-bold">Stara lozinka</label>
                        <input type="password" placeholder="Lozinka" id="passwordEditProfile" class="form-control"/>
                        @include("fixed.errorMessages.password", ["id"=>"password"])
                    </article>
                    <article class="col-12 mb-3">
                        <label for="passwordAgainEditProfile"class="roboto-slab-bold">Nova lozinka</label>
                        <input type="password" placeholder="Lozinka ponovo" id="passwordNewEditProfile" class="form-control"/>
                        @include("fixed.errorMessages.password", ["id"=>"passwordNew"])
                    </article>
                    <article class="col-12 mb-3">
                        <label for="dateEditProfile"class="roboto-slab-bold">Datum rođenja</label>
                        <input type="date" placeholder="Datum rođenja" value="{{session()->get("user")->birthDate}}"id="dateEditProfile" class="form-control"/>
                        @include("fixed.errorMessages.date")
                    </article>
                    <article class="col-12 mb-3">
                        <input type="submit" class="btn btn-primary" name="submitUserData" value="Izmeni"  />
                    </article>
                </section>
            </form>
            <section>
                <form name="formChangeProfilePicture" action="{{route("updateProfilePicture")}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    @method("PUT")
                    <article class="col-12 mb-3">
                        <label for="pictureEditProfile" class="roboto-slab-bold">Profilna fotografija:</label>
                        <input type="file" name="pictureEditProfile" id="pictureEditProfile" />
                        @if(session()->get("message"))
                            <span class="error-message ">{{session()->get("message")}}</span>
                        @endif
                    </article>
                    <article>
                        <input type="submit"class="btn btn-primary" name="submitProfilePicture" value="Izmeni" />
                        <a href="{{route("profile")}}" class="btn btn-primary">Nazad na profil</a>
                    </article>
                </form>
            </section>
            @if(session()->has("success"))
            <section>
                <p class="roboto-slab-bold">{{session()->get("success")}}</p>
            </section>
            @elseif(session()->has('error'))
                <section>
                    <p class="roboto-slab-bold">{{session()->get("error")}}</p>
                </section>
            @endif
        </section>
    </section>
    @endsection

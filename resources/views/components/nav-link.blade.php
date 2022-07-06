{{--@if(!empty($explodedURL[2]) && $explodedURL[2] == $link->name || $explodedURL[2] == "user" && $link->name == "profil")--}}
    @if(!empty($explodedURL[2]) && $explodedURL[2] == $link->explodedURLName)
    <li>
        <a href="{{$link->route}}" class="orange-forecolor roboto-slab-bold">{{$link->name}}</a>
    </li>
@else
    <li>
        <a href="{{$link->route}}" class="roboto-slab-bold">{{$link->name}}</a>
    </li>
@endif

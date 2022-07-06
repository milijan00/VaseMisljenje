
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Vaše mišljenje - @yield("title")</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta  name="keywords"  content="@yield("keywords")"/>
    <meta name="description" content="@yield("description")"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css"/>
    <link rel="stylesheet" href="{{asset("assets/vendor/bootstrap/css/bootstrap.css")}}"/>
    <link  rel="stylesheet" href="{{asset("assets/css/style.css")}}"/>
    <link rel="shortcut icon" href="{{asset("assets/img/favicon.ico")}}" type="image/x-icon"/>

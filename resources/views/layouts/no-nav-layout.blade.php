<?php session_start();?>
    <!DOCTYPE html>
<html lang="en">
<head>
    @include("fixed.head")
</head>
<body >
@include("fixed.modal")
    @yield("content")
@include("fixed.scripts")
</body>
</html>

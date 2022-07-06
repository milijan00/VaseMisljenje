<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
@include("fixed.head")
</head>
<body >
@include("fixed.modal")
@include("fixed.navigation")
@yield("content")
@include("fixed.footer")
@include("fixed.scripts")
</body>
</html>

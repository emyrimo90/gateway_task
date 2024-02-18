<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{env('APP_NAME')}}</title>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,  user-scalable=0" name="viewport" />
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <link rel="shortcut icon"  href="{{asset('/assets/images/logo.svg')}}" type="image/x-icon" sizes="32*32"/>
    <!-- bootstrap 5 id english -->

    @if(app()->getLocale() == 'en')
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
              integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
    @else
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.rtl.min.css"
              integrity="sha512-ltIFivbYEeV9dNzcYLxBKC2hPQ0l9K2/Ws8R5GsMkxANKtMigmsjzTUUej7iH5NwGNnD070lrycDq5OJlDyb1A=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
   @endif
    <!-- bootstrap 5 if arabic -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"
          integrity="sha512-vebUliqxrVkBy3gucMhClmyQP9On/HAWQdKDXRaAlb/FKuTbxkjPKUyqVOxAcGwFDka79eTF+YXwfke1h3/wfg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" async />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet"
          async>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet" async>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('/assets/css/style.css')}}" async />
    @vite(['resources/app/app.js','resources/sass/app.scss'])
</head>


<!-- If Arabic -->
<!-- Add dir="rtl" class="rtl"-->
 <!-- class="color-horizontal" if menu colored || class="color-header" if header colored-->
<body {{app()->getLocale()}} class='main-body color-horizontal {{app()->getLocale() == 'ar' ? 'rtl':''}}' dir="{{app()->getLocale() == 'ar' ? 'rtl':'ltr'}}">
<div id="app"></div>
</body>

</html>

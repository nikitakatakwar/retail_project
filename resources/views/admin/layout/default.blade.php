<!doctype html>
<html>
<head>
   @include('admin.includes.head')
</head>
<body>
<div class="container">
   <header class="row">
       @include('admin.includes.header')

   </header>

   <div id="main" class="offset-md-1 center" style="margin-top:-70px">
       <div>
                   @if(count($errors)>0)
                    @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{$error}}</p>
                    @endforeach
                    @endif

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
       </div>

           @yield('content')
   </div>
   <footer class="row">
       @include('admin.includes.footer')
   </footer>
</div>
</body>
@yield('scripts')
</html>

@extends('admin.layout.default')

@section('title')
Dashboard
@endsection



@section('content')

       <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="float-right">
        Logout
        </a>
        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
        </form>
        <div id="content" class="main-content">
            
@endsection

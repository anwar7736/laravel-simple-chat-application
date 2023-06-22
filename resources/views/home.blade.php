@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 bg-dark text-white">
                <div class="user-wrapper">
                    <input type="text" placeholder="Search friend...." class="search-user">
                    <div class="user-list">

                    </div>
                </div>
            </div>

            <div class="col-md-7 bg-dark text-white" id="messages">

            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
@endsection
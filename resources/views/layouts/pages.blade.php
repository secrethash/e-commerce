@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <div>
        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-content">
                            <ul class="nav">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>{{ $page->title }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="privacy_policy_main_area mb-60px">
            <div class="container">
                <div class="container-inner">
                    <div class="row">
                        <div class="col-12">
                            {!! $data['content'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

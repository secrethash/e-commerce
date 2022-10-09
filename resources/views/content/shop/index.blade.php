@extends('layouts.app')

@section('content')
    @livewire('shop.listing', compact('category'))
@endsection

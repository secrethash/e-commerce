@extends('layouts.app')

@section('content')
    @livewire('shop.checkout', compact('cart'))
@endsection

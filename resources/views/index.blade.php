@extends('layout.master')
@section('title','Home')
@section('content')

@if (Auth::guard('point')->check())
    @include('layout.indexes.paypoint')
@elseif (Auth::guard('employee')->check())
    @include('layout.indexes.employee')
@elseif (Auth::guard('compony')->check())
    @include('layout.indexes.compony')
@endif

@endsection
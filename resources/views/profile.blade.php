@extends('components.layouts.base')
@section('title')
    {{ $profile->name }} - Profile - Telemedicine
@endsection

@section('content')
    @include('components.profile')
@endsection

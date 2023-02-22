@extends('template.app')
@section('content')
<articles-component :percent="'{{ $percent }}'"></articles-component>
@endsection
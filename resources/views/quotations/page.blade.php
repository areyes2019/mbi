@extends('template.app')
@section('content')
<div id="app">
	<quotation-component :customer="'{{ $customer }}'" :id="'{{ $id }}'" :slug="'{{ $slug }}'"></quotation-component>
</div>
@endsection
@extends('template.app')
@section('content')
<div id="app">
	<order-component :supplier="'{{ $supplier_id }}'" :name="'{{ $supplier_name }}'" :order="'{{ $idOrder }}'" :slug="'{{ $slug }}'"></order-component>
</div>
@endsection
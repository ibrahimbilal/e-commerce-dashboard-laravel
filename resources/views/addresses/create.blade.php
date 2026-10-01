@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header"><h1 class="page-title text-capitalize">add address</h1></div>
<form action="{{ route('addresses.store') }}" method="POST" class="row">
@csrf
<div class="col-12 col-lg-8">
<div class="main-box box-spaces">
@include('components.address-form-fields')
<div class="mt-4"><button type="submit" class="btn solid-btn">save</button></div>
</div>
</div>
</form>
@endsection

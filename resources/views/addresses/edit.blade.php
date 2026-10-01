@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header"><h1 class="page-title text-capitalize">edit address</h1></div>
<form action="{{ route('addresses.update', $address) }}" method="POST" class="row">
@csrf
@method('PUT')
<div class="col-12 col-lg-8">
<div class="main-box box-spaces">
@include('components.address-form-fields', ['address' => $address])
<div class="mt-4"><button type="submit" class="btn solid-btn">update</button></div>
</div>
</div>
</form>
@endsection

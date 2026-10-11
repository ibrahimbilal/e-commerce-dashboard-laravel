@extends('admin.layout')

@section('title', 'E-Commerce Project')

@push('stylesheet')
    <link href="{{ asset('css/pickadate.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <x-flash-messages />
    <div class="page-header">
        <div class="row">
            <div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
                <div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
                    <h1 class="page-title">add customer</h1>
                </div>
                <div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
                    <div class="breadcrumbs d-flex justify-content-between align-items-center"><a
                            class="item text-capitalize d-flex justify-content-between align-items-center"
                            href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps">
                                </i></span>dashboard</a><span class="angle"><span class="icon"><i
                                    class="fi-rr-angle-double-right"> </i></span></span><a
                            class="item text-capitalize d-flex justify-content-between align-items-center"
                            href="{{ route('admin.customers.index') }}">customers</a><span class="angle"><span
                                class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span
                            class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.customers.store') }}" class="row clearfix" data-post-type="customer" id="add-newitem-form"
        method="POST" data-ajax-form novalidate>
        @csrf
        <div class="col-sm-12 post-box order-sm-1">
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">Required Informations</h2>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="first-name">first name:</label>
                    <input class="form-control" id="first-name" name="first_name" type="text"
                        value="{{ old('first_name') }}" />
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="last-name">last name:</label>
                    <input class="form-control" id="last-name" name="last_name" type="text"
                        value="{{ old('last_name') }}" />
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="email">email address:</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" />
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="password">password:</label>
                    <div class="with-icon">
                        <input class="form-control" id="password" name="password" type="password" /><span
                            class="show-pass"><i class="fi-rr-eye"> </i></span>
                    </div>
                    <button class="btn regular-btn ms-sm-3 mt-2 mt-sm-0 text-nowrap generate-password" type="button">Suggest
                        Password</button>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="mobile">mobile:</label>
                    <input class="form-control" id="mobile" name="mobile" type="tel" value="{{ old('mobile') }}" />
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="birth-date">Birth Of Date:</label>
                    <div class="position-relative w-100">
                        <input class="form-control" data-toggle="datepicker" id="birth-date" name="birth_date" type="text"
                            value="{{ old('birth_date') }}" />
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title">gender:</label>
                    <label class="radio-label" for="male">
                        <input class="input-radio" id="male" name="gender" type="radio" value="Male" @checked(old('gender', 'Male') === 'Male') />Male
                    </label>
                    <label class="radio-label" for="female">
                        <input class="input-radio" id="female" name="gender" type="radio" value="Female" />Female
                    </label>
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                    <div class="item-title d-block mb-2">
                        <label class="item-title mb-2" for="profile-picture">{{ __('forms.profile_picture.title') }}</label>
                        <small>{{ __("forms.profile_picture.sub") }}</small>
                    </div>
                    <div class="item-content">
                        <label for="pp" class="btn regular-btn" style="width: 150px">
                            {{ __('buttons.upload_image') }}
                            <input type="file" name="profile_picture" id="pp" accept=".jpg, .jpeg, .png" data-pp-cropper style="display: none">
                        </label>
                        <div class="selected-img" style="display: none">
                            <div class="img-holder mt-3">
                                <img class="preview" src="{{ asset('assets/images/avatar-placeholder.svg') }}" width="70" />
                                <span class="overlay"><i class="fi-rr-trash"> </i><span>{{ __('buttons.remove') }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="ip_address" value="{{ old('ip_address') }}" />
        </div>
        <div class="col-sm-12 post-box order-sm-3">
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">Addresses</h2>
                </div>
                @include('components.admin.customer-addresses-repeater', ['customer' => $customer ?? null])
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 meta-box order-2">
            <div class="main-box box-spaces mb-0">
                <x-account-activity-meta />
                <div class="btns-holder d-flex justify-content-between mt-4">
                    <button class="btn trans-btn w-100 text-start delete" data-post-type="customer"><span
                            class="icon me-1"><i class="fi-rr-trash"> </i></span>delete account</button>
                    <button class="btn solid-btn" type="submit">create </button>
                </div>
            </div>
        </div>
    </form>
    @include('components.ajax-form-assets')
    @include('components.repeater-assets')
    @include('components.admin.pp-cropper')
@endsection

@push('scripts')
    @include('components.admin.pp-cropper-assets')
    <script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pickadate/picker.date.js') }}" type="text/javascript"></script>
@endpush
@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/uicons-solid-rounded.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">languages</h1>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">languages</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="main-box box-spaces mb-0">
<div class="d-flex justify-content-between align-items-center">
<div class="form-item primary">
<h2 class="box-title item-title">Select The Language You Want Display It:</h2>
</div>
<div class="select-all"><a class="btn btn-primary btn-rounded me-2 py-1 text-capitalize">select all</a></div>
</div>
<hr/>
<div class="lang-list-holder">
<ul class="my-list main-list lang-list">
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Afrikaans</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Albanian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Amharic</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Arabic</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Armenian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Azerbaijani</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Basque</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Belarusian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Bengali</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Bosnian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Bulgarian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Catalan</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Cebuano</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Chichewa</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Chinese (Simplified)</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Chinese (Traditional)</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Corsican</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Croatian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Czech</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Danish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Dutch</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">English</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Esperanto</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Estonian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Filipino</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Finnish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">French</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Frisian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Galician</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Georgian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">German</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Greek</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Gujarati</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Haitian Creole</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Hausa</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Hawaiian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Hebrew</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Hindi</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Hmong</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Hungarian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Icelandic</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Igbo</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Indonesian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Irish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Italian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Japanese</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Javanese</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Kannada</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Kazakh</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Khmer</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Kinyarwanda</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Korean</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Kurdish (Kurmanji)</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Kyrgyz</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Lao</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Latin</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Latvian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Lithuanian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Luxembourgish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Macedonian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Malagasy</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Malay</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Malayalam</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Maltese</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Maori</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Marathi</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Mongolian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Myanmar (Burmese)</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Nepali</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Norwegian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Odia (Oriya)</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Pashto</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Persian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Polish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Portuguese</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Punjabi</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Romanian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Russian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Samoan</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Scots Gaelic</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Serbian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Sesotho</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Shona</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Sindhi</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Sinhala</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Slovak</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Slovenian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Somali</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Spanish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Sundanese</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Swahili</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Swedish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Tajik</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Tamil</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Tatar</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Telugu</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Thai</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Turkish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Turkmen</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Ukrainian</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Urdu</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Uyghur</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Uzbek</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Vietnamese</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Welsh</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Xhosa</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Yiddish</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Yoruba</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Zulu</span>
</label>
</li>
</ul>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script>
      // fire category checkbox function 
      checkboxFunctions();
    </script>
@endpush


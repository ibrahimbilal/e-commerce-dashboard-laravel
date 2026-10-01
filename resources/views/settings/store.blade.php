@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/uicons-brands.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">settings</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">settings</span>
</div>
</div>
</div>
</div>
</div>
@csrf
@method('PUT')
<form action="{{ route('settings.update') }}" class="row d-block clearfix" data-post-type="settings" id="settings-form" method="POST">
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Store Address</h2>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="country">country:</label>
<select class="form-select" id="country" name="country">
<option value="">-- Select Country --</option>
<option value="AF">Afghanistan</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>
<option value="AD">Andorra</option>
<option value="AO">Angola</option>
<option value="AI">Anguilla</option>
<option value="AQ">Antarctica</option>
<option value="AG">Antigua and Barbuda</option>
<option value="AR">Argentina</option>
<option value="AM">Armenia</option>
<option value="AW">Aruba</option>
<option value="AU">Australia</option>
<option value="AT">Austria</option>
<option value="AZ">Azerbaijan</option>
<option value="BS">Bahamas</option>
<option value="BH">Bahrain</option>
<option value="BD">Bangladesh</option>
<option value="BB">Barbados</option>
<option value="BY">Belarus</option>
<option value="BE">Belgium</option>
<option value="BZ">Belize</option>
<option value="BJ">Benin</option>
<option value="BM">Bermuda</option>
<option value="BT">Bhutan</option>
<option value="BO">Bolivia</option>
<option value="BA">Bosnia and Herzegovina</option>
<option value="BW">Botswana</option>
<option value="BV">Bouvet Island</option>
<option value="BR">Brazil</option>
<option value="BQ">British Antarctic Territory</option>
<option value="IO">British Indian Ocean Territory</option>
<option value="VG">British Virgin Islands</option>
<option value="BN">Brunei</option>
<option value="BG">Bulgaria</option>
<option value="BF">Burkina Faso</option>
<option value="BI">Burundi</option>
<option value="KH">Cambodia</option>
<option value="CM">Cameroon</option>
<option value="CA">Canada</option>
<option value="CT">Canton and Enderbury Islands</option>
<option value="CV">Cape Verde</option>
<option value="KY">Cayman Islands</option>
<option value="CF">Central African Republic</option>
<option value="TD">Chad</option>
<option value="CL">Chile</option>
<option value="CN">China</option>
<option value="CX">Christmas Island</option>
<option value="CC">Cocos [Keeling] Islands</option>
<option value="CO">Colombia</option>
<option value="KM">Comoros</option>
<option value="CG">Congo - Brazzaville</option>
<option value="CD">Congo - Kinshasa</option>
<option value="CK">Cook Islands</option>
<option value="CR">Costa Rica</option>
<option value="HR">Croatia</option>
<option value="CU">Cuba</option>
<option value="CY">Cyprus</option>
<option value="CZ">Czech Republic</option>
<option value="CI">Côte d’Ivoire</option>
<option value="DK">Denmark</option>
<option value="DJ">Djibouti</option>
<option value="DM">Dominica</option>
<option value="DO">Dominican Republic</option>
<option value="NQ">Dronning Maud Land</option>
<option value="DD">East Germany</option>
<option value="EC">Ecuador</option>
<option value="EG">Egypt</option>
<option value="SV">El Salvador</option>
<option value="GQ">Equatorial Guinea</option>
<option value="ER">Eritrea</option>
<option value="EE">Estonia</option>
<option value="ET">Ethiopia</option>
<option value="FK">Falkland Islands</option>
<option value="FO">Faroe Islands</option>
<option value="FJ">Fiji</option>
<option value="FI">Finland</option>
<option value="FR">France</option>
<option value="GF">French Guiana</option>
<option value="PF">French Polynesia</option>
<option value="TF">French Southern Territories</option>
<option value="FQ">French Southern and Antarctic Territories</option>
<option value="GA">Gabon</option>
<option value="GM">Gambia</option>
<option value="GE">Georgia</option>
<option value="DE">Germany</option>
<option value="GH">Ghana</option>
<option value="GI">Gibraltar</option>
<option value="GR">Greece</option>
<option value="GL">Greenland</option>
<option value="GD">Grenada</option>
<option value="GP">Guadeloupe</option>
<option value="GU">Guam</option>
<option value="GT">Guatemala</option>
<option value="GG">Guernsey</option>
<option value="GN">Guinea</option>
<option value="GW">Guinea-Bissau</option>
<option value="GY">Guyana</option>
<option value="HT">Haiti</option>
<option value="HM">Heard Island and McDonald Islands</option>
<option value="HN">Honduras</option>
<option value="HK">Hong Kong SAR China</option>
<option value="HU">Hungary</option>
<option value="IS">Iceland</option>
<option value="IN">India</option>
<option value="ID">Indonesia</option>
<option value="IR">Iran</option>
<option value="IQ">Iraq</option>
<option value="IE">Ireland</option>
<option value="IM">Isle of Man</option>
<option value="IL">Israel</option>
<option value="IT">Italy</option>
<option value="JM">Jamaica</option>
<option value="JP">Japan</option>
<option value="JE">Jersey</option>
<option value="JT">Johnston Island</option>
<option value="JO">Jordan</option>
<option value="KZ">Kazakhstan</option>
<option value="KE">Kenya</option>
<option value="KI">Kiribati</option>
<option value="KW">Kuwait</option>
<option value="KG">Kyrgyzstan</option>
<option value="LA">Laos</option>
<option value="LV">Latvia</option>
<option value="LB">Lebanon</option>
<option value="LS">Lesotho</option>
<option value="LR">Liberia</option>
<option value="LY">Libya</option>
<option value="LI">Liechtenstein</option>
<option value="LT">Lithuania</option>
<option value="LU">Luxembourg</option>
<option value="MO">Macau SAR China</option>
<option value="MK">Macedonia</option>
<option value="MG">Madagascar</option>
<option value="MW">Malawi</option>
<option value="MY">Malaysia</option>
<option value="MV">Maldives</option>
<option value="ML">Mali</option>
<option value="MT">Malta</option>
<option value="MH">Marshall Islands</option>
<option value="MQ">Martinique</option>
<option value="MR">Mauritania</option>
<option value="MU">Mauritius</option>
<option value="YT">Mayotte</option>
<option value="FX">Metropolitan France</option>
<option value="MX">Mexico</option>
<option value="FM">Micronesia</option>
<option value="MI">Midway Islands</option>
<option value="MD">Moldova</option>
<option value="MC">Monaco</option>
<option value="MN">Mongolia</option>
<option value="ME">Montenegro</option>
<option value="MS">Montserrat</option>
<option value="MA">Morocco</option>
<option value="MZ">Mozambique</option>
<option value="MM">Myanmar [Burma]</option>
<option value="NA">Namibia</option>
<option value="NR">Nauru</option>
<option value="NP">Nepal</option>
<option value="NL">Netherlands</option>
<option value="AN">Netherlands Antilles</option>
<option value="NT">Neutral Zone</option>
<option value="NC">New Caledonia</option>
<option value="NZ">New Zealand</option>
<option value="NI">Nicaragua</option>
<option value="NE">Niger</option>
<option value="NG">Nigeria</option>
<option value="NU">Niue</option>
<option value="NF">Norfolk Island</option>
<option value="KP">North Korea</option>
<option value="VD">North Vietnam</option>
<option value="MP">Northern Mariana Islands</option>
<option value="NO">Norway</option>
<option value="OM">Oman</option>
<option value="PC">Pacific Islands Trust Territory</option>
<option value="PK">Pakistan</option>
<option value="PW">Palau</option>
<option value="PS">Palestinian Territories</option>
<option value="PA">Panama</option>
<option value="PZ">Panama Canal Zone</option>
<option value="PG">Papua New Guinea</option>
<option value="PY">Paraguay</option>
<option value="YD">People's Democratic Republic of Yemen</option>
<option value="PE">Peru</option>
<option value="PH">Philippines</option>
<option value="PN">Pitcairn Islands</option>
<option value="PL">Poland</option>
<option value="PT">Portugal</option>
<option value="PR">Puerto Rico</option>
<option value="QA">Qatar</option>
<option value="RO">Romania</option>
<option value="RU">Russia</option>
<option value="RW">Rwanda</option>
<option value="RE">Réunion</option>
<option value="BL">Saint Barthélemy</option>
<option value="SH">Saint Helena</option>
<option value="KN">Saint Kitts and Nevis</option>
<option value="LC">Saint Lucia</option>
<option value="MF">Saint Martin</option>
<option value="PM">Saint Pierre and Miquelon</option>
<option value="VC">Saint Vincent and the Grenadines</option>
<option value="WS">Samoa</option>
<option value="SM">San Marino</option>
<option value="SA">Saudi Arabia</option>
<option value="SN">Senegal</option>
<option value="RS">Serbia</option>
<option value="CS">Serbia and Montenegro</option>
<option value="SC">Seychelles</option>
<option value="SL">Sierra Leone</option>
<option value="SG">Singapore</option>
<option value="SK">Slovakia</option>
<option value="SI">Slovenia</option>
<option value="SB">Solomon Islands</option>
<option value="SO">Somalia</option>
<option value="ZA">South Africa</option>
<option value="GS">South Georgia and the South Sandwich Islands</option>
<option value="KR">South Korea</option>
<option value="ES">Spain</option>
<option value="LK">Sri Lanka</option>
<option value="SD">Sudan</option>
<option value="SR">Suriname</option>
<option value="SJ">Svalbard and Jan Mayen</option>
<option value="SZ">Swaziland</option>
<option value="SE">Sweden</option>
<option value="CH">Switzerland</option>
<option value="SY">Syria</option>
<option value="ST">São Tomé and Príncipe</option>
<option value="TW">Taiwan</option>
<option value="TJ">Tajikistan</option>
<option value="TZ">Tanzania</option>
<option value="TH">Thailand</option>
<option value="TL">Timor-Leste</option>
<option value="TG">Togo</option>
<option value="TK">Tokelau</option>
<option value="TO">Tonga</option>
<option value="TT">Trinidad and Tobago</option>
<option value="TN">Tunisia</option>
<option value="TR">Turkey</option>
<option value="TM">Turkmenistan</option>
<option value="TC">Turks and Caicos Islands</option>
<option value="TV">Tuvalu</option>
<option value="UM">U.S. Minor Outlying Islands</option>
<option value="PU">U.S. Miscellaneous Pacific Islands</option>
<option value="VI">U.S. Virgin Islands</option>
<option value="UG">Uganda</option>
<option value="UA">Ukraine</option>
<option value="SU">Union of Soviet Socialist Republics</option>
<option value="AE">United Arab Emirates</option>
<option value="GB">United Kingdom</option>
<option value="US">United States</option>
<option value="ZZ">Unknown or Invalid Region</option>
<option value="UY">Uruguay</option>
<option value="UZ">Uzbekistan</option>
<option value="VU">Vanuatu</option>
<option value="VA">Vatican City</option>
<option value="VE">Venezuela</option>
<option value="VN">Vietnam</option>
<option value="WK">Wake Island</option>
<option value="WF">Wallis and Futuna</option>
<option value="EH">Western Sahara</option>
<option value="YE">Yemen</option>
<option value="ZM">Zambia</option>
<option value="ZW">Zimbabwe</option>
<option value="AX">Åland Islands</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="state">State:</label>
<input autocomplete="on" class="form-control" id="state" name="state" type="text"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="city">City:</label>
<input autocomplete="on" class="form-control" id="city" name="city" type="text"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="address-1">Address 1:</label>
<input autocomplete="on" class="form-control" id="address-1" name="address_1" placeholder="Street name and house number" type="text"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="address-2">Address 2:</label>
<input autocomplete="on" class="form-control" id="address-2" name="address_2" placeholder="Apartment, suite, unit, etc. (optional)" type="text"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="postcode">Postcode:</label>
<input autocomplete="on" class="form-control" id="postcode" name="postcode" type="text"/>
</div>
</div>
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Store Settings</h2>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="allow-reviews">Allow Reviews?<span class="icon info ms-2" flow="up" tooltip="check this if you want allow reviews on your store."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input checked="" class="switch" id="allow-reviews" name="reviews" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="allow-guest-reviews">Allow Guest Review:</label>
<label class="switch text-start">
<input checked="" class="switch" id="allow-guest-reviews" name="guest_reviews" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="allow-checkout">Allow Guest Checkout:<span class="icon info ms-2" flow="up" tooltip="check this if you want guest visitors checkout without create account."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input checked="" class="switch" id="allow-checkout" name="guest_checkout" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="active-wishlist">Active Wishlist:</label>
<label class="switch text-start">
<input checked="" class="switch" id="active-wishlist" name="wishlist" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="active-compare">Active Compare:</label>
<label class="switch text-start">
<input checked="" class="switch" id="active-compare" name="compare" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="out-of-stock-products">Allow Out Of Stock products:<span class="icon info ms-2" flow="up" tooltip="check this if you want keep showing out of stock products."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input checked="" class="switch" id="out-of-stock-products" name="out_of_stock_products" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="social-share">Enable Social Share?</label>
<label class="switch text-start">
<input checked="" class="switch control-toggle" data-toggle="social-share-items" id="social-share" name="social_share" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3" id="social-share-items">
<label class="item-title">Enable Share On:</label>
<label class="icon-checkbox">
<input checked="" name="social_share[]" type="checkbox" value="facebook"/><span class="icon facebook"><i class="fi-brands-facebook"> </i></span>
</label>
<label class="icon-checkbox">
<input checked="" name="social_share[]" type="checkbox" value="twitter"/><span class="icon twitter"><i class="fi-brands-twitter"> </i></span>
</label>
<label class="icon-checkbox">
<input name="social_share[]" type="checkbox" value="instagram"/><span class="icon instagram"><i class="fi-brands-instagram"> </i></span>
</label>
<label class="icon-checkbox">
<input checked="" name="social_share[]" type="checkbox" value="whatsapp"/><span class="icon whatsapp"><i class="fi-brands-whatsapp"> </i></span>
</label>
<label class="icon-checkbox">
<input name="social_share[]" type="checkbox" value="mail"/><span class="icon envelope"><i class="fi-rr-envelope"> </i></span>
</label>
</div>
</div>
<div class="main-box box-spaces mb-0">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Store Sections Settings </h2>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="recently-viewed">Active Recently Viewed:<span class="icon info ms-2" flow="up" tooltip="check this if you want show Recently Viewed Section."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input checked="" class="switch" id="recently-viewed" name="recently_viewed" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="recommend">Active Recommendations?<span class="icon info ms-2" flow="up" tooltip="check this if you want show Recommendations Section On Thank You Page."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input checked="" class="switch" id="recommend" name="recommend" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-3 float-end meta-box">
<div class="main-box box-spaces mb-0 mt-3 mt-lg-0">
<div class="btns-holder d-flex justify-content-between">
<button class="btn solid-btn w-100" type="submit">Save Changes </button>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@endpush


@extends('layouts.app')

@section('content')
@push('styles')

<style>
  .active {
    color: #0072BB;
    border: 1px solid #0072BB !important;
  }

  label.error {
    color: red;
    font-size: 16px;
    font-weight: normal;
    line-height: 1.4;
    width: 100%;
    float: none;
  }

  @media screen and (orientation: portrait) {
    label.error {
      margin-left: 0;
      display: block;
    }
  }

  @media screen and (orientation: landscape) {
    label.error {
      display: inline-block;
    }
  }

  input.error {
    background-color: #efa1a4 !important;
  }

  select.error {
    background-color: #efa1a4 !important;
  }

  textarea.error {
    background-color: #efa1a4 !important;
  }

  /* Images section */
  .box-drag {
    /* float: left; */
    display: block;
    width: 24.33%;
    padding: 0 15px;
  }

  .no-padding {
    padding: 0px !important;
  }

  .uploadArea {
    border: dashed #676465;
    text-align: center;
    line-height: 30px;
    font-size: 18px;
    margin-bottom: 20px !important;
    cursor: pointer;
  }

  .uploadArea .new {
    padding-top: 35px;
    padding-bottom: 30px;
    display: block;
  }

  .hidden {
    display: none !important;
  }

  .image-preview img {
    padding-top: 0px !important;
    width: 100%;
    height: 139px;
  }

  .image-preview .remove {
    text-align: right;
    color: white;
    position: absolute;
    width: 100%;
    padding-right: 7px;
    background-color: #373435;
    opacity: .4;
    height: 25px;
  }

  .uploadBtn:hover {
    cursor: pointer;
  }

  .cover_photo {
    color: red;
    position: absolute;
    top: 0;
    z-index: 1000;
  }

  #image_preview {

    border: 1px solid #eee;

    padding: 10px;

  }

  #errmsg {
    color: red;
  }

  #prev_0 {
    position: relative;
  }

  #image_preview img {

    width: 200px;
    height: 200px;
    padding: 5px;

  }

  .suggestion-class {
    height: calc(100% - 200px) !important;
    overflow: auto;
  }

  .carnumber-error {
    width: 100%;
    text-align: left;
    color: red;
    font-size: 16px;
  }

  /*for loader*/
  .loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 80px;
    height: 80px;
    -webkit-animation: spin 2s linear infinite;
    /* Safari */
    animation: spin 2s linear infinite;
    margin: auto;
    margin-top: 100px;
  }

  /* Safari */
  @-webkit-keyframes spin {
    0% {
      -webkit-transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
    }
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .featuredlabel {
    cursor: pointer;
  }
</style>

<link href="{{asset('public/css/sweetalert.min.css')}}" rel="stylesheet" media="all">
@endpush

<div class="internal-page-content mt-4 pt-lg-5 pt-4 sects-bg">
  <div class="container pt-2">
    @if(count($errors) > 0)
    <div class="alert alert-danger">
      {{__('common.error')}}<br><br>
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="row ml-0 mr-0 post-an-ad-row">
      <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
        <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('ads.update_an_ad')}}</h2>
        {{-- END OF CARE NUMBER ENTRY FORM --}}
      </div>
    </div>
    <div class="row ml-0 mr-0 mt-4 post-an-ad-row">
      <div class="col-12 bg-white p-md-4 p-3 pb-sm-5 pb-4">
        @if(count($errors) > 0)
        <div class="alert alert-danger">
          Error<br><br>
          <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger">
          {{ session()->get('error') }}
        </div>
        @endif

        @if(session()->has('message'))
        <div class="alert alert-success">
          {{ session()->get('message') }}
        </div>
        @endif

        @include('messeges.notifications')
        <div class="alert alert-danger alert-dismissable print-error-message" style="display:none">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul class="error-msg"></ul>
        </div>
        <form action="{{route('update.postRemovedAdUpdate')}}" action="" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data">
          {{csrf_field()}}
          <!-- Vehicle Information section starts here -->
          <div class="post-an-ad-sects">
            <!-- <h5 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3">Vehicle Information</h5> -->
            <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold"> {{__('ads.vehicle_information')}}</h4>
            <div class="vehicleInformation">
              <div class="mb-3 row">
                <div class="ml-auto mr-auto col-lg-4 col-md-6 col-12 mandatory-note font-weight-semibold">
                  <span> ({{__('ads.all_fields_mandatory')}})</span>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-8 col-12"> 
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('ads.bought_from')}}<sup class="text-danger">*</sup></label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <select class="form-control" id="boughtfrom" name="country_id">
                                            <option value="">{{__('ads.select_one')}}</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->country_id}}" @if(old('country_id')==$country->
                                                country_id ||$adsDetails->country_id == $country->country_id) {{ 'selected' }} @endif>{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('ads.buy_from')}}</label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <select class="form-control" id="bought_from_id" name="bought_from_id">
                                            <option value="">{{__('ads.select_one')}}</option>
                                            @foreach($boughtFromCountries as $cdesc) 
                                            <option value="{{$cdesc->bought_from_id}}" @if(old('bought_from')==$cdesc->
                                            bought_from_id ||$adsDetails->bought_from_id == $cdesc->bought_from_id) {{ 'selected' }} @endif>{{$cdesc->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="align-items-center form-group mb-sm-4 mb-3 row">
                                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                                        <label class="mb-0 text-capitalize">{{__('ads.register_in_estonia')}}</label>
                                    </div>
                                    <div class="col-md-6 col-sm-7">
                                        <input type="month" name="register_in_estonia" value="{{!empty($adsDetails->register_in_estonia) ? $adsDetails->register_in_estonia : '' }}" class="form-control" placeholder="month-year"  pattern="[0-9]{4}-[0-9]{2}">
                                    </div>
                                </div>


                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('ads.car_info')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input type="text" class="form-control" id="car_info" placeholder="{{@$adsDetails->maker->title}}/{{@$adsDetails->model->name}}/{{@$adsDetails->year}}/{{@$adsDetails->versions->label}}/{{@$adsDetails->versions->cc}} CC {{@$adsDetails->versions->kilowatt}} KW" data-toggle="modal" data-target="#postedcarinfo" data-parsley-error-message="Please Provide Car Info" data-parsley-required="true" data-parsley-trigger="change" disabled="true">
                      <input type="hidden" id="maker" name="maker_id" value="{{$adsDetails->maker_id}}">
                      <input type="hidden" id="maker_title" value="">
                      <input type="hidden" id="model" name="model_id" value="{{$adsDetails->model_id}}">
                      <input type="hidden" id="model_title" value="">
                      <input type="hidden" id="year" name="year" value="{{$adsDetails->year}}">
                      <input type="hidden" id="version" name="version_id" value="{{$adsDetails->version_id}}">
                      <input type="hidden" id="version_title" value="">
                      <input type="hidden" name="ads_id" value="{{$adsDetails->id}}">
                    </div>
                  </div>

                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('ads.body_type')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <select class="form-control select2-field" id="body_type_id" name="body_type_id" data-parsley-error-message="Please select Body Type" data-parsley-required="true" data-parsley-trigger="change">
                        <option value="">{{__('ads.select_one')}}</option>
                        @foreach($bodyTypes as $bodyType)
                        <option value="{{$bodyType->body_type_id}}" @if(old('body_type_id')==$bodyType->body_type_id || $adsDetails->body_type_id ==$bodyType->body_type_id) {{ 'selected' }} @endif>{{$bodyType->name}}</option>
                        @endforeach

                      </select>
                    </div>
                  </div>

                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('ads.doors')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <select class="form-control select2-field" id="doors" name="doors" data-parsley-error-message="Please select doors" data-parsley-required="true" data-parsley-trigger="change">
                        <option value="" disabled selected>{{__('ads.select_one')}}</option>

                        <option value="2" @if(old('doors')==2 || $adsDetails->doors == 2) {{ 'selected' }} @endif>2</option>
                        <option value="3" @if(old('doors')==3 || $adsDetails->doors == 3) {{ 'selected' }} @endif>3</option>
                        <option value="4" @if(old('doors')==4 || $adsDetails->doors == 4) {{ 'selected' }} @endif>4</option>
                        <option value="5" @if(old('doors')==5 || $adsDetails->doors == 5) {{ 'selected' }} @endif>5</option>

                      </select>
                    </div>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade postformmodal" id="postedcarinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                      <div class="modal-content overflow-hidden">
                        <div class="modal-body overflow-hidden pt-0">
                          <div class="row car-list-row" id="make_years">
                            <div class="col-md-3 col-sm-12 car-info-list-col modal-list-col" style="display: none">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> {{__('common.modal')}}</h6>
                              <div class="post-modal-list">
                                <ul class="list-unstyled modal-listings" id="models_listing">
                                  @foreach($models as $y)
                                  <li class="models_class" data-model="{{$y->name}}" id="{{$y->id}}"><a href="JavaScript:Void(0);" class="align-items-center d-flex justify-content-between">{{$y->name}}
                                      <em class="fa fa-angle-right"></em></a></li>
                                  @endforeach
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-12 car-info-list-col modal-year-col" style="display: none">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>{{__('common.modal')}} {{__('common.year')}}</h6>
                              <div class="post-modal-list">
                                <ul class="list-unstyled modal-year-listings">
                                  @foreach(range(date('Y'), date('Y')-79) as $y)
                                  <li class="model_years" data-year="{{$y}}" id="{{$y}}"><a href="JavaScript:Void(0);" class="align-items-center d-flex justify-content-between">{{$y}}
                                      <em class="fa fa-angle-right"></em></a></li>
                                  @endforeach

                                </ul>
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-12 car-info-list-col version-list-col" style="display: none">
                              <div class="loader d-none loader_version"></div>
                            </div>
                          </div>
                          <div class="mb-2 mt-4 post-modal-btn text-center">
                            <a href="#" class="btn  themebtn1" data-dismiss="modal">{{__('ads.done')}}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('ads.mileage')}} (km)<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-sm-7">
                      <input type="number" pattern="[0-9]+([,\.][0-9]+)?" step="0.01" class="form-control" placeholder="{{__('ads.mileage')}}" data-parsley-error-message="Enter valid mileage (1-1000000)" data-parsley-required="true" data-parsley-trigger="change" name="millage" value="{{$adsDetails->millage}}">
                    </div>
                  </div>
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('ads.color')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <select class="form-control" id="color" name="color_id" data-parsley-error-message="Please select Color" data-parsley-required="true" data-parsley-trigger="change">
                        <option value="">{{__('ads.select_one')}}</option>
                        @foreach($colors as $color)
                        <option value="{{$color->color_id}}" @if(old('color')==$color->color_id || $adsDetails->color_id== $color->color_id) {{ 'selected' }} @endif>{{$color->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('ads.fuel_average')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input class="form-control" type="number" pattern="[0-9]+([,\.][0-9]+)?" step="0.01" placeholder="{{__('compare.fuel_average')}}" name="fuel_average" value="{{$adsDetails->fuel_average}}">
                    </div>
                  </div>

                  <div class="form-group mb-4 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mt-sm-1 pt-sm-2 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.price')}}(€)<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input class="form-control" type="text" placeholder="{{__('common.price')}}" name="price" data-parsley-error-message="Please Enter valid price" data-parsley-required="true" data-parsley-trigger="change" value="{{$adsDetails->price}}" onkeydown="javascript: return event.keyCode == 69 ? false : true">
                      <div class="pricecheckboxes mt-3">
                        <div class="custom-control custom-checkbox mt-2">
                          <input type="checkbox" class="custom-control-input" id="pricecheck1" name="vat" value="1" @if($adsDetails->vat == '1') checked @endif >
                          <label class="custom-control-label" for="pricecheck1">{{__('common.incl_20_vat')}}</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                          <input type="checkbox" class="custom-control-input" id="pricecheck2" name="neg" value="1" @if($adsDetails->neg == '1') checked @endif >
                          <label class="custom-control-label" for="pricecheck2">{{__('common.negotiable')}}</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 ad-publishing-plolicy d-lg-block d-none">
                  <div class="ad-publishing-plolicy-bg border p-lg-4 p-3">
                    <h5>{{@$page_description->title}}</h5>
                    <p class="mb-2 pb-1">{!!@$page_description->description!!}</p>
                  </div>
                </div>
              </div>
              {{-- Desription --}}
              @php
              $language = Session::get('language');
              $activeLanguage = $language['id'];
              $suggessions_ads = $adsDetails->suggessions;
              @endphp
              <div class="form-group mb-4 row">
                <div class="col-md-4 mt-md-3 pt-md-2 text-md-right">
                  <label class="mb-0 text-capitalize">{{__('ads.ad_description')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-6 col-md-8 col-12">
                  <div class="about-message-field text-right font-weight-semibold mb-1">
                    <span id="description_count">{{__('ads.remaining_characters')}} 995</span>
                    <a href="javascript:void(0)" id="reset" class="reset-message d-inline-block ml-2 themecolor">{{__('ads.reset')}}</a>
                  </div>
                  <p id="description_error" class="m-0"></p>
                  <textarea id="description" class="form-control" rows="6" name="description" placeholder="Describe your vehicle: Example: Alloy rim, first owner, genuine parts, maintained byauthorized workshop, excellent mileage, original paint etc.">{{@$descript->description}}</textarea>

                  <div class="add-suggestion border mt-2 p-3">
                    <p> {{__('ads.you_can_also_use_suggestions')}}</p>
                    <div class="suggestions-tags">
                      @foreach($suggestions as $suggestion)
                      <a href="JavaScript:Void(0);" class=""><span class="label label-info bgcolor1 badge badge-pill pl-sm-3 pr-sm-3 pr-2 pl-2 text-white mb-2" data-id="{{$suggestion->id}}" data-sentence="{{$suggestion->sentence}}" onclick="getSentence(this)">{{$suggestion->title}}</span></a>
                      @endforeach

                      @foreach($suggessions_ads as $suggestion)
                      <input type="hidden" name="tags[]" value="{{$suggestion->id}}">
                      <input type="hidden" name="suggessions[]" value="{{$suggestion->sentence}}">
                      @endforeach
                    </div>
                  </div>
                  <div class="border border-top-0 pb-2 pl-3 pr-3 pt-2 show-more-suggestion text-center">
                    <a href="javascript:void(0)" class="font-weight-bold themecolor show_more_suggestions">{{__('ads.show_more')}}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Vehicle Information section ends here -->
          <div class="align-items-center form-group mb-sm-4 mb-3 row">
            <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
              <label class="mb-0 text-capitalize">{{__('ads.engine_type')}}<sup class="text-danger">*</sup></label>
            </div>
            <div class="col-md-6 col-lg-5 col-sm-7">
              <select name="fuel_type" id="fuel_type" class="form-control">
                @foreach($engineTypes as $engineType)
                <option value="{{$engineType->engine_type_id}}" @if(old('fuel_type')==$engineType->engine_type_id || $adsDetails->fuel_type == $engineType->engine_type_id) {{ 'selected' }} @endif>{{$engineType->title}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- Additional Information section starts here -->
          <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2 addInformation" style="display: none">
            <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('ads.additional_information')}}</h4>
            <div class="additional-info">

              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.engine_capacity')}} (cc)<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-lg-5 col-sm-7">
                  <input type="text" class="form-control" name="engine_capacity" id="engine_capacity" placeholder="Engine Capacity* (cc)">
                </div>
              </div>
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.engine_power')}} (KW)<sup class="text-danger">*</sup></label>
                </div>

                <div class="col-md-6 col-lg-5 col-sm-7">
                  <input type="text" class="form-control" name="engine_power" id="engine_power" placeholder="engine power (KW)">
                </div>
              </div>
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.engine_type')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-lg-5 col-sm-7">
                  {{-- <select name="fuel_type" id="fuel_type" class="form-control">
                    <option selected value="Petrol">Petrol</option>
                    <option value="CNG">CNG</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Hybrid">Hybrid</option>
                    <option value="LPG">LPG</option>
                  </select> --}}
                </div>
              </div>
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.transmission')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="transmission_type" id="transmission_type" class="form-control">
                    <option value="">{{__('ads.select')}} {{__('ads.transmission')}}</option>
                    <option value="">{{__('common.manual')}}</option>
                    <option value="" selected="selected">{{__('common.automatic')}}</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <h6>{{__('common.features')}}<sup class="text-danger">*</sup></h6>
                </div>
                <div class="col-lg-7 col-sm-9 features-checkboxes">
                  <div class="row">
                    @foreach($features as $feature)
                    <div class="col-md-4 col-6 form-group mb-1">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="featurecheck-{{$feature->id}}" name="features[]" value="{{$feature->id}}">
                        <label class="custom-control-label font-weight-semibold" for="featurecheck-{{$feature->id}}">{{$feature->name}}</label>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Additional Information section Ends here -->


          <!-- Upload Photos section starts here -->
          <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">
          <div class="alert alert-danger alert-dismissable print-error-msg" style="display:none">
                        <ul class="error-msg"></ul>
                    </div>
                    <div class="alert alert-warning alert-dismissable" id="print-error-msg" style="display:none">
                    
            </div>

            <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('spareparts.upload_photos')}}</h4>

            <div class="row pt-4 pb-4" style="border: 2px dotted skyblue;">
              <div class="col-md-12 text-center">
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <div class="col-md-12 col-lg-12 col-xs-12" id="columns">
                      <!--  <h3 class="form-label">Select the images</h3>
                <div class="desc"><p class="text-center">or drag to box</p></div> -->
                      <div class="upload-note mt-0 mb-2">
                        <!--  {{__('ads.photo_extentions')}}
                <br>
                {{__('ads.can_select_multiple')}}<br><br> -->
                        <!-- <button class="btn btn-sm btn-primary uploadBtn">Upload</button> -->
                        <span>
                          <img alt="Images" src="https://wsa4.pakwheels.com/assets/photos-d7a9ea70286f977064170de1eeb6dca8.svg">
                          <span class="uploadBtn ml-3" style="background-color: #007bff;padding: 10px 10px;color: white;margin-top: 5px;"><i class="fa fa-plus"></i> {{__('common.add_photos')}}</span>
                          <p class="m-0" style="margin-left: 100px !important;position: relative;top: -20px;color: #999;">({{__('common.maxlimit_5_mb_per_image')}})</p>
                        </span>
                      </div>
                      <div style="text-align: left;" class="d-none main_cover_photo">
                        <span style="position: absolute;z-index: 1000;margin-left: 10px;margin-top: 17px;color: white;font-weight: bold;">Main Cover Photo</span>
                      </div>
                      <div id="uploads" class="row d-none mt-4">
                        <!-- Upload Content -->
                      </div>
                      <div class="row" style="margin-top: 50px;margin-bottom: 30px;">
                        <div class="col-md-4 offset-1">
                          <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                          <strong style="font-size: 13px;">{{__('common.atleast_five')}}</strong>
                          <span style="color:#999;font-size: 13px;">{{__('common.improves')}}</span>
                        </div>
                        <div class="col-md-5 offset-1">
                          <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                          <strong style="font-size: 13px;">{{__('common.front_clear')}}</strong>
                          <span style="color:#999;font-size: 13px;"> {{__('common.of_your_car')}}</span>
                        </div>

                        <div class="col-md-5 offset-4 mt-5">
                          <i class="fa fa-check-circle-o" style="color: #007bff;"></i>
                          <strong style="font-size: 13px;">{{__('common.photos_should_be')}}</strong>
                          <span style="color:#999;font-size: 13px;"> {{__('common.jpg_png')}}</span>
                        </div>
                      </div>

                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div id="image_preview"></div> -->
            <div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
              <div class="row">
                @if($adImages)
                @foreach($adImages as $img)
                <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar" id="imagecontainer_{{$img->id}}">
                  <figure class="mb-0 position-relative">
                    <img src="{{url('public/uploads/ad_pictures/cars/'.$img->ad_id.'/'.$img->img)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                      <span data-id="{{$img->id}}" class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">REMOVE</span>
                    </figcaption>
                  </figure>
                </div>
                @endforeach
                @endif
              </div>
            </div>
          </div>
          <!-- AUpload Photos section Ends here -->

          <!-- Contact Information section starts here -->
          <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2">
            <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('ads.contact_information')}}</h4>
            <div class="contact-info">
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.name')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-user"></em></span>
                    </div>
                    @if($customerDetail->customer_firstname !='' && $customerDetail->customer_lastname !='')
                    <input type="text" readonly class="form-control" placeholder="Name" name="poster_name" value='{{$customerDetail->customer_firstname.$customerDetail->customer_lastname}}'>
                    @else
                    <input type="text" readonly class="form-control" placeholder="Name" name="poster_name" value='{{$customerDetail->customer_company}}'>
                    @endif
                  </div>
                </div>
              </div>
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.email')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-envelope"></em></span>
                    </div>
                    <input type="text" readonly class="form-control" placeholder="Email" name="poster_email" value="{{$customerDetail->customer_email_address}}">
                  </div>
                </div>
              </div>
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.phone')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-phone"></em></span>
                    </div>
                    <input type="text" readonly class="form-control" placeholder="Phone" name="poster_phone" value="{{$customerDetail->customers_telephone}}">
                  </div>
                </div>
              </div>
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('ads.city')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-home"></em></span>
                    </div>
                    <select placeholder="Choose one City" readonly class="form-control select2-field city_select" name="poster_city">
                      <option value="" disabled selected>{{__('ads.select_one')}}</option>
                      @foreach($cities as $city)
                      <option value="{{$city->id}}" @if(old('poster_city')==$city->id || $customerDetail->citiy_id == $city->id) {{ 'selected' }} @endif>{{$city->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Contact Information section ends here -->
          <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
            <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('ads.update')}}">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="postedCarInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content overflow-hidden">
              <div class="modal-body overflow-hidden pt-0">
                <div class="row car-list-row">
                  <div class="col-md-12 col-sm-12 car-info-list-col make-list-col car-list-active" id="postedCarInfo_contents">
                  </div>
                </div>
                <div class="mb-2 mt-4 post-modal-btn text-center">
                  <a href="#" class="btn  themebtn1" data-dismiss="modal">{{__('ads.next')}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- Feature Modal -->
<div class="modal" id="featureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">{{__('spareparts.post_an_accessory')}}</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="featured_request_form">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <p style="font-style: italic;font-weight: 400;color: red;padding-left: 35px;">{{__('spareparts.note_accessories_limit_reached')}}</p>
                        </div>

                        <div class="alert alert-danger alert-dismissable" id="featured_request_form-error" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <span class="carnumber-error" style="margin-left: 30px;"><strong>Error ! </strong>Please select number of days.</span>
                        </div>

                        @if(@$credit>0)
                        <div style="display:block;padding-left: 20px;">
                            <input type="checkbox" name="use_balance" class="use_balance">
                            <span class="ml-2">{{__('common.use_my_account_balance')}}</span>
                        </div>
                        @endif

                        <input type="hidden" name="ad_id" class="featured_ad_id" value="{{@$adsDetails->id}}">
                        <div class="ad" style="padding: 0 20px;box-shadow: 0px 5px 0px 0px rgba('0,0,0,0.25');">
                            <div class="input-group" id="car_data" style="border: none;margin-top: 40px;margin-left: 30%;">
                                <span style="background-color: white;width: 30%;border-top-left-radius: 5px;border-bottom-left-radius: 5px;border: 1px solid #aaa;border-right: none;padding-left: 5px;line-height: 2;font-weight: 600;" class="feature_span">{{__('spareparts.post_this_accessory_for')}} </span>
                                <select name="featured_days" id="featured_days" style="width: 20%;height: 33px;border-left: none;" class="feature_select">
                                    <option value="">***{{__('common.select_days')}}***</option>
                                    @foreach($ads_pricing as $pricing)
                                        <option value="{{$pricing->number_of_days}}">{{$pricing->number_of_days}} {{__('common.days')}} {{$pricing->pricing}} €</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer" style="justify-content: center;border-top: none;">
                            <button data-dismiss="modal" aria-label="Close" type="button" class="btn btn-danger discard_ad" data-id="{{@$adsDetails->id}}" style="background-color: #eeefff;border: 1px solid #ccc;color: black;">{{__('common.discard')}}</button>
                            <button type="submit" class="btn themebtn3">{{__('home.submit')}}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        </div>
<!-- export pdf form starts -->
<div class="modal" id="sparePartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="exampleModalLabel">{{__('common.paymentdone')}}</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form method="post" name="invoice_number_form" id="invoice_number_form" action="{{route('download-pdf')}}" target="_blank">
            @csrf
            <input type="hidden" name="invoice_number" class="invoice_number">
            <div class="modal-body">
                <div class="row">
                    <p style="font-style: italic;font-weight: 400;color: red;padding-left: 35px;">{{__('spareparts.print_yourinvoice')}}<br>{{__('spareparts.continue_sparepart')}}</p>
                </div>
                <div class="modal-footer" style="justify-content: center;border-top: none;">
                    <button type="submit" class="btn btn-primary" id="print">{{__('spareparts.post_sparepart')}}</button>
                    <button type="submit" class="btn themebtn3" id="print_invoice">{{__('common.print_invoice')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- export pdf form ends -->
</div>
@push('scripts')
{{-- UploadHBR --}}
<script src="{{ asset('public/js/uploadHBR.min.js') }}" ></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"  async defer></script>
{{-- Sweet Alert --}}
<script src="{{asset('public/js/sweetalert.min.js')}}"></script>
<script>

      /* MUTAHIR SCRIPT FOR MAKE MODEL VERSION */
      $(document).ready(function() {
        $('select.city_select').prop('disabled', true);

        $("#reset").click(function() {
          $('#description_count').html(995);
          $('#description').val('');
        });

        $('.show_more_suggestions').on('click', function() {
          $('.add-suggestion').toggleClass('suggestion-class');
          var check = $('.add-suggestion').hasClass('suggestion-class');
          if (check == true) {
            // alert(check);
            $('.show_more_suggestions').text('{{__('ads.show_less ')}}');
          } else {
            $('.show_more_suggestions').text('{{__('ads.show_more ')}}');

          } 
        });

        $("#description").keyup(function(e) { 
          $("#description").prop('maxlength', '995');
          var max = 995;
          var text = $('#description').val().length;
          var remaining = max - text;
          $('#description_count').html(remaining);

          if (max == $('#description').val().length) {
            $("#description_error").html("Maximun letter 995").show().fadeOut("slow");
            return false;
          }
        });

        /* AUT FORM SCRIPT */
        $(document).ajaxSend(function() {
          $("#overlay").fadeIn(300);
        });

        $(document).on('click', '#form_submit', function(e) {
          $("#car_number_form").submit();
        });

        $(document).on('click', '#themebtn1', function(e) {
          e.preventDefault();
          var carnumber = $('#carnumber').val();

          if (carnumber == '') {
            html = '<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>Please enter a number.</h6>';
             $(".carnumber-error").html('Please enter a valid number.');
            $('.carnumber-error').show();
             $("#overlay").fadeOut(300);
            return false;
          }

          $.ajax({
            url: "{{url('user/get-car-info')}}/" + carnumber,
            method: "get",
            dataType: "json",
            success: function(data) {
              var html = '';
              if (data['status'] == 'success') {
                html += '<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>' + data['message'] + '</h6>';

                $.each(data['data'], function(index, value) {
                  $("#car_data").append('<input type="hidden" name="car_data[' + index + ']" value="' + value + '">');
                }); // END FOR EACH

                $(".post-modal-btn").html('<a href="#" class="btn  themebtn1" data-dismiss="modal" id="form_submit">{{__("ads.next")}}</a>');

              }
              if (data['status'] == 'error') {
                html += '<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>' + data['message'] + '</h6>';
                $(".post-modal-btn").html('<a href="#" id="modal_closed" class="btn  themebtn1" data-dismiss="modal">{{__("ads.close")}}</a> ');

              }
              $("#postedCarInfo_contents").html(html);
              $('#postedCarInfo').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
              if (xhr.status == 404 || xhr.status == 500) {
                html = '<h6 style="padding-top:50px" class="d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em>No record found in our database.</h6>';
                $(".post-modal-btn").html('<a href="#" class="btn  themebtn1" data-dismiss="modal">{{__("ads.close")}}</a>');
                $("#postedCarInfo_contents").html(html);
                $('#postedCarInfo').modal('show');
                $("#overlay").fadeOut(300);
              }
            }
          }).done(function() {
            setTimeout(function() {
              $("#overlay").fadeOut(300);
            }, 500);
          });

        });

        $(document).on('click', '#modal_closed', function(e) {
          $("#myForm").show();
          $('#myForm').trigger("reset");
        });

        $(".featured_request_form").on('submit', function(e) {
            e.preventDefault();
            var use_balance = $('.use_balance').val();
            var featured_days = $('#featured_days').val();
            if (featured_days == '') {
                $("#featured_request_form-error").show();
                return false;
            } else {
                $('#myForm').find('.number_of_days').remove();
                $('#myForm').find('#use_balance').remove();
                if (use_balance == 'on') {
                    $('#myForm').append('<input type="hidden"  name="use_balance" id="use_balance" value="' + use_balance + '" />');
                }

                $('#myForm').append('<input type="hidden" class="number_of_days" name="number_of_days" id="number_of_days" value="' + featured_days + '" />');
                $("#featured_request_form-error").hide();
                $('#myForm').submit();
            }

        });

/*        $('.post-removed-ad-submit').on('click',function() {
            var number_of_days = $("[name=number_of_days]").val();
            if (typeof number_of_days == 'undefined') {
              $.ajax({
                  url: "{{route('check_individual_ads')}}",
                  type: 'GET',
                  beforeSend: function() {
                      $("#overlay").fadeOut(300);
                  },
                  success: function(response) {
                      $("#overlay").fadeOut(300);
                      if (response.pay == true) {
                          $('#featureModal').modal('show');
                          $('.post-removed-ad-submit').addClass('disabled');
                          return false;
                      } else {
                          $('#featureModal').modal('hide');
                          $.ajax({
                              url: form.action,
                              type: form.method,
                              data: $('#myForm').serialize(),
                              headers: {
                                  "accept": "application/json",
                              },
                              cache: false,
                              dataType: 'json',
                              beforeSend: function() {
                                  $("#overlay").fadeIn(300);
                              },
                              success: function(response) {
                                  $("#overlay").fadeOut(300);
                                  $('.post-removed-ad-submit').removeClass('disabled');
                                  window.location = "{{route('my-ads')}}?status=0";
                              }
                          }).fail(function(jqXHR, textStatus, errorThrown) {
                              $("#overlay").fadeOut(100);
                              if (jqXHR.status === 422) {
                                  var errors = $.parseJSON(jqXHR.responseText);
                                  printErrorMsg(errors);
                              }
                          });
                      }
                  }
              });
            } // END typeof number_of_days == 'undefined'
            else {
              $.ajax({
                  url: form.action,
                  type: form.method,
                  data: $(form).serialize(),
                  headers: {
                      "accept": "application/json",
                  },
                  cache: false,
                  dataType: 'json',
                  beforeSend: function() {
                      $("#overlay").fadeIn(300);
                  },
                  success: function(response) {
                      $("#overlay").fadeOut(300);
                      $('.invoice_number').val(response.invoice_id);
                      if (response.payment_status != 'full') {
                          $("#invoice_number_form").submit();
                      }
                      window.location = "{{route('my-ads')}}?status=0";
                  }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    $("#overlay").fadeOut(100);
                    if (jqXHR.status === 422) {
                        var errors = $.parseJSON(jqXHR.responseText);
                        printErrorMsg(errors);
                      }
            });
          } // ELSE ENDS HERE
                  
        });
*/
        $("#myForm").validate({
        rules: {
            country_id: {
                required: true
            },
            body_type_id: {
                required: true
            },
            doors: {
                required: true
            },
            color: {
                required: true
            },
            millage: {
                required: true
            },
            price: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            country_id: "{{__('common.please_select_a_country')}}",
            car_info: "{{__('common.please_select_make_model_year_and_versions_etc')}}",
            body_type_id: "{{__('common.please_select_a_body_type')}}",
            doors: "{{__('common.please_select_door')}}",
            color: "{{__('common.please_select_color')}}",
            millage: "{{__('common.please_enter_mileage')}}",
            price: "{{__('common.please_enter_price')}}",
            description: "{{__('common.please_enter_description')}}",
            engine_capacity: "{{__('common.please_enter_engin_capacity')}}",
            engine_power: "{{__('common.please_enter_engin_power')}}",
            poster_city: "{{__('common.please_select_poster_city')}}"
        },
        submitHandler: function(form) {
            var datastring = $(form).serialize();
            var number_of_days = $("[name=number_of_days]").val();
            if (typeof number_of_days == 'undefined') {
                $.ajax({
                    url: "{{route('check_individual_ads')}}",
                    type: 'GET',
                    beforeSend: function() {
                        $("#overlay").fadeOut(300);
                    },
                    success: function(response) {
                        $("#overlay").fadeOut(300);
                        if (response.pay == true) {
                            $('#featureModal').modal('show');
                            $('.post-ad-submit').addClass('disabled');
                            return false;
                        } else {
                            $('#featureModal').modal('hide');
                            $.ajax({
                                url: form.action,
                                type: form.method,
                                data: datastring, 
                                headers: {
                                "accept": "application/json",
                                },
                                cache: false,
                                dataType: 'json',
                                beforeSend: function() {
                                    $("#overlay").fadeIn(300);
                                },
                                success: function(response) {
                                    $("#overlay").fadeOut(300);
                                    $('.post-ad-submit').removeClass('disabled');
                                    window.location = "{{route('my-ads')}}?status=0";
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                            $("#overlay").fadeOut(100);
                            if (jqXHR.status === 422) {
                                var errors = $.parseJSON(jqXHR.responseText);
                                printErrorMsg(errors);
                            }
                        });
                        }
                    }
                });
            } // END typeof number_of_days == 'undefined'
            else {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: datastring,
                    headers: {
                        "accept": "application/json",
                    },
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#overlay").fadeOut(300);
                    },
                    success: function(response) {
                        $("#overlay").fadeOut(300);
                        $('.invoice_number').val(response.invoice_id);
                        if (response.payment_status != 'full') {
                            $("#invoice_number_form").submit();
                        }
                        window.location = "{{route('my-ads')}}?status=0";
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                            $("#overlay").fadeOut(100);
                            if (jqXHR.status === 422) {
                                var errors = $.parseJSON(jqXHR.responseText);
                                printErrorMsg(errors);
                            }
                        });
            }// ELSE ENDS HERE.        
        } //SUBMIT HANDLER ENDS HERE.
    });

        function printErrorMsg(errors, cssClass = '') {
          $('html, body').animate({
            scrollTop: $(".print-error-msg").offset().top
          }, 200);
          $(cssClass + " .print-error-msg").find("ul").html('');
          $(cssClass + " .print-error-msg").css('display', 'block');
          $(cssClass + " .print-error-message").find("ul").html('');
          $(cssClass + " .print-error-message").css('display', 'block');
          $.each(errors, function(key, value) {
            $(cssClass + ' .print-error-msg').remove("alert-success");
            $(cssClass + ' .print-error-msg').addClass("alert-danger");
            $(cssClass + ' .print-error-message').remove("alert-success");
            $(cssClass + ' .print-error-message').addClass("alert-danger");
            if ($.isPlainObject(value)) {
              $.each(value, function(key, value) {
                $(cssClass + " .print-error-msg").find("ul").append('<li>' + value + '</li>');
              });
            } else {
              $(cssClass + " .print-error-message").find("ul").append('<li>' + "{{__('validation.message')}}" + '</li>'); //this is my div with messages
            }
          });
        }

        /* LOAD MAKES AND MODELS */
        $.ajax({
          url: "{{route('maker-list')}}/",
          method: "get",
          success: function(data) {
            $('#make_years').prepend(data);
          }
        }).done(function() {
          setTimeout(function() {
            $("#overlay").fadeOut(300);
          }, 500);
        });

        function loadModels(id) {
          $.ajax({
            url: "{{url('get-make-models')}}/" + id,
            method: "get",
            beforeSend: function() {
              $('#models_listing').html('<div class="loader loader_version"></div>');
              $('.loader_version').removeClass('d-none');
            },
            success: function(data) {
              $('.loader_version').addClass('d-none');
              $('#models_listing').html(data);
            }
          }).done(function() {
            setTimeout(function() {
              $("#overlay").fadeOut(300);
            }, 500);
          });

        }

        $(document).on('click', '.makes', function() {
          var id = $(this).data('make');
          loadModels(id);
          $('.make-list-col').removeClass('car-list-active').addClass('prev-list-active');
          $('.modal-list-col').css('display', 'none').removeClass('car-list-active');
          $('.version-list-col').css('display', 'none').removeClass('car-list-active');
          $('.modal-year-col').css('display', 'none').removeClass('car-list-active');
          var make = $(this).data("make");
          var maker_title = $(this).data("title");
          $('#maker').val(make);
          $('#maker_title').val(maker_title);
          $('#version').val('');
          $('#model').val('');
          $('.models_for_' + make).css('display', 'block').addClass('car-list-active');
        });

        $(document).on('click', '.models', function() {
          $('.modal-list-col').removeClass('car-list-active');
          var model_id = $(this).data("model");
          var model_title = $(this).data("title");
          var maker_title = $('#maker_title').val();
          var model_year = $('#year').val();
          $('.modal-year-col').css('display', 'block').addClass('car-list-active');
          $('#version').val('');
          $('#model').val(model_id);
          $('#model_title').val(model_title); 

        });

        $(document).on('click', '.model_years', function() {
          $('.year-list-col').removeClass('car-list-active');
          $('.version-list-col').css('display', 'none').removeClass('car-list-active');
          var year = $(this).data("year");
          var maker_title = $('#maker_title').val();
          var model_title = $('#model_title').val();
          var model_id = $('#model').val();
          $('#year').val(year);
          $.ajax({
            url: "{{url('get-models-year-versions')}}/" + model_id + "/" + year,
            method: "get",
            beforeSend: function() {
              $('.version-list-col').css('display', 'block').addClass('car-list-active');
              $('.version-list-col').html('<div class="loader loader_version"></div>');
              $('.loader_version').removeClass('d-none');
            },
            success: function(data) {
              $('.loader_version').addClass('d-none');
              $('.version-list-col').css('display', 'block').addClass('car-list-active');
              $('.version-list-col').html(data);
            }
          }).done(function() {
            setTimeout(function() {
              $("#overlay").fadeOut(300);
            }, 500);
          });

        });

        $(document).on('click', '.versions', function() {
          var version_id = $(this).data("version");
          var version_title = $(this).data("title");
          var year = $('#year').val();
          var maker_title = $('#maker_title').val();
          var model_title = $('#model_title').val();
          var cc = $(this).data("cc");
          var power = $(this).data("power");
          var transmission_body = $(this).data("transmission_body");
          $('#version').val(version_id);
          $('#version_title').val(version_title);
          $('#car_info').val(maker_title + "/" + model_title + "/" + year + "/" + version_title + " " + cc + " CC " + transmission_body);
          $('.addInformation').show();
          $('#engine_capacity').val(cc);
          $('#engine_power').val(power);
          $('#postedcarinfo').modal('hide');
        });
      });

      $("#car_info").keypress(function(e) {
        var keyCode = e.which; 
        return false;
      });

      $("#car_info").bind("contextmenu", function(e) {
        e.preventDefault();
      });

      /* END OF MUTAHIR SCRIPT */

      function getCarInfo(e) {

        var year_id = $(e).data('id');
        $.ajax({
          url: "{{url('get-makers-from-year')}}/" + year_id,
          method: "get",
          success: function(data) {
            $('#makers_list').html(data);
            $('#year').val(year_id);
          }
        });
      }

      function getModels(e) {
        var maker_id = $(e).data('id');
        $.ajax({
          url: "{{url('get-models-from-maker')}}/" + maker_id,
          method: "get",
          success: function(data) {
            $('#models_list').html(data);
            $('#maker').val(maker_id);
          }
        });

      }

      function fillInfo(e) {
        var model_id = $(e).data('id');
        $('#model').val(model_id);
        $.ajax({
          url: "{{url('fill-input')}}/" + $('#year').val() + "/" + $('#maker').val() + "/" + model_id,
          method: "get",
          success: function(data) {
            $('#car_info').val(data);
            $('#myModal').modal('hide');
          }
        })

      }

      function textAreaCharacters() {
        $("#description").prop('maxlength', '995');
        var max = 995;
        var text = $('#description').val().length;
        var remaining = max - text;
        $('#description_count').html(remaining);

        if (max == $('#description').val().length) {
          $("#description_error").html("Maximun letter 995").show().fadeOut("slow");
          return false;
        }

      }

      function getSentence(e) {
        textAreaCharacters();
        var sentence = $(e).data('sentence') + '.';
        var id = $(e).data('id');
        var old_sentense = $('#description').val();
        var new_sentense = old_sentense + sentence;
        $('#description').val(new_sentense);
        var field = '<input type="hidden" name="tags[]" value="' + id + '"><input type="hidden" name="suggessions[]" value="' + sentence + '">';
        $('.suggestions-tags').append(field);
        $(e).hide();
      }

      function getSubCategory(e) {
        var cat_id = $(e).data('id');
        var cat_title = $(e).data('title');
        $('#category_id').val(cat_title);
        $.ajax({
          url: "{{url('get-subcategories')}}/" + cat_id,
          method: "get",
          success: function(data) {
            $('#sub_category_list').html(data);
          }
        });

      }

      function selectCategory(e) {
        var sub_category_id = $(e).data('id');
        $('#sub_category').val(sub_category_id);
        var display_value = $('#category_id').val() + '/' + $(e).data('title');
        $('#categories').val(display_value);
        $('#categoriesModal').modal('hide');
      }

      $(document).ready(function() {

        var year = $("#year").val();
        var model_id = $('#model').val();
        $('#year').val(year);
        $.ajax({
          url: "{{url('get-models-year-versions')}}/" + model_id + "/" + year,
          method: "get",
          success: function(data) {
            $('.version-list-col').css('display', 'block').addClass('car-list-active');
            $('.version-list-col').html(data);
          }
        }).done(function() {
          setTimeout(function() {
            $("#overlay").fadeOut(300);
          }, 500);
        });


        $(document).on('click', '.car-info-list-col:not(:last-child) li a', function() {
          $(this).parents('li').addClass('list-active').siblings('li').removeClass('list-active');
        });

        $("#car_info").click(function() {
          var maker = $('#maker').val();
          var modal = $('#model').val();
          var version = $('#version').val();
          var year = $('#year').val();
          $('.make-listings li').removeClass("list-active");
          $('.modal-listings li').removeClass("actilist-activeve");
          $('.version-listings li').removeClass("list-active");
          $('.modal-year-listings li').removeClass("list-active");
          //list-active
          if (maker != '') {
            $("#maker_" + maker).addClass("list-active");
            $(".models_for_" + maker).addClass("car-list-active").show();
          }
          if (modal != '') {
            $("#model_" + modal).addClass("list-active");
            $(".modal-year-col").addClass("car-list-active").show();
            $(".modal-list-col").addClass("car-list-active").show();
            $("#" + modal).addClass("list-active");

          }
          if (version != '') {
            $("#version_" + version).addClass("list-active");
          }
          if (year != '') {
            $("#" + year).addClass("list-active");
          }
        });
        uploadHBR.init({
          "target": "#uploads",
          "max": 8,
          "textNew": "{{__('common.text_new')}}",
          "textTitle": "{{__('common.text_title')}}",
          "textTitleRemove": "{{__('common.text_title_remove')}}",
          "mimes": ["image/jpeg", "image/png","image/gif"],
          "showExtensionError":true,
          "messageSelector":"print-error-msg",
          "errorMessage":"{{__('common.invalid_files')}}",
          "errorMessages":'{{ __("ads.too_big_images") }}'
        });

        $('#reset').click(function() {
          uploadHBR.reset('#uploads');
        });

        $('.uploadBtn').click(function() {
          $('#new_0').trigger('click');

          setTimeout(function() {

            $('#uploads').removeClass('d-none');
            $('.main_cover_photo').removeClass('d-none');
          }, 1000);
        });
        $(document).on('click', '.featuredlabel', function(e) {
          $("#overlay").fadeOut(100);
          e.preventDefault();
          var img_id = $(this).data('id');
          var ad_id = "{{$adsDetails->id}}";
          $("#imagecontainer_" + img_id).hide();
          $.ajax({
            url: "{{route('images.remove')}}",
            method: "get",
            dataType: "json",
            data: {
              img_id: img_id,
              ad_id: ad_id
            },
            success: function(data) {
              if (data.success == true) {
                /* location.reload(); */
                $("#imagecontainer_" + img_id).hide();
              } else {
                $("#imagecontainer_" + img_id).show();
              }
            },
            error: function() {
              alert("{{__('ads.error')}}");
              $("#imagecontainer_" + img_id).show();
            }
          }).done(function() {
            setTimeout(function() {
              $("#overlay").fadeOut(300);
            }, 500);
          });


        });


        $(document).on('click', '.featuredlabelOld', function(e) {
          e.preventDefault();
          var img_id = $(this).data('id');
          var ad_id = "{{$adsDetails->id}}";
          swal({
              title: "{{__('ads.you_sure')}}",
              text: "{{__('ads.you_sure_toremove')}}",
              type: "error",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "{{__('ads.yes_do')}}",
              cancelButtonText: "{{__('ads.cancel')}}",
              closeOnConfirm: true,
              closeOnCancel: true
            },
            function(isConfirm) {
              if (isConfirm) {

                $.ajax({
                  url: "{{route('images.remove')}}",
                  method: "get",
                  dataType: "json",
                  data: {
                    img_id: img_id,
                    ad_id: ad_id
                  },
                  success: function(data) {
                    if (data.success == true) {
                      toastr.success('Success!', "{{__('ads.removed_success')}}", {
                        "positionClass": "toast-botom-right"
                      });
                      location.reload();
                    }
                  },
                  error: function() {
                    alert("{{__('ads.error')}}");
                  }
                });

              } else {
                swal("{{__('ads.cancelled')}}", " ", "error");
                e.preventDefault();
              }
            });
        });



      });
    </script>
@endpush
@endsection
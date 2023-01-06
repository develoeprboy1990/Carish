@extends('layouts.app')
@section('title') {{ __('header.post_a_spare_part_ad') }} @endsection
@section('content')
@push('styles')
<style type="text/css">
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

  .uploadBtn:hover {
    cursor: pointer;
  }
</style>
@endpush
@php
$activeLanguage = \Session::get('language');
@endphp
<div class="internal-page-content mt-4 pt-lg-5 pt-4 sects-bg">
  <div class="container pt-2">
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

    <div class="alert alert-danger alert-dismissable print-error-message" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <ul class="error-msg"></ul>
    </div>

    <div class="row ml-0 mr-0 post-an-ad-row">
      <div class="col-11 bg-white p-md-4 p-3 pb-sm-5 pb-4">
        <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('spareparts.post_an_accessory')}}</h2>
        <form action="{{url('user/save-part-ad')}}" method="post" name="myForm" id="myForm" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate>
          {{csrf_field()}}
          <div class="post-an-ad-sects">
            <h4 class="mx-md-n4 mx-n3 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">{{__('spareparts.accessory_information')}}</h4>
            <div class="vehicleInformation">
              <div class="mb-3 row">
                <div class="ml-auto mr-auto col-lg-4 col-md-6 col-12 mandatory-note font-weight-semibold">
                  <span>({{__('ads.all_fields_mandatory')}})</span>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-8 col-12">
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-2 text-sm-right text-md-right">
                      <label class="mb-0 text-capitalize">{{__('common.title')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <p id="title_error" class="m-0"></p>
                      <input type="text" name="title" class="form-control" placeholder="{{__('spareparts.product_name')}}" data-parsley-error-message="Please select Product Name" data-parsley-required="true" data-parsley-trigger="change" id="title">
                      <div class="about-message-field mt-1">
                        <span class="font-weight-semibold">{{__('spareparts.remaining_characters')}} <span id="title_count">50</span></span>
                      </div>
                    </div>
                  </div>
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.product_code')}}</label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input type="text" name="product_code" class="form-control" placeholder="{{__('common.product_code')}}" >
                    </div>
                  </div>
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.category')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input type="text" id="categories" name="spare_categories" class="form-control" placeholder="{{__('common.category')}}/{{__('common.sub_category')}}" data-toggle="modal" autocomplete="nope" data-target="#category-subcategory">
                      <input type="hidden" name="category" id="category_id">
                      <input type="hidden" id="category_title" name="category_title" value="">
                      <input type="hidden" name="sub_category" id="sub_category">
                    </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade postformmodal" id="category-subcategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content overflow-hidden">
                        <div class="modal-body overflow-hidden pt-0">
                          <div class="row car-list-row">
                            <div class="col-md-6 col-sm-12 car-info-list-col car-list-active modal-year-col">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4" class="post-ad-modal-title">{{__('common.category')}}</h6>
                              <div class="post-modal-list">
                                <ul class="list-unstyled modal-year-listings">
                                  @foreach($categorise as $category)
                                  @php $skips = ["[","]","\""];
                                  $p_caty = $category->title;
                                  @endphp
                                  <li onclick="getSubCategory(this)" data-title="{{$p_caty}}" data-id="{{$category->id}}"><a href="javascript:void(0)" class="align-items-center d-flex justify-content-between">{{@$p_caty}}<em class="fa fa-angle-right"></em></a>
                                  </li>
                                  @endforeach
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12 car-info-list-col version-list-col" id="sub-categories" style="display: block">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> {{__('common.sub_category')}}</h6>
                              <div class="post-modal-list">
                                <div class="loader d-none"></div>
                                <ul class="list-unstyled version-listings" id="sub_category_list_2"></ul>
                              </div>
                            </div>
                          </div>
                          <div class="mb-2 mt-4 post-modal-btn text-center">
                            <a href="#" class="btn  themebtn1 disabled done_spare_categories" data-dismiss="modal">{{__('ads.done')}}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- My Modal -->
                  <div id="categoriesModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">{{__('common.select_category')}}</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <div class="col-md-6">
                            <h4>{{__('common.select_category')}}</h4>
                            <ul>
                              @foreach($categorise as $category)
                              <li onclick="getSubCategory(this)" data-title="{{$category->title}}" data-id="{{$category->id}}">{{$category->title}}</li>
                              @endforeach
                            </ul>
                          </div>
                          <div class="col-md-6">
                            <h4>{{__('common.select_sub_category')}}</h4>
                            <ul id="sub_category_list"></ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- My Modal Ends -->
                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.condition')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <select class="form-control" id="condition" name="condition" data-parsley-error-message="Please select a Condition" data-parsley-required="true" data-parsley-trigger="change">
                        <option value="" disabled selected>{{__('ads.select_one')}}</option>
                        <option value="New">{{__('common.new')}}</option>
                        <option value="Used">{{__('common.used')}}</option>
                        <option value="Used">{{__('common.restored')}}</option>

                      </select>
                    </div>
                  </div>
                  <div class="form-group mb-4 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mt-sm-1 pt-sm-2 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.price')}} (€)<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <p id="errmsg" class="m-0"></p>
                      <input class="form-control" type="text" placeholder="{{__('common.price')}}" id="price" name="price" data-parsley-error-message="Please Enter valid price" data-parsley-required="true" data-parsley-trigger="change" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" title="This should be a number with up to 2 decimal places.">
                      <div class="pricecheckboxes mt-3">
                        <div class="custom-control custom-checkbox mt-2">
                          <input type="checkbox" class="custom-control-input" id="pricecheck1" name="vat">
                          <label class="custom-control-label" for="pricecheck1">{{__('common.incl_20_vat')}}</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                          <input type="checkbox" class="custom-control-input" id="pricecheck2" name="neg">
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
              <div class="form-group mb-4 row">
                <div class="col-md-4 mt-md-3 pt-md-3 text-md-right">
                  <label class="mb-0 text-capitalize">{{__('spareparts.ad_description')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-6 col-md-8 col-12">
                  <div class="about-message-field text-right mb-1">
                    <span class="d-inline-block text-left">{{__('spareparts.we_dont_allow_promotional')}}</span>
                  </div>
                  <p id="description_error" class="m-0"></p>
                  <textarea id="description" class="form-control" placeholder="{{__('spareparts.describe_your_product')}}" rows="6" name="description" data-parsley-error-message="Please Provide Description" data-parsley-required="true" data-parsley-trigger="change">{{old('description')}}</textarea>

                  <div class="about-message-field mt-1">
                    <span class="font-weight-semibold">{{__('spareparts.remaining_characters')}} <span id="description_count">995</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Additional Information section starts here -->
          <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2 addInformation" style="display: none">
              <h4 class="border-bottom mx-md-n4 mx-n3 pb-sm-3 pb-2 px-md-4 px-3 mb-sm-4 mb-3 font-weight-bold">
                  {{__('ads.additional_information')}}
              </h4>
              <div class="additional-info">
                <!-- f1 f2 started -->
                <div class="align-items-center form-group mb-sm-4 mb-3 row f1 f2" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize"><b>{{__('common.can_be_used_with')}}</b></label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7"></div>
                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f1 f2" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.make')}}</label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="make_id" id="make_id" class="form-control" onchange="loadModels(this.value)">
                  <option value="" selected>{{__('ads.select_one')}}</option>
                      @foreach($makes as $make)
                      <option value="{{$make->id}}" @if(old('make_id')==$make->id) {{ 'selected' }} @endif>{{$make->title}}</option>
                      @endforeach
                  </select>
                      </div>
                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f1 f2" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.modal')}}</label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7" >
                          <select name="model_id" id="models_listing" class="form-control">
                            <option value="" selected>{{__('ads.select_one')}}</option>
                          </select>
                      </div>
                  </div>
                <!-- f1 started -->

                <!-- f2 continue -->
                <div class="align-items-center form-group mb-sm-4 mb-3 row f2" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize"><b>{{__('ads.engine_power')}}</b></label>
                      </div>

                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f2" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.liter')}}</label>
                      </div>

                      <div class="col-md-6 col-lg-5 col-sm-7">
                          <input type="text" value="{{old('f2_liter')}}" class="form-control" name="f2_liter" id="f2_liter" placeholder="1.3">
                      </div>
                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f2" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.kw')}}</label>
                      </div>

                      <div class="col-md-6 col-lg-5 col-sm-7">
                          <input type="text" value="{{old('kw')}}" class="form-control" name="f2_kw" id="f2_kw" placeholder="78">
                      </div>
                  </div>
                <!--f2 end -->

                <div class="align-items-center form-group mb-sm-4 mb-3 row brand" style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.brand')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <select name="brand" id="brand" class="form-control" required>
                            <option value="" selected>{{__('ads.select_one')}}</option>
                          @foreach($brands as $brand)
                            <option value="{{$brand->id}}" @if(old('brand')==$brand->id) {{ 'selected' }} @endif>{{$brand->title}}</option>
                          @endforeach
                      </select>
                    </div>
                </div>


                <div class="align-items-center form-group mb-sm-4 mb-3 row num_of_channel " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.num_of_channel')}}</label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('num_of_channel')}}" class="form-control" name="num_of_channel" id="num_of_channel"  placeholder="{{__('common.num_of_channel')}}" >
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row size " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.size')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('size')}}" class="form-control" name="size" id="size" placeholder="{{__('common.size')}}" required>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row screen_size " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.screen_size')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('screen_size')}}" class="form-control" name="screen_size" id="screen_size" value="" required>
                    </div>
                </div>
                
                <div class="align-items-center form-group mb-sm-4 mb-3 row size_inch " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.size_inch')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('size_inch')}}" class="form-control" name="size_inch" id="size_inch" placeholder="{{__('common.size_inch')}}" required>
                    </div>
                </div>
                
                <!-- f3 started -->
                <div class="align-items-center form-group mb-sm-4 mb-3 row f3" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.manufacturer_tyre')}}</label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="f3_tyre_manufacturer" id="f3_tyre_manufacturer" class="form-control">
                  <option value="" selected>{{__('ads.select_one')}}</option>
                      @foreach($tyre_manufacturers as $tyre)
                      <option value="{{$tyre->id}}" @if(old('tyre_manufacturer')==$tyre->id) {{ 'selected' }} @endif>{{$tyre->title}}</option>
                      @endforeach
                  </select>
                      </div>
                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f3 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.size')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('f3_size')}}" class="form-control" name="f3_size" id="f3_size" value="" placeholder="175/65/R14" required>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f3" style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.type')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-lg-5 col-sm-7">
                      <input type="checkbox" name="f3_type[]" value="summer" required> {{__('common.summer')}} <br>
                      <input type="checkbox" name="f3_type[]" value="winter" required> {{__('common.winter')}} <br>
                      <input type="checkbox" name="f3_type[]" value="all_season" required> {{__('common.all_season')}} <br>
                      <input type="checkbox" name="f3_type[]" value="studded" required> {{__('common.studded')}} <br> 
                      <input type="checkbox" name="f3_type[]" value="offroad" required> {{__('common.offroad')}} <br>
                      <input type="checkbox" name="f3_type[]" value="racing" required> {{__('common.racing')}} <br>
                      <label id="f3_type[]-error" class="error" for="f3_type[]"></label>
                    </div>

                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f3" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.quantity')}}<sup class="text-danger">*</sup></label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="f3_quantity" id="f3_quantity" class="form-control" required>
                  <option value="" selected>{{__('ads.select_one')}}</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value=">4">>4</option>
                  </select>
                      </div>
                  </div>
                <!--f3 end -->


                <!--f4 started -->               
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.manufacturer_rim')}}</label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="f4_wheel_manufacturer" id="f4_wheel_manufacturer" class="form-control">
                  <option value="" selected>{{__('ads.select_one')}}</option>
                      @foreach($wheel_manufacturers as $wheel)
                      <option value="{{$wheel->id}}" @if(old('wheel_manufacturer')==$wheel->id) {{ 'selected' }} @endif>{{$wheel->title}}</option>
                      @endforeach
                  </select>
                      </div>
                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.size_inch')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('f4_size_inch')}}" class="form-control" name="f4_size_inch" id="f4_size_inch" value="" placeholder="14*6.5" required>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.offset_mm')}}</label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('f4_offset_mm')}}" class="form-control" name="f4_offset_mm" id="f4_offset_mm" value="" placeholder="39">
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.style')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-lg-5 col-sm-7">
                      <input type="radio" name="f4_style" value="steel" required>&nbsp;{{__('common.steel')}} &nbsp;&nbsp;
                      <input type="radio" name="f4_style" value="alloy" required>&nbsp;{{__('common.alloy')}} &nbsp;&nbsp;
                      <input type="radio" name="f4_style" value="chrome" required>&nbsp;{{__('common.chrome')}} &nbsp;&nbsp;
                      <label id="f4_style-error" class="error" for="f4_style"></label>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.num_of_holes')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('f4_num_of_holes')}}" class="form-control" name="f4_num_of_holes" id="f4_num_of_holes" value="" placeholder="4" required>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.distance_between_holes')}}</label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{old('f4_distance_between_holes')}}" class="form-control" name="f4_distance_between_holes" id="f4_distance_between_holes" value="" placeholder="100 ">
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.quantity')}}</label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="f4_quantity" id="f4_quantity" class="form-control">
                  <option value="" selected>{{__('ads.select_one')}}</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value=">4">>4</option>
                  </select>
                      </div>
                  </div>              
              </div>
          </div>
          <!-- Additional Information section Ends here -->

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
                      <div class="upload-note mt-0 mb-2">
                        <span>
                          <img alt="Images" src="https://wsa4.pakwheels.com/assets/photos-d7a9ea70286f977064170de1eeb6dca8.svg">
                          <span class="uploadBtn ml-3" style="background-color: #007bff;padding: 10px 10px;color: black;margin-top: 5px;"><i class="fa fa-plus"></i> {{__('common.add_photos')}}</span>
                          <p class="m-0" style="margin-left: 100px !important;position: relative;top: -20px;color: #999;">({{__('common.maxlimit_5_mb_per_image')}})</p>
                        </span>
                      </div>
                      <div style="text-align: left;" class="d-none main_cover_photo">
                        <span style="position: absolute;z-index: 1000;margin-left: 10px;margin-top: 16px;color: white;font-weight: bold;">Main Cover Photo</span>
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
          </div>

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
                    <input type="text" class="form-control" value="{{@$customer->customer_company}}" name="poster_name" value="" placeholder="{{__('ads.name')}}" readonly="true">
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
                    <input type="text" class="form-control" placeholder="{{__('ads.email')}}" name="poster_email" value="{{@$customer->customer_email_address}}" readonly="true">
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
                    <input type="text" class="form-control" placeholder="{{__('ads.phone')}}" name="poster_phone" data-parsley-error-message="Please Enter Valid Phone No" data-parsley-required="true" data-parsley-trigger="change" value="{{@$customer->customers_telephone}}" readonly="true">

                  </div>
                </div>
              </div>
              <div class="align-items-center form-group mb-sm-4 mb-3 row">
                <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                  <label class="mb-0 text-capitalize">{{__('common.city')}}<sup class="text-danger">*</sup></label>
                </div>
                <div class="col-lg-4 col-sm-6 col-sm-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text justify-content-center"><em class="fa fa-home"></em></span>
                    </div>
                    <select name="poster_city" disabled="disabled" placeholder="Choose one City" class="form-control select2-field">
                      <option value="" disabled selected>Choose City</option>
                      @foreach($cities as $city)
                      <option value="{{$city->id}}" @if(@$customer->citiy_id == $city->id) {{ 'selected' }} @endif>{{$city->name}}</option>
                      @endforeach
                    </select>

                    <input type="hidden" class="form-control" placeholder="Phone" name="poster_city" data-parsley-error-message="Please Enter Valid Phone No" data-parsley-required="true" data-parsley-trigger="change" value="{{@$customer->citiy_id}}" readonly="true">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Contact Information section ends here -->

          <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
            <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('ads.submit_and_continue')}}">
          </div>
        </form>
      </div>
    </div>
  </div>
  {{--@if(Session::has('ad')) --}}
  @php
  $ad = Session::get('ad');
  @endphp

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

            <div class="alert alert-danger alert-dismissable" id="carnumber-error" style="display:none">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <span class="carnumber-error" style="margin-left: 30px;"><strong>Error ! </strong>Please select number of days.</span>
            </div>

            @if(@$credit>0)
            <div style="display:block;padding-left: 20px;">
              <input type="checkbox" name="use_balance" class="use_balance">
              <span class="ml-2">{{__('common.use_my_account_balance')}}</span>
            </div>
            @endif

            <input type="hidden" name="ad_id" class="featured_ad_id" value="{{@$ad->id}}">
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
              <button data-dismiss="modal" aria-label="Close" type="button" class="btn btn-danger discard_ad" data-id="{{@$ad->id}}" style="background-color: #eeefff;border: 1px solid #ccc;color: black;">{{__('common.discard')}}</button>
              <button type="submit" class="btn themebtn3">{{__('home.submit')}}</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- export pdf form starts -->
  <!-- Feature Modal -->
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
  <!-- Loader Modal -->
  <div class="modal" id="loader_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <h3 style="text-align:center;">{{ __('common.please_wait') }}</h3>
          <p style="text-align:center;"><img src="{{ asset('public/assets/img/gif/waiting.gif') }}"></p>
        </div>
      </div>
    </div>
  </div>
  @push('scripts')
  {{-- UploadHBR --}}
  <script src="{{ asset('public/js/uploadHBR.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
  <script type="text/javascript">
  @if(Session::has('ad'))
    $('.not_found').removeClass('d-none');
    $('.make_it_featured').trigger('click');
  @endif

  @if(Session::has('successmessage'))
    toastr.success('Success!', "{{Session::get('successmessage')}}", {
      "positionClass": "toast-bottom-right"
    });
  @endif
  $('.post-ad-submit').on('click', function() {
      $('.post-ad-submit').addClass('disabled');
      setTimeout(function() {

        $('.post-ad-submit').removeClass('disabled');

      }, 5000);
    })
  $('.uploadBtn').click(function() {
      $('#new_0').trigger('click');

      setTimeout(function() {

        $('#uploads').removeClass('d-none');
        $('.main_cover_photo').removeClass('d-none');
      }, 1000);
    });
  $(document).ready(function() {
      var customer_role = "{{$customer->customer_role}}";
      $('input').attr('autocomplete', 'nope');
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
      $("#myForm").validate({
        rules: {
          title: {
            required: true
          },
          city: {
            required: true
          },
          spare_categories: {
            required: true
          },
          condition: {
            required: true
          },
          price: {
            required: true
          },
          description: {
            required: true
          },
          "file[]": {
            required: true
          },
          poster_city: {
            required: true
          },
          f4_style: {
            required: true
          },
          'f3_type[]': {
                required: true
            }
        },
        messages: {
          title: "{{__('common.please_enter_title')}}",
          product_code: "{{__('common.please_select_product_code')}}",
          city: "{{__('common.please_select_city')}}",
          spare_categories: "{{__('common.please_select_categories')}}",
          condition: "{{__('common.please_select_condition')}}",
          price: "{{__('common.please_enter_price')}}",
          description: "{{__('common.please_enter_description')}}",
          "file[]": "{{__('common.please_select_atleast_one_photo')}}",
          poster_city: "{{__('common.please_select_poster_city')}}",
          brand:"{{__('common.please_enter_brand')}}",
          size:"{{__('common.please_enter_size')}}",
          screen_size:"{{__('common.please_enter_screen_size')}}",
          size_inch:"{{__('common.please_enter_size_inch')}}",
          f3_size:"{{__('common.please_enter_f3_size')}}",
          f3_type:"{{__('common.please_enter_f3_type')}}",
          f3_quantity:"{{__('common.please_enter_f3_quantity')}}",
          f4_size_inch:"{{__('common.please_enter_f4_size_inch')}}",
          f4_style:"{{__('common.please_enter_f4_style')}}",
          f4_num_of_holes:"{{__('common.please_enter_f4_num_of_holes')}}",
          'f3_type[]': {
                required: "{{__('common.please_enter_f3_type')}}"
            }
        },
        submitHandler: function(form) {
          var number_of_days = $("[name=number_of_days]").val();
          if (typeof number_of_days == 'undefined') {
              $.ajax({
                url: "{{route('check_individual_spare_parts_numbers')}}",
                type: 'GET',
                beforeSend: function() {
                  $("#overlay").fadeIn(300);
                },
                success: function(response) {
                  $("#overlay").fadeOut(300);
                  if (response.pay == true) {
                    $('#featureModal').modal('show');
                    $('.post-ad-submit').addClass('disabled');
                    return false;
                  } else {
                    $('.post-ad-submit').removeClass('disabled');
                    $('#featureModal').modal('hide');
                    $.ajax({
                      url: form.action,
                      type: form.method,
                      data: $(form).serialize(),
                      beforeSend: function() {
                        $("#overlay").fadeIn(300);
                      },
                      success: function(response) {
                        $("#overlay").fadeOut(300);
                        window.location = "{{route('my-spear-parts-ads')}}?status=0";
                      }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                      $("#overlay").fadeOut(100);
                      if (jqXHR.status === 422) {
                        var errors = $.parseJSON(jqXHR.responseText);
                        printErrorMsg(errors);
                      }
                    });
                  } // END ELSE
                } // END SUCCESS
              });
            } // END typeof number_of_days == 'undefined'
          else { 
              $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                beforeSend: function() {
                  $("#overlay").fadeIn(100);
                },
                success: function(response) {
                  $("#overlay").fadeOut(100);
                  $('.invoice_number').val(response.invoice_id);
                  if (response.payment_status != 'full') {
                    $("#invoice_number_form").submit();
                  }
                  window.location = "{{route('my-spear-parts-ads')}}?status=0";
                }
              });
            } // END ELSE

        }

      });
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
  $(".featured_request_form").on('submit', function(e) {
      e.preventDefault();
      var use_balance = $('.use_balance').val();
      var featured_days = $('#featured_days').val();
      if (featured_days == '') {
        $("#carnumber-error").show();
        return false;
      } else {
        $('#myForm').find('.number_of_days').remove();
        $('#myForm').find('#use_balance').remove();
        if (use_balance == 'on') {
          $('#myForm').append('<input type="hidden"  name="use_balance" id="use_balance" value="' + use_balance + '" />');
        }

        $('#myForm').append('<input type="hidden" class="number_of_days" name="number_of_days" id="number_of_days" value="' + featured_days + '" />');
        $("#carnumber-error").hide();
        $('#myForm').submit();
      }

    });
  $("#customFile").change(function() {
      $('#image_preview').html("");
      var total_file = document.getElementById("customFile").files.length;
      for (var i = 0; i < total_file; i++) {
        $('#image_preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "'>");
      }
    });
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
  function getSubCategory(e) {
      //$('.done_spare_categories').removeClass('disabled');
      var cat_id = $(e).data('id');
      var cat_title = $(e).data('title');
      $('#category_id').val(cat_id);
      $('#category_title').val(cat_title);
      $.ajax({
        url: "{{url('user/get-spearpart-subcategories')}}/" + cat_id,
        method: "get",
        beforeSend: function() {
          $('.loader').removeClass('d-none');
        },
        success: function(data) {
          $('#sub_category_list').html(data);
          $('#sub_category_list_2').html(data);
          $('.loader').addClass('d-none');

        }
      });
}

  function selectCategory(e) {

   
      $('.f2').hide();
      $('.f3').hide();
      $('.f4').hide();
      $('.f1').hide();
      $('.brand').hide();
      $('.num_of_channel').hide();
      $('.size').hide();
      $('.screen_size').hide();
      $('.size_inch').hide();


      var sub_category_id = $(e).data('id');
      var sub_category_filter = $(e).data('filter');
      var result = sub_category_filter.split('_');

      if(result[0] == 'f1')
      {
        $('.f2').hide();
        $('.f3').hide();
        $('.f4').hide();
        $('.f1').show();
      }
      if(result[0] == 'f2')
      {
        $('.f1').hide();
        $('.f3').hide();
        $('.f4').hide();
        $('.f2').show();
      }
      if(result[0] == 'f3')
      {
        $('.f1').hide();
        $('.f2').hide();
        $('.f4').hide();
        $('.f3').show();
      }
      if(result[0] == 'f4')
      {
        $('.f1').hide();
        $('.f2').hide();
        $('.f3').hide();
        $('.f4').show();
      }

      if(result[1] == 'Brand')
      {
        $('.brand').show();
      }
      if(result[1] == 'Size')
      {
        $('.size').show();
      }
      if(result[1] == 'SizeInch')
      {
        $('.size_inch').show();
      }
      if(result[1] == 'f4')
      {
        $('.f4').show();
      }
      

      if(result[2] == 'NumOfChannel')
      {
        $('.num_of_channel').show();
      }
      if(result[2] == 'Size')
      {
        $('.size').show();
      }
      if(result[2] == 'ScreenSize')
      {
        $('.screen_size').show();
      }
      

      

      


      $('#sub_category').val(sub_category_id);
      var display_value = $('#category_title').val() + '/' + $(e).data('title');
      $('#categories').val(display_value);
      $('#categoriesModal').modal('hide');
      $('#category-subcategory').modal('hide');
      $('.addInformation').show();
    }

  function loadModels(id) {
        var check_array_for_make = $('#model').val();

        $.ajax({
            url: "{{url('get-sp-models')}}/" + id,
            method: "get",
            beforeSend: function() {
                //$('#models_listing').html('<div class="loader loader_version"></div>');
            },
            success: function(data) {
                //$('.loader_version').addClass('d-none');
                $('#models_listing').html(data);
            }
        }).done(function() {
            setTimeout(function() {
                $("#overlay").fadeOut(300);
            }, 500);
        });

    }
  $(function() {

      $('.gobackIcon').on('click', function() {
        $(this).parents('.car-info-list-col').hide();
        $(this).parents('.car-info-list-col').prev('.car-info-list-col').show().removeClass('prev-list-active');
      });

      $('.car-info-list-col:not(:last-child) li a').on('click', function() {
        // alert('hi');
        $(this).parents('.car-info-list-col').removeClass('car-list-active').next('.car-info-list-col').addClass('car-list-active').show().prev('.car-info-list-col').addClass('prev-list-active');
        $(this).parents('li').addClass('list-active').siblings('li').removeClass('list-active');
        $(this).parents('.car-info-list-col').siblings('.car-info-list-col').find('li').removeClass('list-active');
      });

      $(document).on('click', '.car-info-list-col ul.version-listings li', function() {
        // alert('finaaly');
        $('ul.version-listings li').removeClass('list-active');
        $(this).addClass(' list-active');
      });
    });
  $(document).ready(function() {
      $("#price").keypress(function(e) {
        var max = 9;
        if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
          $("#errmsg").html("Digits Only").show().fadeOut("slow");
          return false;
        }
        if (max < $('#price').val().length) {
          $("#errmsg").html("Maximun 10 numbers").show().fadeOut("slow");
          return false;
        }
      });
      $('#price').keypress(function(event) {
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
          ((event.which < 48 || event.which > 57) &&
            (event.which != 0 && event.which != 8))) {
          event.preventDefault();
        }

        var text = $(this).val();
        if ((event.which == 46) && (text.indexOf('.') == -1)) {
          setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 3) {
              $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
          }, 1);
        }

        if ((text.indexOf('.') != -1) &&
          (text.substring(text.indexOf('.')).length > 2) &&
          (event.which != 0 && event.which != 8) &&
          ($(this)[0].selectionStart >= text.length - 2)) {
          event.preventDefault();
        }
      });
      $('#price').bind("paste", function(e) {
        var text = e.originalEvent.clipboardData.getData('Text');
        if ($.isNumeric(text)) {
          if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
            e.preventDefault();
            $(this).val(text.substring(0, text.indexOf('.') + 3));
          }
        } else {
          e.preventDefault();
        }
      });
      $("#description").keyup(function(e) {
        // alert('hi');
        $("#description").prop('maxlength', '995');
        var max = 995;
        var text = $('#description').val().length;
        var remaining = max - text;
        $('#description_count').html(remaining);

        if (max < $('#description').val().length) {
          $("#description_error").html("Maximun letter 995").show().fadeOut("slow");
          return false;
        }
      });

      $("#title").keyup(function(e) {
        $("#title").prop('maxlength', '50');
        var max = 50;
        var text = $('#title').val().length;
        var remaining = max - text;
        $('#title_count').html(remaining);

        if (max < $('#title').val().length) {
          $("#title_error").html("Maximun letter 50").show().fadeOut("slow");
          return false;
        }
      });
      
    });
  $("#print").click(function(e) {
      e.preventDefault();
      $("#sparePartModal").modal('hide');
      $('#myForm').submit();
    });
  $("#print_invoice").click(function(e) {
      $("#sparePartModal").modal('hide');
    });
</script>
@endpush
@endsection
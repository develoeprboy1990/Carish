@extends('layouts.app')
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

  .uploadBtn:hover {
    cursor: pointer;
  }
  .delete_photo{
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
        <h2 class="border-bottom mx-md-n4 mx-n3 pb-3 px-md-4 px-3 mb-sm-5 mb-4 themecolor">{{__('common.update_an_accessory')}}</h2>
        <form action="{{url('user/update-part-ad/'.@$sparePart->id)}}" method="post" id="myForm" class="form-horizontal" enctype="multipart/form-data" data-parsley-validate>
          {{csrf_field()}}
          <!-- Vehicle Information section starts here -->
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
                      <input type="text" name="title" class="form-control" placeholder="{{$sparePart->get_sp_ad_title($sparePart->id,$activeLanguage['id'])}}" data-parsley-error-message="Please select Product Name" data-parsley-required="true" data-parsley-trigger="change" value="{{$sparePart->get_sp_ad_title($sparePart->id,$activeLanguage['id'])}}" id="title">
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
                      <input type="text" name="product_code" class="form-control" placeholder="{{__('common.product_code')}}" value="{{@$sparePart->product_code}}">
                    </div>
                  </div>


                  <div class="align-items-center form-group mb-sm-4 mb-3 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mb-1 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.category')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">
                      <input type="text" id="categories" class="form-control" placeholder="{{__('common.category')}}/{{__('common.sub_category')}}" data-toggle="modal" data-target="#category-subcategory" value="{{$sparePart->get_parent_category($sparePart->parent_id,$activeLanguage['id']).'/'.@$sparePart->get_parent_category($sparePart->category_id,$activeLanguage['id'])}}" disabled="true">
                      <!-- <input type="text" id="categories" placeholder="Category/SubCategory" class="form-control" data-toggle="modal" data-target="#categoriesModal" data-parsley-error-message="Please select Category" data-parsley-required="true" data-parsley-trigger="change"> -->
                      <input type="hidden" name="sparepart_id" value="{{$id}}">
                      <input type="hidden" name="freeAd" value="">
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
                                  @if(@$sparePart->parent_id == $category->id)
                                  @php $class = 'active list-active'; @endphp
                                  @else
                                  @php
                                  $class = '';
                                  @endphp

                                  @endif
                                  <li onclick="getSubCategory(this)" id="sub_cat_{{$category->id}}" class="{{@$class}}" data-title="{{$category->title}}" data-id="{{$category->id}}"><a href="javascript:void(0)" class="align-items-center d-flex justify-content-between">{{$category->title}}
                                      <em class="fa fa-angle-right"></em></a></li>
                                  @endforeach
                                </ul>
                              </div>


                            </div>
                            <div class="col-md-6 col-sm-12 car-info-list-col version-list-col" id="sub-categories" style="display: block">
                              <h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> {{__('common.sub_category')}}</h6>
                              <div class="post-modal-list">
                                <ul class="list-unstyled version-listings" id="sub_category_list_2">
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="mb-2 mt-4 post-modal-btn text-center">
                            <a href="#" class="btn  themebtn1" data-dismiss="modal">{{__('ads.done')}}</a>
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
                            <ul id="sub_category_list">

                            </ul>
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
                        <option value="New" @if(@$sparePart->condition == 'New') {{ 'selected' }} @endif>{{__('common.new')}}</option>
                        <option value="Used" @if(@$sparePart->condition == 'Used') {{ 'selected' }} @endif>{{__('common.used')}}</option>

                      </select>
                    </div>
                  </div>

                  <div class="form-group mb-4 row">
                    <div class="col-lg-6 col-md-4 col-sm-3 mt-sm-1 pt-sm-2 text-sm-right">
                      <label class="mb-0 text-capitalize">{{__('common.price')}} (€)<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-sm-7">

                      <input class="form-control" type="text" placeholder="{{__('common.price')}}" name="price" data-parsley-error-message="Please Enter valid price" data-parsley-required="true" data-parsley-trigger="change" value="{{@$sparePart->price}}">


                      <div class="pricecheckboxes mt-3">
                        <div class="custom-control custom-checkbox mt-2">
                          <input type="checkbox" class="custom-control-input" {{ ($sparePart->vat != '0')? "checked='true'":" " }} id="pricecheck1" name="vat">
                          <label class="custom-control-label" for="pricecheck1">{{__('common.incl_20_vat')}}</label>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                          <input type="checkbox" class="custom-control-input" {{ ($sparePart->neg != '0')? "checked='true'":" " }} id="pricecheck2" name="neg">
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
                  <!-- <textarea name="add-description" class="form-control" rows="6" placeholder="Describe Your Product"></textarea> -->
                  <p id="description_error" class="m-0"></p>
                  <textarea id="description" class="form-control" placeholder="{{__('spareparts.describe_your_product')}}" rows="6" name="description" data-parsley-error-message="Please Provide Description" data-parsley-required="true" data-parsley-trigger="change">{{@$sparePart->sp_ads_description[0]->description}}</textarea>

                  <div class="about-message-field mt-1">
                    <span class="font-weight-semibold">{{__('spareparts.remaining_characters')}} <span id="description_count">995</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Vehicle Information section ends here -->

          <!-- Additional Information section starts here -->
          <div class="post-an-ad-sects mt-sm-5 mt-4 pt-sm-0 pt-2 addInformation"  style="display: none">
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
                      <option value="{{$make->id}}" @if(@$sparePart->make_id==$make->id) {{ 'selected' }} @endif>{{$make->title}}</option>
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
                          <input type="text" value="{{@$sparePart->f2_liter}}" class="form-control" name="f2_liter" id="f2_liter" placeholder="1.3" >
                      </div>
                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f2" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.kw')}}</label>
                      </div>

                      <div class="col-md-6 col-lg-5 col-sm-7">
                          <input type="text" value="{{@$sparePart->f2_kw}}" class="form-control" name="f2_kw" id="f2_kw" placeholder="78">
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
                            <option value="{{$brand->id}}" @if(@$sparePart->brand==$brand->id) {{ 'selected' }} @endif>{{$brand->title}}</option>
                          @endforeach
                      </select>
                    </div>
                </div>


                <div class="align-items-center form-group mb-sm-4 mb-3 row num_of_channel " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.num_of_channel')}}</label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->num_of_channel}}" class="form-control" name="num_of_channel" id="num_of_channel"  placeholder="{{__('common.num_of_channel')}}" >
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row size " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.size')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->size}}" class="form-control" name="size" id="size" placeholder="{{__('common.size')}}" required>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row screen_size " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.screen_size')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->screen_size}}" class="form-control" name="screen_size" id="screen_size" value="" required>
                    </div>
                </div>
                
                <div class="align-items-center form-group mb-sm-4 mb-3 row size_inch " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.size_inch')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->size_inch}}" class="form-control" name="size_inch" id="size_inch" placeholder="{{__('common.size_inch')}}" required>
                    </div>
                </div>
                
                <!-- f3 started -->
                <div class="align-items-center form-group mb-sm-4 mb-3 row f3" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.manufacturer_tyre')}}</label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="f3_tyre_manufacturer" id="f3_tyre_manufacturer" class="form-control">
                  <option value="" >{{__('ads.select_one')}}</option>
                      @foreach($tyre_manufacturers as $tyre)
                      <option value="{{$tyre->id}}" @if($sparePart->f3_tyre_manufacturer == $tyre->id) {{ 'selected' }} @endif>{{$tyre->title}}</option>
                      @endforeach
                  </select>
                      </div>
                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f3 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.size')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->f3_size}}" class="form-control" name="f3_size" id="f3_size" value="" placeholder="175/65/R14" required>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f3 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.type')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">

                      <input type="checkbox" name="f3_type[]" {{ in_array("summer", $f3_types) ? "checked" : "" }} value="summer" required> {{__('common.summer')}} <br>

                      <input type="checkbox" name="f3_type[]" {{ in_array("winter", $f3_types) ? "checked" : "" }} value="winter" required> {{__('common.winter')}} <br>

                      <input type="checkbox" name="f3_type[]" {{ in_array("all_season", $f3_types) ? "checked" : "" }} value="all_season" required> {{__('common.all_season')}} <br>

                      <input type="checkbox" name="f3_type[]" {{ in_array("studded", $f3_types) ? "checked" : "" }} value="studded" required> {{__('common.studded')}} <br> 

                      <input type="checkbox" name="f3_type[]" {{ in_array("offroad", $f3_types) ? "checked" : "" }} value="offroad" required> {{__('common.offroad')}} <br>

                      <input type="checkbox" name="f3_type[]" {{ in_array("racing", $f3_types) ? "checked" : "" }} value="racing" required> {{__('common.racing')}} <br>
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
                      <option value="1" @if($sparePart->f3_quantity=='1') {{ 'selected' }} @endif>1</option>
                      <option value="2" @if($sparePart->f3_quantity=='2') {{ 'selected' }} @endif>2</option>
                      <option value="3" @if($sparePart->f3_quantity=='3') {{ 'selected' }} @endif>3</option>
                      <option value="4" @if($sparePart->f3_quantity=='4') {{ 'selected' }} @endif>4</option>
                      <option value=">4" @if($sparePart->f3_quantity=='>4') {{ 'selected' }} @endif>>4</option>
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
                  <option value="" >{{__('ads.select_one')}}</option>
                      @foreach($wheel_manufacturers as $wheel)
                      <option value="{{$wheel->id}}" @if($sparePart->f4_wheel_manufacturer == $wheel->id) {{ 'selected' }} @endif>{{$wheel->title}}</option>
                      @endforeach
                  </select>
                      </div>
                  </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.size_inch')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->f4_size_inch}}" class="form-control" name="f4_size_inch" id="f4_size_inch" value="" placeholder="14*6.5" required>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.offset_mm')}}</label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->f4_offset_mm}}" class="form-control" name="f4_offset_mm" id="f4_offset_mm" value="" placeholder="39">
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.style')}}<sup class="text-danger">*</sup></label>
                    </div>
                    <div class="col-md-6 col-lg-5 col-sm-7">
                      <input type="radio" name="f4_style" value="steel" @if($sparePart->f4_style=='steel') {{ 'checked' }} @endif required>&nbsp;{{__('common.steel')}} &nbsp;&nbsp;
                      <input type="radio" name="f4_style" value="alloy" @if($sparePart->f4_style=='alloy') {{ 'checked' }} @endif required>&nbsp;{{__('common.alloy')}} &nbsp;&nbsp;
                      <input type="radio" name="f4_style" value="chrome" @if($sparePart->f4_style=='chrome') {{ 'checked' }} @endif required>&nbsp;{{__('common.chrome')}} &nbsp;&nbsp;
                      <label id="f4_style-error" class="error" for="f4_style"></label>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.num_of_holes')}}<sup class="text-danger">*</sup></label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->f4_num_of_holes}}" class="form-control" name="f4_num_of_holes" id="f4_num_of_holes" value="" placeholder="4" required>
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4 " style="display: none">
                    <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                        <label class="mb-0 text-capitalize">{{__('common.distance_between_holes')}}</label>
                    </div>

                    <div class="col-md-6 col-lg-5 col-sm-7">
                        <input type="text" value="{{@$sparePart->f4_distance_between_holes}}" class="form-control" name="f4_distance_between_holes" id="f4_distance_between_holes" value="" placeholder="100 ">
                    </div>
                </div>
                <div class="align-items-center form-group mb-sm-4 mb-3 row f4" style="display: none">
                      <div class="col-md-4 col-sm-3 mb-1 text-sm-right">
                          <label class="mb-0 text-capitalize">{{__('common.quantity')}}</label>
                      </div>
                      <div class="col-md-6 col-lg-5 col-sm-7">
                  <select name="f4_quantity" id="f4_quantity" class="form-control">
                  <option value="" selected>{{__('ads.select_one')}}</option>
                      <option value="1" @if($sparePart->f3_quantity=='1') {{ 'selected' }} @endif>1</option>
                      <option value="2" @if($sparePart->f3_quantity=='2') {{ 'selected' }} @endif>2</option>
                      <option value="3" @if($sparePart->f3_quantity=='3') {{ 'selected' }} @endif>3</option>
                      <option value="4" @if($sparePart->f3_quantity=='4') {{ 'selected' }} @endif>4</option>
                      <option value=">4" @if($sparePart->f3_quantity=='>4') {{ 'selected' }} @endif>>4</option>
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
                @if($sparepartImages)
                @foreach($sparepartImages as $img)
                <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                  <figure class="mb-0 position-relative">
                    <img src="{{asset('public/uploads/ad_pictures/spare-parts-ad/'.@$id.'/'.@$img->img)}}" class="img-fluid" alt="carish used cars for sale in estonia">
                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">
                      <span data-id="{{$img->id}}" class="delete_photo bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1  text-white d-inline-block mt-2">REMOVE</span>
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
                    <select name="poster_city" disabled="true" placeholder="Choose one City" class="form-control select2-field">
                      <option value="" disabled selected>Choose City</option>
                      @foreach($cities as $city)
                      <option value="{{$city->id}}" @if(@$customer->citiy_id == $city->id) {{ 'selected' }} @endif>{{$city->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Contact Information section ends here -->

          <div class="border-top mx-n4 pt-4 pt-sm-5 px-4 mt-sm-5 mt-4 text-center">
            <input type="submit" class="btn pb-3 pl-4 post-ad-submit pr-4 pt-3  themebtn1" value="{{__('ads.submit_and_continue')}}">
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewPhotos" tabindex="-1" role="dialog" aria-labelledby="viewPhotosModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Spare Part Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          @if(@$sparepartImages != null)
          @foreach(@$sparepartImages as $img)
          <div class="col-lg-4" id="image_row_{{$img->id}}">
            <div style="position: relative;">
              <img src="{{asset('public/uploads/ad_pictures/spare-parts-ad/'.@$id.'/'.@$img->img)}}" width="100%" height="150px;" style="border:2px dotted skyblue;" class="mb-4">
              <i class="fa fa-times delete_photo" style="position: absolute;right: -4px;top:-6px;color: red;font-weight: normal;font-size: 16px;" data-id="{{@$img->id}}"></i>
            </div>
          </div>
          @endforeach
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
<!-- Loader Modal -->
@push('scripts')
{{-- UploadHBR --}}
<script src="{{ asset('public/js/uploadHBR.min.js') }}" ></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script>
  $('.uploadBtn').click(function() {
    $('#new_0').trigger('click');
    // $('#prev_0').append('<p style="position:absolute;top:-20px;">Hello </p>');
    setTimeout(function() {
      $('#uploads').removeClass('d-none');
      $('.main_cover_photo').removeClass('d-none');
    }, 1000);
  });

  $(document).ready(function() {
    addInformation("{{$sparePart->category->filter}}");
    $("#myForm").validate({        rules: {
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
          fuel_average: {
            required: true
          },
          price: {
            required: true
          },
          description: {
            required: true
          },
          engine_capacity: {
            required: true
          },
          engine_power: {
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
                window.location = "{{route('my-spear-parts-ads')}}?status=0";
              }
            }).fail(function(jqXHR, textStatus, errorThrown) {
              $("#overlay").fadeOut(100);
              if (jqXHR.status === 422) {
                var errors = $.parseJSON(jqXHR.responseText);
                printErrorMsg(errors);
              }
            }); 

        }

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

    var images_exist = "{{$images_count}}";
    var remaining_images = 8 - images_exist;
    // alert(images_exist);
    $('input').attr('autocomplete', 'nope');

    var val = "{{@$sparePart->parent_id}}";

    $('#sub_cat_' + val).trigger('click');
    $('.car-list-active').removeClass('car-list-active');
    $('.version-list-col').addClass('car-list-active');

    uploadHBR.init({
      "target": "#uploads",
      "max": remaining_images,
        "textNew": "{{__('common.text_new')}}",
        "textTitle": "{{__('common.text_title')}}",
        "textTitleRemove": "{{__('common.text_title_remove')}}",
        "mimes": ["image/jpeg", "image/png","image/gif"],
        "showExtensionError":true,
        "messageSelector":"print-error-msg",
        "errorMessage":"{{__('common.invalid_files')}}",
        "errorMessages":'{{ __("ads.too_big_images") }}'
    });

    $('.delete_photo').on('click', function() {
      var id = $(this).data('id');  
            $.ajax({
              method: "get",
              data: 'id=' + id,
              url: "{{ route('remove-sparepart-image') }}",
              beforeSend: function() {
                $('#overlay').modal({
                  backdrop: 'static',
                  keyboard: false
                });
                $("#overlay").modal('show');
              },
              success: function(data) {
                if (data.success == true) {
                  $('#image_row_' + id).remove();
                  $("#overlay").modal('hide'); 
                  location.reload();

                }

              }
            });
          });

  });

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

  function getSentence(e) {
    var sentence = $(e).data('sentence');
    var old_sentense = $('#description').val();
    var new_sentense = old_sentense + sentence;
    $('#description').val(new_sentense);
    $(e).hide();
  }

  function getSubCategory(e) {
    // alert('here');
    var cat_id = $(e).data('id');
    var cat_title = $(e).data('title');
    var sub_id = "{{@$sparePart->category_id}}";
    // alert(cat_id);
    $('#category_id').val(cat_id);
    $('#category_title').val(cat_title);

    // alert(cat_title);
    // $('#sub-categories').removeClass('d-none');

    $.ajax({
      url: "{{url('user/get-spearpart-subcategories')}}/" + cat_id,
      method: "get",
      data: {
        sub_id: sub_id
      },
      success: function(data) {
        // console.log(data);
        $('#sub_category_list').html(data);
        $('#sub_category_list_2').html(data);
      }
    });

  }
  
  function addInformation(filter) {
   
      $('.f2').hide();
      $('.f3').hide();
      $('.f4').hide();
      $('.f1').show();
      $('.brand').hide();
      $('.num_of_channel').hide();
      $('.size').hide();
      $('.screen_size').hide();
      $('.size_inch').hide();


      var result = filter.split('_');

      if(result[0] == 'f1')
      {
        loadModels("{{@$sparePart->make_id}}");
        $('.f2').hide();
        $('.f3').hide();
        $('.f4').hide();
        $('.f1').show();
        $('#models_listing').val("{{@$sparePart->model_id}}").change();

      }
      if(result[0] == 'f2')
      {
        loadModels("{{@$sparePart->make_id}}");
        $('.f1').hide();
        $('.f3').hide();
        $('.f4').hide();
        $('.f2').show();
        //$('#models_listing').val("{{@$sparePart->model_id}}").change();
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
      
      $('.addInformation').show();
    }

  function loadModels(id) {
    $.ajax({
    url: "{{url('get-sp-models')}}/" + id,
    method: "get",
    beforeSend: function() {
        //$('#models_listing').html('<div class="loader loader_version"></div>');
    },
    success: function(data) {
        $('#models_listing').html(data);
    }
    }).done(function() {
        $("#models_listing").val("{{@$sparePart->model_id}}").change();
    });
  }

  function selectCategory(e) {
   // var sub_category_id = $(e).('id');
    $('#sub_category').val(sub_category_id);
    var display_value = $('#category_title').val() + '/' + $(e).data('title');
    $('#categories').val(display_value);
    $('#categoriesModal').modal('hide');
    $('#category-subcategory').modal('hide');
  }

  $(function() {

    $("#description").prop('maxlength', '995');
    var max = 995;
    var text = $('#description').val().length;
    var remaining = max - text;
    $('#description_count').html(remaining);

    $("#title").prop('maxlength', '50');
    var max = 50;
    var text = $('#title').val().length;
    var remaining = max - text;
    $('#title_count').html(remaining);

    $('.gobackIcon').on('click', function() {
      $(this).parents('.car-info-list-col').hide();
      $(this).parents('.car-info-list-col').prev('.car-info-list-col').show().removeClass('prev-list-active');
    });

    $('.car-info-list-col:not(:last-child) li a').on('click', function() {
      $(this).parents('.car-info-list-col').removeClass('car-list-active').next('.car-info-list-col').addClass('car-list-active').show().prev('.car-info-list-col').addClass('prev-list-active');
      $(this).parents('li').addClass('list-active').siblings('li').removeClass('list-active');
      $(this).parents('.car-info-list-col').siblings('.car-info-list-col').find('li').removeClass('list-active');
    });

    $(document).on('click', '.car-info-list-col ul.version-listings li', function() {
      // alert('finaaly');
      $('ul.version-listings li').removeClass('list-active');
      $(this).addClass(' list-active');
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
</script>
@endpush
@endsection
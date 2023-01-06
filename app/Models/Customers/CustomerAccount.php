<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Lang;

class CustomerAccount extends Model
{
     protected $table = 'customer_accounts';

     public function car_ad(){
        return $this->belongsTo('App\Ad','ad_id','id');
    }

    public function sparepart_ad(){
        return $this->belongsTo('App\SparePartAd','ad_id','id');
    }

    public function offerservice(){
        return $this->belongsTo('App\Models\Services','ad_id','id');
    }

    public function get_customer()
    {
    	return $this->belongsTo('App\Models\Customers\Customer','customer_id','id');
    }

    public function get_type($type){
        if($type == 'car_ad')
        {
            return 'Car Ad';
        }
        else if($type == 'car')
        {
            return 'Car Feature';
        }
        else if($type == 'sparepart_ad')
        {
            return 'Sparepart Ad';
        }
        else if($type == 'sparepart')
        {
            return 'Sparepart Feature';
        }
        else if($type == 'offerservice_ad')
        {
            return 'Offerservice Ad';
        }
        else if($type == 'offerservice')
        {
            return 'Offerservice Feature';
        }
        else if($type == 'balance_added')
        {
            return 'Balance Added';
        }else{
             return $type;
        }
    }

    public function get_detail($id){
        $invoice = CustomerAccount::where('id',$id)->first();
        if($invoice->type == 'car' && $invoice->credit !== null)
        {
            $html = '<span>Amount to be paid for featuring ';
            $html .='<a target="" href="'.url('admin/ad-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .='</a> Car</span>';

        }
        elseif($invoice->type == 'car' && $invoice->debit !== null)
        {
            $html = '<span>Amount paid for featuring ';
            $html .='<a target="" href="'.url('admin/ad-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .='</a> Car</span>';
        }
        elseif($invoice->type == 'car_ad')
        {
            $html = '<span>Amount to be paid for post an Ad ';
            $html .='<a target="" href="'.url('admin/ad-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .=' </a> Car</span>';
        }
        
        elseif($invoice->type == 'sparepart' && $invoice->credit !== null)
        {
            $html = '<span>Amount to be paid for featuring ';
            $html .='<a target="" href="'.url('admin/sp-part-ad-detail/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->sparepart_ad->title;
            $html .='</a> Spare Part</span>';

        }
        elseif($invoice->type == 'sparepart' && $invoice->debit !== null)
        {
            $html = '<span>Amount paid for featuring ';
            $html .='<a target="" href="'.url('admin/sp-part-ad-detail/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->sparepart_ad->title;
            $html .='</a> Spare Part</span>';
        }
        elseif($invoice->type == 'sparepart_ad')
        {
            $html = '<span>Amount to be paid for post an accessory ';
            $html .='<a target="" href="'.url('admin/sp-part-ad-detail/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->sparepart_ad->title;
            $html .=' </a> Spare Part</span>';
        }

         elseif($invoice->type == 'offerservice' && $invoice->credit !== null)
        {
            $html = '<span>Amount to be paid for featuring ';
            $html .='<a target="" href="'.url('admin/service-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->offerservice->primary_service->title;
            $html .='</a> Service</span>';

        }
        elseif($invoice->type == 'offerservice' && $invoice->debit !== null)
        {
            $html = '<span>Amount paid for featuring ';
            $html .='<a target="" href="'.url('admin/service-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->offerservice->primary_service->title;
            $html .='</a> Service</span>';
        }
        elseif($invoice->type == 'offerservice_ad')
        {
            $html = '<span>Amount to be paid for post an service ';
            $html .='<a target="" href="'.url('admin/service-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->offerservice->primary_service->title;
            $html .=' </a> Service</span>';
        }
        elseif($invoice->type == 'balance_added' ){
            $html .=' <span>Balance Added</span>';
        }else{
            $html .='<span>'.$invoice->type.'</span>';
        }
        return $html;
        
    }

    public function get_front_type($type){        
        
        if($type == 'car_ad')
        {
            return Lang::get('common.car_ad');
        }
        else if($type == 'car')
        {
            return Lang::get('common.car_featured');
        }
        else if($type == 'sparepart_ad')
        {
            return Lang::get('common.sparepart_ad');
        }
        else if($type == 'sparepart')
        {
            return Lang::get('common.sparepart_featured');
        }
        else if($type == 'offerservice_ad')
        {
            return Lang::get('common.offerservice_ad');
        }
        else if($type == 'offerservice')
        {
            return Lang::get('common.offerservice_featured');
        }
        else if($type == 'balance_added')
        {
            return Lang::get('common.balance_added');
        }else{
             return $type;
        }
    }

    
    public function get_front_detail($id){
        $invoice = CustomerAccount::where('id',$id)->first();

        if($invoice->type == 'car' && $invoice->credit !== null)
        {
            $html = '<span>'.Lang::get('common.amount_to_be_paid_for_featuring');
            $html .=' ';
            $html .='<a target="" href="'.url('car-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .='</a> '.Lang::get('common.car').'</span>';

        }
        elseif($invoice->type == 'car' && $invoice->debit !== null)
        {
            $html = '<span>'.Lang::get('common.amount_paid_for_featuring');
            $html .=' ';
            $html .='<a target="" href="'.url('car-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .='</a> '.Lang::get('common.car').'</span>';
        }
        elseif($invoice->type == 'car_ad')
        {
            $html = '<span>'.Lang::get('common.amount_to_be_paid_for_post_an_ad');
            $html .=' ';
            $html .='<a target="" href="'.url('car-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .=' </a> '.Lang::get('common.car').'</span>';
        }
        
        elseif($invoice->type == 'sparepart' && $invoice->credit !== null)
        {
            $html = '<span>'.Lang::get('common.amount_to_be_paid_for_featuring');
            $html .=' ';
            $html .='<a target="" href="'.url('spare-parts-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->sparepart_ad->title;
            $html .='</a> '.Lang::get('common.spare_part').'</span>';

        }
        elseif($invoice->type == 'sparepart' && $invoice->debit !== null)
        {
            $html = '<span>'.Lang::get('common.amount_paid_for_featuring');
            $html .=' ';
            $html .='<a target="" href="'.url('spare-parts-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->sparepart_ad->title;
            $html .='</a> '.Lang::get('common.spare_part').'</span>';
        }
        elseif($invoice->type == 'sparepart_ad')
        {
            $html = '<span>'.Lang::get('common.amount_to_be_paid_for_post_an_accessory');
            $html .=' ';
            $html .='<a target="" href="'.url('spare-parts-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->sparepart_ad->title;
            $html .=' </a> '.Lang::get('common.spare_part').'</span>';
        }

         elseif($invoice->type == 'offerservice' && $invoice->credit !== null)
        {
            $html = '<span>'.Lang::get('common.amount_to_be_paid_for_featuring');
            $html .=' ';
            $html .='<a target="" href="'.url('service-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->offerservice->primary_service->title;
            $html .='</a> '.Lang::get('common.service').'</span>';

        }
        elseif($invoice->type == 'offerservice' && $invoice->debit !== null)
        {
            $html = '<span>'.Lang::get('common.amount_paid_for_featuring');
            $html .=' ';
            $html .='<a target="" href="'.url('service-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->offerservice->primary_service->title;
            $html .='</a> '.Lang::get('common.service').'</span>';
        }
        elseif($invoice->type == 'offerservice_ad')
        {
            $html = '<span>'.Lang::get('common.amount_to_be_paid_for_post_an_service');
            $html .=' ';
            $html .='<a target="" href="'.url('service-details/'.$invoice->ad_id).'" style="color: #007bff;">';
            $html .= $invoice->offerservice->primary_service->title;
            $html .=' </a> '.Lang::get('common.service').'</span>';
        }

        elseif($invoice->type == 'balance_added' ){
            $html .=' <span>'.Lang::get('common.balance_added').'</span>';
        }else{
            $html .='<span>'.$invoice->type.'</span>';
        }
        return $html;
        
    }


    public function get_front_invoice_detail($id){
        $invoice = CustomerAccount::where('id',$id)->first();

        if($invoice->type == 'car' && $invoice->credit !== null)
        {
            $html = Lang::get('common.amount_to_be_paid_for_featuring');
            $html .=' ';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .=' '.Lang::get('common.car');

        }
        elseif($invoice->type == 'car' && $invoice->debit !== null)
        {
            $html = Lang::get('common.amount_paid_for_featuring');
            $html .=' ';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .=' '.Lang::get('common.car');
        }
        elseif($invoice->type == 'car_ad')
        {
            $html = Lang::get('common.amount_to_be_paid_for_post_an_ad');
            $html .=' ';
            $html .= $invoice->car_ad->maker->title.' '.$invoice->car_ad->model->name.' '.$invoice->car_ad->versions->name.' '.$invoice->car_ad->year;
            $html .=' '.Lang::get('common.car');
        }
        
        elseif($invoice->type == 'sparepart' && $invoice->credit !== null)
        {
            $html = Lang::get('common.amount_to_be_paid_for_featuring');
            $html .=' ';
            $html .= $invoice->sparepart_ad->title;
            $html .=' '.Lang::get('common.spare_part');

        }
        elseif($invoice->type == 'sparepart' && $invoice->debit !== null)
        {
            $html = Lang::get('common.amount_paid_for_featuring');
            $html .=' ';
            $html .= $invoice->sparepart_ad->title;
            $html .=' '.Lang::get('common.spare_part');
        }
        elseif($invoice->type == 'sparepart_ad')
        {
            $html = Lang::get('common.amount_to_be_paid_for_post_an_accessory');
            $html .=' ';
            $html .= $invoice->sparepart_ad->title;
            $html .=' '.Lang::get('common.spare_part');
        }

         elseif($invoice->type == 'offerservice' && $invoice->credit !== null)
        {
            $html = Lang::get('common.amount_to_be_paid_for_featuring');
            $html .=' ';
            $html .= $invoice->offerservice->primary_service->title;
            $html .=' '.Lang::get('common.service');

        }
        elseif($invoice->type == 'offerservice' && $invoice->debit !== null)
        {
            $html = Lang::get('common.amount_paid_for_featuring');
            $html .=' ';
            $html .= $invoice->offerservice->primary_service->title;
            $html .=' '.Lang::get('common.service');
        }
        elseif($invoice->type == 'offerservice_ad')
        {
            $html = Lang::get('common.amount_to_be_paid_for_post_an_service');
            $html .=' ';
            $html .= $invoice->offerservice->primary_service->title;
            $html .=' '.Lang::get('common.service');
        }
        
        elseif($invoice->type == 'balance_added' ){
            $html =Lang::get('common.balance_added');
        }else{
            $html .=$invoice->type;
        }
        return $html;
        
    }
}

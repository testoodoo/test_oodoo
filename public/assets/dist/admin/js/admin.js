$(document).ready(function(){
    


    //alert('das')
    $('.account_history_button').click(function(){
        var account_id = $('.account_history_input').val();
        if (account_id.length == 0){
            alert('Please Give the Account ID');
        } else {
            window.location.href = "/account-history?account_id="+account_id;   
        }
    });

    //payments filter
    $('select[name="status_filter"]').change(function(){
        var status = $(this).val();
        window.location.href = "/admin/payments/transactions?status=" + status;
    });

    //bills filter
    $('select[name="bills_status_filter"]').change(function(){
        var status = $(this).val();
        window.location.href = "/admin/bills?status=" + status;
    });

    $('.page_no_submit').click(function(){
        var page = $('input[name="page_no"]').val();
        if (page.length == 0){
            alert('Please Give the input');
        } else {
            url = window.location.href;
            if(url.indexOf('?') === -1){
              url = url + "?page=" + page;
            } else {
                if(url.indexOf('&page=') === -1){
                    url = url + "&page=" + page;    
                } else {
                    var n = url.indexOf("&page=");
                    var rep = n + 6;
                    url = url.slice(0,rep);
                    var url_split = url.split('');
                    url_split.splice.apply(url_split,[rep,1].concat(page.split('')));
                    url = url_split.join('');
                }
                
            }
            window.location.href = url;
        }
    });

    /*$('select[name="no_of_records_filter"]').change(function(){
        var status = $(this).val();
        window.location.href = "/payments?status=" + status;
    });*/

    $('.notify_user_for_bill').click(function(){
        var bill_no = $(this).attr('data-bill-no');
        $(this).css('color','orange');
        $.ajax({
            url : '/admin/bills/notify_user_for_bill',
            type : 'POST',
            data : {bill_no : bill_no},
            success : function(data){
                if (data['status'] == "success") {
                    $(this).css('color','green');
                    alert("Sent Succesfully!!");
                } else {
                    $(this).css('color','red');
                    alert("Message Sending Failed!!");
                }
                
            }
        })
    });

    //bill edit page
    $('.bill_status_change').click(function(){
        var amount_paid = parseInt($('.bill_amount_paid').val());   
        var status = $(this).val();
        if ((status == "partially_paid") || (status == "paid")){
            if (amount_paid < 0) {
                alert("Check the Amout Paid first and then change the status");
                $(this).val("not_paid");
            }
        }
    });

    $('input.fetch_account_id').click(function(){
        var account_id = $('.account_id').val();
        if(account_id.length != 0) {
            $.ajax({
                url :'fetch-account-id',
                type : 'get',
                data : { account_id : account_id },
                            success : function(data) {
                                if (data["found"] == "false") {
                                    alert('Account Id not Found');
                                } else {
                                    $('.old_plan_code').val(data['old_plan_code']);
                                    $('.old_plan').val(data['old_plan']);
                                    $('.bill_balance').val(data['bill_balance']);
                                    $('.start_date').val(data['start_date']);
                                    $('.gb_percent').val(data['gb_percent']);
                                    $('.prorate_balance').val(data['prorate_balance']);
                                    $('.used_days').val(data['used_days']);
                                    }
                            }
                        });
        }
    });
                

                        


    $('input.fetch_plan_det').click(function(){
        var account_id = $('.account_id').val();
        if(account_id.length != 0) {
            $.ajax({
                url : 'fetch-plan-details',
                type : 'get',
                data : { account_id : account_id },
                success : function(data){
                    if(data['found'] == "false") {
                        alert('Invalid Account ID. Data not found');
                        setEmpty();
                    } else {
                        $('.plan_name').val(data['plan']);
                        $('.bill_start_date').val(data['plan_start_date']);
                        $('.bill_end_date').val(data['plan_end_date']);
                        $('.bill_due_date').val(data['plan_start_date']);
                        $('#bill_date').val(data['plan_start_date']);

                        $('.for_month').val(data['for_month']);


                        var plan_code = data['plan_code'];
                        var for_month = data['for_month'];

                        $.ajax({
                            url : 'fetch-plan-cost-details',
                            type : 'get',
                            data : {plan_code : plan_code},

                            success : function(data) {
                                if (data["found"] == "false") {
                                    alert('Plan not Found');
                                    setEmpty();
                                } else {
                                    $('.device_cost').val(data['device_cost']);
                                    $('.one_time_charges').val(data['onetime_charges']);
                                    $('#current_rental').val(data['current_rental']);

                                    setMoreValues();
                                    
                                }
                            }
                        })
                           

                        $.ajax({
                            url : '/admin/adjustments/fetch-adjustment-cost-details',
                            type : 'get',
                            data : {'for_month':for_month,'account_id':account_id},
                            
                            success : function(data) {
                                if (data["found"] == "false") {
                                } else {
                                    $('#adjustments').val(data['adjustment']);

                                    
                                }
                            }
                        })
                         $.ajax({
                            url : '/admin/devicecost/fetch-device-cost-details',
                            type : 'get',
                            data : {'for_month':for_month,'account_id':account_id},

                            success : function(data) {
                                if (data["found"] == "false") {
                                } else {
                                    $('#device_cost').val(data['devicecost']);
                                    
                                }
                            }
                        })
                                  $.ajax({
                            url : '/admin/discounts/fetch-discount-cost-details',
                            type : 'get',
                            data :  {'for_month':for_month,'account_id':account_id},

                            success : function(data) {
                                if (data["found"] == "false") {
                                } else {
                                    $('#discount').val(data['discount']);
                                    
                                }
                            }
                        })
                                       $.ajax({
                            url : '/admin/othercharges/fetch-othercharge-cost-details',
                            type : 'get',
                            data : {'for_month':for_month,'account_id':account_id},

                            success : function(data) {
                                if (data["found"] == "false") {
                                } else {
                                    $('#other_charges').val(data['othercharges']);
                                    
                                }
                            }
                        })
                            
                    }
                }
            });
        } else {
            alert('Please Enter the Account ID');   
        }
    });

    $('#bills_form').on('keyup keypress blur change', function() {

	setMoreValues();
        
    });

    $('input#bill-amount-paid-field').on('keyup keypress blur change', function(){

        var amount_paid = parseInt($(this).val());

        var amount_before_due_date = parseInt($('#amount_before_due_date').val());

        if (amount_paid > 0) {
            if (amount_before_due_date <= amount_paid) {
                $('select#bill-status-field').val("paid");
            } else if (amount_before_due_date > amount_paid) {
                $('select#bill-status-field').val("partially_paid");
            }    
        } else {
            $('select#bill-status-field').val("not_paid");
        }

    });
});

function setEmpty(){
    $('.plan_name').val('');
    $('.bill_start_date').val('');
    $('.bill_end_date').val('');
    $('.bill_due_date').val('');
    $('.device_cost').val('');
    $('.discount').val('');
    $('.one_time_charges').val('');
    $('#bill_date').val('');
    $('#current_rental').val('');
    $('#sub_total').val('');
    $('#total_charges').val('');
    $('#service_tax').val('');
}


function setMoreValues(){

    var current_rental = $('#current_rental').val();
    var other_charges = $('#other_charges').val();
    var device_cost = $('.device_cost').val();
    var discount = parseInt($('#discount').val());
    var one_time_charges = $('.one_time_charges').val();
    var sub_total = parseInt(+current_rental + +other_charges + +device_cost + +one_time_charges - +discount);
//	alert(sub_total);
    $('#sub_total').val(sub_total);
    var tax =ServiceTaxFactor();
    var service_tax = Math.round(tax * sub_total);
    $('#service_tax').val(service_tax);

    var total_charges = parseInt(+sub_total + +service_tax);

    $('#total_charges').val(total_charges);

    var previous_balance = $('#previous_balance').val();
    var last_payment = $('#last_payment').val();
    var adjustments = $('#adjustments').val();

    if ((previous_balance.length != 0) && (last_payment.length != 0) && (adjustments.length != 0)){
        if(!isNaN(total_charges)) {
            //(Previous Bal - Last Payment) + (Total Charges - Adjustments)
            var calculated_charge = parseInt((+previous_balance - +last_payment) + (+total_charges - +adjustments));
            $('#amount_before_due_date').val(calculated_charge);
            $('#amount_after_due_date').val(calculated_charge);
        } 
    } else {
        $('#amount_before_due_date').val('');
        $('#amount_after_due_date').val('');
        alert('Please Fill these amounts (Previous Balance, Last Payment, Adjustments )');
    }
}



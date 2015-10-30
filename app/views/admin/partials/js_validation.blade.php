<script type="text/javascript">
$(document).ready(function() {

    $('.validate-form').validate();

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    $('.others_radio').click(function(){
        $('input[name="title"]').prop("checked",false);
        $('.others_input').toggle();
    });

    $('.title_radio').click(function(){
        $('.others_radio').prop("checked",false);
        $('.others_input').val("");
        $('.others_input').hide();
    });

    $('.select2').css('width','200px').select2({allowClear:true})

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });


    $('#registrationform').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: 'The title is required'
                    },
                   
                }
            },
            application_no: {
                validators: {
                    notEmpty: {
                        message: 'The Application number is required'
                    },
                   
                }
            },
            
            first_name: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The username can only consist of alphabetical and number'
                    },
                    different: {
                        field: 'password',
                        message: 'The username and password cannot be the same as each other'
                    }
                }
            },
            last_name: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 1,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The username can only consist of alphabetical and number'
                    },
                    different: {
                        field: 'password',
                        message: 'The username and password cannot be the same as each other'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The email address is not a valid'
                    }
                }
            },
            address1: {
                validators: {
                    notEmpty: {
                        message: 'The Flat / Door No is required'
                    },
                   
                }
            },
            address2: {
                validators: {
                    notEmpty: {
                        message: 'The Apartment / Building name is required'
                    },
                   
                }
            },
            address3: {
                validators: {
                    notEmpty: {
                        message: 'The Street Name  is required'
                    },
                   
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'The state is required'
                    },
                   
                }
            },
            pincode: {
                validators: {
                    notEmpty: {
                        message: 'The pincode is required'
                    },
                   
                }
            },

          city: {
                validators: {
                    notEmpty: {
                        message: 'The city is required'
                    },
                   
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'The phone is required'
                    },
                     stringLength: {
                        min: 10,
                        message: 'Mobile number minimum 10 required'
                    }
                     
                   
                }
            },
            dob:{
                validators: {
                    notEmpty: {
                        message: 'The dob is required'
                    },
                   
                }
            },
              type: {
                validators: {
                    notEmpty: {
                        message: 'The plan is required'
                    },
                   
                }
            },
            sales_employee_id: {
                validators: {
                    notEmpty: {
                        message: 'The sales employee id is required'
                    },
                   
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'The gender is required'
                    }
                }
            }
        }
    });
});
</script>
 <script type="text/javascript">
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>

var textR = new RegExp(/^[A-Za-z0-9\s-\/,]+$/i); //regular text (could be configured to reject numbers etc.)
	//old ^[a-z0-9\.\-\_]+@([a-z\-\.])+(\.[a-z]{2,})$
var emailR = new RegExp(/^[a-z0-9\.\-\_#\$!%&\'\*\+\=\?^`{}~]+@([a-z\-\.])*(\.[a-z]{2,})$/i); //email
var phoneR = new RegExp(/^([0-9][-\. ]?)?([0-9]{3}[-\. ]?){1,2}[0-9]{4}$/i); //phone number, accepts: 1 800 123 4567, 1-800-123-4567, 1.800.123.4567 or 18001234567
var numR = new RegExp(/[0-9]+/i);
var formIsValid = true;

//When the JS function is inside the jQuery namespace, it cannot be executed from any html event. 
function validate(){
	console.log('Validating');
	formIsValid = true;

	jQuery('#reserveRoomForm input[required]').each(function() {
		validateInput(this);	
	});
        jQuery('#reserveRoomForm input[name=eiAff]').each(function() {
		validateInput(this);	
	});
	jQuery('#reserveRoomForm textarea[required]').each(function() {
		validateInput(this);
	});
	var room = jQuery('#qRoom').val();
	var same = document.getElementById('kSame').checked;
	var rec = document.getElementById('eREvent').checked;
	
        if(room != 'Barnard'){
                jQuery('#techRoom input[type!=checkbox][name!=tAcc]').each(function() {
                        validateInput(this);
                });
                jQuery('#recDate .invalid').each(function() {validE(this);});
        }else{
                jQuery('#techRoom > input[type!=checkbox][name!=tAcc]').each(function() {
                        validateInput(this);
                });
        }
	
	if(rec){
		jQuery('#recDate input[type=text]').each(function() { validateInput(this); });
	}else{
		jQuery('#recDate input[type=text]').each(function() { validE(this); });
	}
	if(!same){
		jQuery('#pSame input[type!=checkbox][name!=pkTeleE]').each(function () { validateInput(this); 
		});
	}else{
		jQuery('#pSame .invalid').each(function() {validE(this);});
	}
	//Check times
	var resS = Number(jQuery('#rTimeSH').val())*60+Number(jQuery('#rTimeSM').val())+addPM('rTimeSA', 'rTimeSH');
	var resE = Number(jQuery('#rTimeEH').val())*60+Number(jQuery('#rTimeEM').val())+addPM('rTimeEA', 'rTimeEH');
	var evS = Number(jQuery('#eTimeSH').val())*60+Number(jQuery('#eTimeSM').val())+addPM('eTimeSA', 'eTimeSH');
	var evE = Number(jQuery('#eTimeEH').val())*60+Number(jQuery('#eTimeEM').val())+addPM('eTimeEA', 'eTimeEH');
        if(resS >= resE){
                formIsValid = false;
		jQuery('#times select').each(function() {invalidE(this) });
        }else{
                jQuery('#times .invalid').each(function() {validE(this) });
                if(!jQuery('#rSame').is(':checked')){
                 if(resS > evS || resE < evE){
                    formIsValid = false;
                    jQuery('#times select').each(function() {invalidE(this) });
                 }else{
                    jQuery('#times .invalid').each(function() {validE(this) });
                 }
        }
        }

	if(!formIsValid){
		jQuery('#invalidForm').show();
		window.location.hash = 'invalidForm';
		return false;
	}
	return true;
}
function dataValid(e, valid){
//	console.log(valid);
	if(valid){
		validE(e);
	}else{
		formIsValid = false;
		invalidE(e);
	}
}
function addPM(Pid, Hid){
        var ampm = document.getElementById(Pid).value;
        var hour = document.getElementById(Hid).value;
	if(ampm == 'pm' && hour != 12)
	    return 720;
        if(ampm == 'am' && hour == 12)
            return -720;
	return 0;
}

function validateInput(e){
	var valid = false;
	var elem = e;
	if(e.tagName == 'INPUT'){
		var type = e.getAttribute('type');
		if(type == 'text'){
                        if(jQuery(e).hasClass('skipVal')) valid = (e.value != '');
			else valid = textR.test(e.value);
		}else if(type == 'email'){
			valid = emailR.test(e.value);
		}else if(type == 'tel'){
			valid = phoneR.test(e.value);
		}else if(type == 'number'){
			valid = numR.test(e.value);
		}else if(type == 'radio'){
			var radios = document.getElementsByName(jQuery(e).attr('name'));
			for(var i=0; i<radios.length;i++){
				if(radios[i].checked){
					valid = true;
					break;
				}
				if(!valid){
					jQuery(e).siblings('.other').each(function() {if(jQuery.trim(jQuery(this).val()) != '') valid = true; });
				}
			}
			elem = e.parentNode;
		}
	}else if(e.tagName == 'TEXTAREA'){
		//valid = textR.test(e.value);
                valid = (e.value != '');
	}
	dataValid(elem, valid);
}

function invalidE(e){
	if(!jQuery(e).hasClass('invalid'))
		jQuery(e).addClass('invalid');
}

function validE(e){
	if(jQuery(e).hasClass('invalid'))
		jQuery(e).removeClass('invalid');
}
(function ($) {
$(document).ready(function() {
	
	
	$('#eDate').datepicker();	
	$('#eOther').change(function() {
		$('input[name="eiAff":checked]').each(function() { $(this).checked = false; });
	});
	$('#rSame').click(function() {
		$("#erSame").toggle();
	});
	$('#kSame').click(function() {
		$("#pSame").toggle();
	});
	$('#eREvent').click(function() {
		$("#recDate").toggle(this.checked);
	});
	$('#Soft').click(function() {
		$("#softExtra").toggle(this.checked);
	});
	$('#eOther').click(function() {
		$('input[type=radio][name="eiAff"]:checked').each(function() { $(this).removeAttr('checked'); });
	});
	
	$('#qRoom').change(function() {
		if(this.value == 'Autzen'){
			$('#autzen').show();
			$('#barnard').hide();
			$('#willEast').hide();
			$('#techRoom').show();
			$('#extraWillE').hide();
			$('#rAddL').show();
			$('#willWest').hide();
			$('#willWE').hide();
		}else if(this.value == 'Barnard'){
			$('#autzen').hide();
			$('#barnard').show();
			$('#willEast').hide();
			$('#techRoom').show();
			$('#extraWillE').hide();
			$('#rAddL').hide();
			$('#willWest').hide();
			$('#willWE').hide();
		}else if(this.value.indexOf('Willamette') !== -1){
			$('#autzen').hide();
			$('#barnard').hide();
			if(this.value == 'Willamette East'){
				$('#willEast').show();
				$('#willWest').hide();
				$('#willWE').hide();
			}else if(this.value == 'Willamette West'){
				$('#willEast').hide();
				$('#willWest').show();
				$('#willWE').hide();
			}else{
				$('#willEast').hide();
				$('#willWest').hide();
				$('#willWE').show();
			}
			$('#techRoom').show();
			$('#rAddL').show();
		}else{
			$('#autzen').hide();
			$('#barnard').hide();
			$('#willEast').hide();
			$('#techRoom').hide();
			$('#willWest').hide();
		}
	});
});
}(jQuery));
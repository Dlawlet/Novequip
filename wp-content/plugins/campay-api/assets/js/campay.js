function is_valid_number(number)
{
	
		//let ISD_CODES = [93, 355, 213, 1684, 376, 244, 1264, 672, 1268, 54, 374, 297, 61, 43, 994, 1242, 973, 880, 1246, 375, 32, 501, 229, 1441, 975, 591, 387, 267, 55, 246, 1284, 673, 359, 226, 257, 855, 237, 1, 238, 1345, 236, 235, 56, 86, 61, 61, 57, 269, 682, 506, 385, 53, 599, 357, 420, 243, 45, 253, 1767, 1809, 1829, 1849, 670, 593, 20, 503, 240, 291, 372, 251, 500, 298, 679, 358, 33, 689, 241, 220, 995, 49, 233, 350, 30, 299, 1473, 1671, 502, 441481, 224, 245, 592, 509, 504, 852, 36, 354, 91, 62, 98, 964, 353, 441624, 972, 39, 225, 1876, 81, 441534, 962, 7, 254, 686, 383, 965, 996, 856, 371, 961, 266, 231, 218, 423, 370, 352, 853, 389, 261, 265, 60, 960, 223, 356, 692, 222, 230, 262, 52, 691, 373, 377, 976, 382, 1664, 212, 258, 95, 264, 674, 977, 31, 599, 687, 64, 505, 227, 234, 683, 850, 1670, 47, 968, 92, 680, 970, 507, 675, 595, 51, 63, 64, 48, 351, 1787, 1939, 974, 242, 262, 40, 7, 250, 590, 290, 1869, 1758, 590, 508, 1784, 685, 378, 239, 966, 221, 381, 248, 232, 65, 1721, 421, 386, 677, 252, 27, 82, 211, 34, 94, 249, 597, 47, 268, 46, 41, 963, 886, 992, 255, 66, 228, 690, 676, 1868, 216, 90, 993, 1649, 688, 1340, 256, 380, 971, 44, 1, 598, 998, 678, 379, 58, 84, 681, 212, 967, 260, 263],
		let ISD_CODES = [67, 69, 65, 68],
		//extract numbers from string
		thenum = number.match(/[0-9]+/g).join(""),
		totalnums = thenum.length,
		last10Digits = parseInt(thenum) % 10000000000,
		ISDcode = thenum.substring(0, totalnums - 7);
		
		//console.log(thenum+" "+totalnums+" "+last10Digits+" "+ISDcode);
			
		//phone numbers are generally of 8 to 16 digits
		if (totalnums == 9) {
		if (ISDcode) {
			if (ISD_CODES.includes(parseInt(ISDcode))) {
			return true;
			} else {
			return false;
			}
		} else {
			return true;
		}

		}
	  
	
	
}

function validate_number(field)
{
	

	let number = field.value;
	if(number.length !=0)
	{

		if(is_valid_number(number.toString()))
		{
			
			jQuery("#place_order").removeAttr("disabled");
			jQuery("#campay-number-error").hide();
		}
		else
		{	
			jQuery("#campay-number-error").show();
			jQuery("#place_order").attr("disabled", "disabled");
		}	
				     		

	}
	
}


jQuery('body').on( 'checkout_error', function() {
    
    jQuery("#campay_modal_processing").hide();
    
});
/*

						function pay_card()
						{

								event.preventDefault();
								document.getElementById("campay_payment_option").value="card";
								document.getElementById("place_order").click();
								document.getElementById("place_order").click();
							
						}
*/
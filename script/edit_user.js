

// gender drop down dynamic functionality
gender_drop = document.getElementById("dropdownMenuButtonForGender");
gender_menu_items =document.querySelectorAll(".gender-dropdown-item");

gender_menu_items.forEach(element => {
	element.onclick = function () {
		gender_drop.innerText = element.innerText;
	}
});

// gender drop down dynamic functionality
usertype_drop = document.getElementById("dropdownMenuButtonForAccounts");
usertype_menu_items =document.querySelectorAll(".usertype-dropdown-item");
usertype_menu_items.forEach(element => {
	element.onclick = function () {
		usertype_drop.innerText = element.innerText;
	}
});

// save changes dynamic functionality
submit_button = document.getElementById("submit-button");
submit_button.onclick = function() {
	valid_weight = false;
	valid_height = false;
	valid_fname = false;
	valid_lname = false;
	valid_phone = false;
	is_coach = usertype_drop.innerText.trim() === "Coach" ? true : false;
	finish = true;
	f_name = document.getElementById("fn-txtbox");
	l_name = document.getElementById("ln-txtbox");
	height = document.getElementById("height-txtbox");
	weight = document.getElementById("weight-txtbox");
	phone_num =document.getElementById("phone-num-txtbox");

	if (!isNaN(weight.value)) {
		valid_weight = true;	
	}

	if (!isNaN(height.value)) {
		valid_height = true;
	}
			
	if (f_name.value.length > 0 && /^[A-Za-z]+$/.test(f_name.value)) {
		valid_fname = true;
	} 

	if (l_name.value.length > 0 && /^[\w'\-,.]*[^0-9_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/.test(l_name.value)) {
		valid_lname = true;
	}

	// /^\(?([0-9]{3})\)?-?([0-9]{3})-?([0-9]{4})$/
	if (/^\d{10}$/.test(phone_num.value)) {
		valid_phone = true;
	} 
	console.log("phone", valid_phone)
			

	console.log("usertype_drop", usertype_drop.innerText)
	console.log("Coach", is_coach)

	if (is_coach) {
		if (!(valid_fname && valid_lname && valid_height && valid_weight && valid_phone)) {
			console.log("Missing fields");
			console.log("iscoach", is_coach);
			console.log("fname", valid_fname);
			console.log("lname", valid_lname);
			console.log("height", valid_height);
			console.log("weight", valid_weight);
			console.log("phone",valid_phone);
			finish = false;
		}
	}
	if (finish) {
		$.ajax({
			url: 'edit_user.php',
			type: 'post',
			async: false,
			data: {
				'edited':1,
				'f_name_edited': valid_fname ? f_name.value : null,
				'l_name_edited': valid_lname ? l_name.value: null,
				'height_edited': valid_height ? height.value : null,
				'weight_edited': valid_weight ? weight.value : null,
				'phone_number_edited': valid_phone ? phone_num.value: null,
				'gender_edited':gender_drop.innerText,
				'user_type_edited':usertype_drop.innerText
			},
			success:function(id){
				window.location.href=`user.php?user_id=${id}`;
			}
		});
		alert("Saved Changes");
	} else {
		alert("Coaches Must Correctly Fill Out All Information");
	}
			

}

// validating phone number
var phone_input = document.getElementById("phone-num-txtbox");		
var invalid = "&#x274C";
var valid = "&#x2713;";

phone_input.oninput = function() {
	symbol = document.getElementById("phone_validator");
	console.log(symbol)
	if (phone_input.value.match(/^\d{10}$/)) {
    symbol.innerHTML = `${valid} Phone Number Format: <b>XXXXXXXXXX</b>`;
    symbol.classList.remove("invalid");
    symbol.classList.add("valid");
	} else {
		symbol.innerHTML = `${invalid} Phone Number Format: <b>XXXXXXXXXX</b>`;
		symbol.classList.remove("valid");
		symbol.classList.add("invalid");
	}
}
		



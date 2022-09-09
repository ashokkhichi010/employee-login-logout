	function display(id){
		if (id == 'sign-up') {
			document.getElementById('signup').style.display = 'block';
			document.getElementById('login').style.display = 'none';
		}else if (id == 'log-in') {
			document.getElementById('signup').style.display = 'none';
			document.getElementById('login').style.display = 'block';
		}
	}
	function inout(name) {
		if (name == 'in') {
			document.getElementById('in').style.display = "none";
			document.getElementById('out').style.display = "block";
		}else{
			document.getElementById('out').style.display = "none";
			document.getElementById('in').style.display = "block";
		}
	}
	profile('user-profile');
	function profile(name) {
		var profileArray = ['user-profile','update-user-profile','change-password'];
		for(var i = 0; i < 3; i++){
			if (profileArray[i] == name) {
				document.getElementById(name).style.display = 'block';
				document.getElementById(i).style.backgroundColor = '#ead3ff';
				document.getElementById(i).style.color = 'white';
			}else{
				document.getElementById(profileArray[i]).style.display = 'none';
				document.getElementById(i).style.backgroundColor = 'white';
				document.getElementById(i).style.color = '#8400ff';
			}
		}
	}
	
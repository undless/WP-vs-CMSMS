

window.onload = function() {
	var i = 0;
	var localStorageKey = "";

	/* Get localStorage */
	for (i = 0; i < localStorage.length; i++) {
		localStorageKey = localStorage.key(i);
		if (document.getElementById(localStorageKey)) {
			document.getElementById(localStorageKey).value = localStorage.getItem(localStorageKey);
		};
	};

	/* Set localStorage */
	var inputList = document.getElementById("fromDB").getElementsByTagName("input");
	for (i = 0; i < inputList.length ; i++) {
		inputList[i].addEventListener("focusout", function(event) {
			localStorage.setItem(this.name, document.getElementById(this.name).value);
		});
	};

	/* Clear localStorage */
	document.getElementById("reset").addEventListener("click", function(event) {
		localStorage.clear();
		console.log("localStorage Cleared");
	});


	function ProcessForm(datas) {
		var feu = true;
		for(var i in datas){
			if(datas[i] == ''){
				document.getElementById(i).style.borderColor = "#FE4365";
				feu = false;
			}else{

				document.getElementById(i).style.borderColor = "";
			}
		}
		return feu;
	}


	document.getElementById("submit").addEventListener("click", function(event){

		var datasFromDBinputs = document.getElementById("fromDB").getElementsByTagName("input");
		var datasFromDB = {};
		for (i = 0; i < datasFromDBinputs.length ; i++) {
			datasFromDB[datasFromDBinputs[i].name] = datasFromDBinputs[i].value;
		};

		var formValid = ProcessForm(datasFromDB);
		if (formValid) {

			var xmlhttp=new XMLHttpRequest();
			xmlhttp.open("POST","script/db_get.php",true);
			xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState != 4 || xmlhttp.status != 200) return;
				document.getElementById('table').innerHTML = xmlhttp.responseText;
			};
			var datastr='';
			for(var i in datasFromDB){
				if (datastr != '') {
					datastr = datastr + "&";
				};
				datastr = datastr + i + "=" + datasFromDB[i];
			}

			xmlhttp.send(datastr);
		};

    });	
};
var xhr = new XMLHttpRequest();

var event_array = document.getElementsByClassName('event');

for(var i = 0 ; i < event_array.length; i++){

	event_array[i].onclick = function() {

		var name = this.innerHTML;
		var params = 'evName=' + name;
		
		xhr.open('POST','../accaunt.php',true);

		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

		xhr.onreadystatechange = function() {
			
			if (xhr.readyState != 4) return;

			if (xhr.status != 200) {
                document.getElementById("response").className="alert alert-danger";
                document.getElementById("response").innerHTML =xhr.responseText;
			}
            else{
                document.getElementById("response").className="alert alert-success";
                document.getElementById("response").innerHTML=xhr.responseText;
            }
		}

		xhr.send(params);
	}
}			
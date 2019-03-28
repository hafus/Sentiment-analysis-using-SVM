function noo()
{
	return false;
}
 function validate_selections()
{
	  var airlines_selected = document.getElementsByClassName("airline");
	  var submitbtn = document.getElementById("submitbtn");
	  submitbtn.disabled = true;
	  for(var i = 0 ; i < airlines_selected.length; i++)
		  {
			  if(airlines_selected[i].checked)
				  {
					  submitbtn.disabled = false;
					  return;
				  }
		  }
  }

function load_page() {
					loadProgress();
					 var airlines_selected = document.getElementsByClassName("airline");
					 var formdata = new FormData();
					 var data = [];
					  for(var i = 0 ; i < airlines_selected.length; i++)
						  {
							  if(airlines_selected[i].checked)
								  {
									  data.push(airlines_selected[i].value);
								  }
						  }
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						 if (this.readyState == 3 && this.status == 200) {
							 if(this.responseText == ' finsh')
							document.getElementsByClassName("ani-text")[0].innerHTML = 'Performing sentiment analysis process....';
					   }
						
						
						 if (this.readyState == 4 && this.status == 200) {
							 if(this.responseText == ' finsh done'){
							 var dd=new Date();
								document.cookie = 'USER' + "=" + data.toString() + ";" + "expires="+ (dd.getTime()+24*60*60)+ ";path=/";
								 var urlpath = document.URL.split('/');
								 window.location.replace('http://'+urlpath[2]+'/'+urlpath[3]+'/dashboard.php');
							 }
							 else
						 	{
							 	document.getElementsByClassName('preloader')[0].style.display= 'none';
								document.getElementsByClassName("ani-text")[0].innerHTML = 'Sorry, There was problem. Try later.'
						 	}
					   }
					};
					var dd=new Date();
					document.cookie = 'sel' + "=" + data.toString() + ";" + "expires="+ (dd.getTime()+10*60)+ ";path=/";
					xhttp.open("GET", "pro.php", true);
					xhttp.send();
				}

function loadProgress()
{
	var page = document.getElementsByClassName('home-page')[0];
	page.style.pointerEvents = 'none';
	page.style.opacity = 0.2;
	document.getElementsByClassName('wrapper')[0].style.display = 'unset';
}

function getFeedback(row)
{
	if (row.cells[4].firstChild.checked){
	var formdata = new FormData();
	formdata.append('op',"insert");
	formdata.append('id',row.cells[1].innerHTML);
	formdata.append('tweet',row.cells[2].innerHTML);
	formdata.append('class',row.parentNode.className);
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		// if (this.readyState == 4 && this.status == 200) alert('responsss '+this.responseText);
	}
	
	xhttp.open("POST", "insertdataset.py", true);
	xhttp.send(formdata);
	
	}else
		{
			var formdata = new FormData();
			formdata.append('op',"not");
			formdata.append('id',row.cells[1].innerHTML);

			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				// if (this.readyState == 4 && this.status == 200) alert('responsss '+this.responseText);
			}

			xhttp.open("POST", "insertdataset.py", true);
			xhttp.send(formdata);
		}
}


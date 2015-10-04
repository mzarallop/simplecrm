
OLD School
var req = new XMLHttpRequest();
req.open('GET', 'http://www.mozilla.org/', false); 
req.send(null);
if(req.status == 200)
  dump(req.responseText);



Actual
----------------------------------------------------
var datos = {
	nombre:$().val()
}

var proceso = $.ajax({
	url: '/path/to/file?data1='+dato1+'&datao2='+,
	type: 'POST',
	dataType: 'json',
	async:false, 
	data: datos,
})

console.log(proceso.responseText)


.done(function() {
	console.log("success");
})
.fail(function() {
	console.log("error");
})
.always(function() {
	console.log("complete");
});

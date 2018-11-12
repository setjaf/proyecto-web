
$("#btnregistro").click(function(event) {
	$("#exampleModal").modal("toggle");
});

var cont1 = document.getElementById('contrasena_nueva1');
var cont2 = document.getElementById('confirmar_contrasena_nueva1');
var btn_guard = document.getElementsByName('agregar_usuario')

cont1.addEventListener('change',function () {
	console.log(btn_guard);
	if (cont1.value != cont2.value) {
		btn_guard[0].setAttribute('disabled','disabled');
	}else{
		btn_guard[0].removeAttribute('disabled');
	}
})
cont2.addEventListener('change',function () {
	console.log(btn_guard);
	if (cont1.value != cont2.value) {
		btn_guard[0].setAttribute('disabled','disabled');
	}else{
		btn_guard[0].removeAttribute('disabled');
	}
})

var cont3 = document.getElementById('contrasena_nueva2');
var cont4 = document.getElementById('confirmar_contrasena_nueva2');
var btn_guard1 = document.getElementsByName('editar_usuario')

cont3.addEventListener('change',function () {
	console.log(btn_guard1);
	if (cont3.value != cont4.value) {
		btn_guard1[0].setAttribute('disabled','disabled');
	}else{
		btn_guard1[0].removeAttribute('disabled');
	}
})
cont4.addEventListener('change',function () {
	console.log(btn_guard1);
	if (cont3.value != cont4.value) {
		btn_guard1[0].setAttribute('disabled','disabled');
	}else{
		btn_guard1[0].removeAttribute('disabled');
	}
})


var cont5 = document.getElementById('contrasena_nueva3');
var cont6 = document.getElementById('confirmar_contrasena_nueva3');
var btn_guard1 = document.getElementsByName('editar_usuario')

cont5.addEventListener('change',function () {
	console.log(btn_guard1);
	if (cont5.value != cont6.value) {
		btn_guard1[0].setAttribute('disabled','disabled');
	}else{
		btn_guard1[0].removeAttribute('disabled');
	}
})
cont6.addEventListener('change',function () {
	console.log(btn_guard1);
	if (cont5.value != cont6.value) {
		btn_guard1[0].setAttribute('disabled','disabled');
	}else{
		btn_guard1[0].removeAttribute('disabled');
	}
})


/*$( "#form_alumno" ).submit(function( event ) {
	event.preventDefault();
	console.log(event);
	data=new Object();
	for (var i = 0; i < event.delegateTarget.length; i++) {
		data[event.delegateTarget[i].name]=event.delegateTarget[i].value;

		if (event.delegateTarget[i].name=='foto') {
			data[event.delegateTarget[i].name]=event.delegateTarget[i].files;
		}

	}
	console.log(data);

	$.ajax({
		url: "http://localhost:81/proy/",
		contentType:"multipart/form-data",
		data:data,
		method:"POST"
	}).done(function() {
		alert("Hecho enviado");
	}).fail(function() {
		alert( "error" );
	}).always(function() {
		alert( "complete" );
	}).error(function(e) {
		alert("Error");
		console.log(e);
	});



  
});
*/
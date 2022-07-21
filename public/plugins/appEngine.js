var $appEngine=new (function(){	
	
	var self=this;	
	//Configurar en config.js
	var host  = null; 
	var clave = null;
	var mainContent=$("#main_content");

	self.mainContent=mainContent;
	self.Path=new Object;
	self.Template=new Object;	
	self.Rest=new Object;	
	self.Datatable=new Object;
	self.filtros=new Object;

	self.setHost=function(hostConfig){
		host=hostConfig;
	}

	self.getHost=function(){
		return host;
	}

	self.hideMainContent=function(){
		$("#main_content").hide();
	}

	self.showMainContent=function(){
		$("#main_content").show();
	}


	//Esta es la definitiva de los render 2020-04-18
	self.Template.renderizar=function(urlTemplate,userOptions,callbackFunction){

		var options={
			targetElement:undefined,	
			callback:function(){},		
			data:{},
			type:"GET",
			async:true,
		};

		if(userOptions===undefined){
			userOptions={};
		}

		$.extend(options,userOptions);

		vista="Vista no encontrada";
		$.ajax({
			url: self.getHost()+"/"+urlTemplate,
			data: options.data,
			success: function(dataview){													
				vista= dataview;
				//mainContent.hide();
				if(options.targetElement===undefined){					
					mainContent.html(vista); 
				}else{
					options.targetElement.html(vista);
				}

				if(callbackFunction!==undefined){
					callbackFunction(options.data);
					
				}				
			},			
			cache: false,
			type: options.type,
			async:options.async,
		});		

	}

	//Para el magnific
	self.Template.get=function(urlTemplate){		
		vista="Vista no encontrada";
		$.ajax({
			url: self.getHost() +  urlTemplate,
			data: {},
			success: function(dataview){													
				vista= dataview;
			},			
			cache: false,
			type: "GET",
			async:false,
		});
		return vista;
	};

	self.Path.add = function(path,def,name,callback){		
		$.routes.add(path,def,name,callback);
	};

	self.Path.find=function(name_function,param){
		$.routes.find(name_function).routeTo(param);
	};

	self.Path.reload=function(param){
		$.routes.reload(param);
	};

	//Generacion de tablas paginadas por ajax
	self.Datatable.ajax=function(element,urlRest,columnas,userOptions){

		//,datax,order,callback
		if(userOptions===undefined){
			userOptions={};
		}

		options=$.extend({
	      datax:function(){},
	      order:[],
	      callback:function(response){}
	    },userOptions);

		/*if(options.order===undefined){
			options.order=[[ 0, "desc" ]]
		}*/

		dataTable=element.DataTable( {
	        "processing": true,
	        "serverSide": true,
	        "columns":columnas,
	        "stateSave":false,
	        //"dom": '<"top">rt<"bottom">p<"clear">',
	        "sWrapper": "dataTables_wrapper form-inline",
	        //"ordering":false, // El server define el ordenado por default
	        "order": options.order,
	        "ajax": {
	            "url": self.getHost()+urlRest,
	            "type": "POST",
	            "data":function(d){
	            	if(typeof options.datax=='function'){
	            		d.data=options.datax();
		            }else{
		            	d.data=options.datax;
	            	}
	            },
	            "complete":function(response){
	            	if(options.callback!=undefined){
	            		options.callback(response.responseJSON);
	            	}
	            },
	            beforeSend: function(xhr) {
	        		//xhr.setRequestHeader('Clave',$appEngine.getClave());
	        		xhr.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content') );
					/*if(options.loading){
	        			$.LoadingOverlay("show");
	        		}*/
	            },
	        },
	        "language":{
			    "processing":     "Procesando...",
			    "lengthMenu":     "Mostrar _MENU_ registros",
			    "zeroRecords":    "No se encontraron resultados",
			    "emptyTable":     "Ningún dato disponible en esta tabla",
			    "info":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			    "infoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			    "infoFiltered":   "(filtrado de un total de _MAX_ registros)",
			    "infoPostFix":    "",
			    "search":         "Buscar:",
			    "url":            "",
			    "infoThousands":  ",",
			    "loadingRecords": "Cargando...",
			    "paginate": {
			        "first":    "Primero",
			        "last":     "Último",
			        "next":     "Siguiente",
			        "previous": "Anterior"
			    },
			    "aria": {
			        "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
			        "sortDescending": ": Activar para ordenar la columna de manera descendente"
			    }
			}
	    } );

		return dataTable;
	}

	//Generacion de tablas paginadas por ajax
	self.Datatable.ajaxSimple=function(element,urlRest,columnas,datax){

		dataTable=element.DataTable( {
	        "columns":columnas,
	        "ajax": {
	            "url": self.getHost()+urlRest,
	            "type": "POST",
	            "data":function(d){
	            	if(typeof datax=='function'){
	            		d.data=datax();
		            }else{
		            	d.data=datax;
	            	}
	            },
	            "beforeSend": function(xhr) {
	            	xhr.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
	            },
	        },
	        "language":{
			    "processing":     "Procesando...",
			    "lengthMenu":     "Mostrar _MENU_ registros",
			    "zeroRecords":    "No se encontraron resultados",
			    "emptyTable":     "Ningún dato disponible en esta tabla",
			    "info":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			    "infoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			    "infoFiltered":   "(filtrado de un total de _MAX_ registros)",
			    "infoPostFix":    "",
			    "search":         "Buscar:",
			    "url":            "",
			    "infoThousands":  ",",
			    "loadingRecords": "Cargando...",
			    "paginate": {
			        "first":    "Primero",
			        "last":     "Último",
			        "next":     "Siguiente",
			        "previous": "Anterior"
			    },
			    "aria": {
			        "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
			        "sortDescending": ": Activar para ordenar la columna de manera descendente"
			    }
			}
	    } );

		return dataTable;
	}	

	//Generacion de tablas simples con el data cargado
	self.Datatable.simple=function(element,data,columnas,order){
		//console.log(data);
		if(order===undefined){
			order=[[ 0, "desc" ]]
		}
		dataTable=element.DataTable( {
	        //"processing": true,
	        //"serverSide": true,
	        "order": order,
	        "columns":columnas,
	        "data":data
	    } );

		return dataTable;
	}	

	/** Version actualizada del RESTFul api */
	// Version 2021FEB26
	self.functionSend=function(urlRest,type,datax,userOptions){

		var options={
			loading:false,
			async:true,
			dataType: 'json',
			contentType:"application/json",
			statusSuccess:function(resp){				
				$appEngine.message("success",resp.message);
			},
			statusError:function(resp){
				if(resp.message.length){
					$appEngine.message("error",resp.message);
				}
			},
			statusUnauthorized:function(resp){
				$appEngine.message("error","El tiempo de la sessión ha caducado");
				location.href='login.html';
			}
		};

		$.extend(true,options,userOptions);
		
		//console.log(callbackFunction);
		if(options.contentType=="application/json"){
			if(datax===null){
				dataSend=null;
			}else{
				dataSend=JSON.stringify(datax);
				//dataSend=datax;
			}
		}

		if(options.contentType=='application/x-www-form-urlencoded; charset=UTF-8'){
			if(datax===null){
				dataSend=null;
			}else{
				dataSend=datax;
			}
		}

		if(options.contentType===false){
			dataSend=datax;
		}

		//Si solicito que se muestra el gif de cargando
		if(options.loading){
			options.async=true;
		}

		$.ajax({
			type: type,
			url: self.getHost()+urlRest,
			//dataType: 'json',
			data: dataSend,
			async:options.async,
			contentType: options.contentType,
            processData: false,
            success: function(data, textStatus, request){

        		if(data.status=="unauthorized"){
					options.statusUnauthorized(jsonResponse);
				}
			
				if(data.status=="success"){
					//console.log(jsonResponse);
					options.statusSuccess(data);
				}
			
				if(data.status=="error" ){
					options.statusError(data);
				}
        		
   			},
			beforeSend: function(xhr) {
        		xhr.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content') );
				if(options.loading){
        			$.LoadingOverlay("show");		        
        		}
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
                $appEngine.message("error",errorThrown);
                if(options.loading){
            		$.LoadingOverlay("hide");	    
            	}
          	},
            complete : function () {
            	if(options.loading){
            		$.LoadingOverlay("hide");	    
            	}
            	//calcularDimensiones();
            },			
		}).done(function( jsonResponse ) {

		});		
	}	

	self.Rest.post = function(urlRest, datax,options){
		self.functionSend(urlRest,"POST",datax,options);
	};

	self.Rest.get=function(urlRest,options){
		self.functionSend(urlRest,"GET",null,options);
	};

	self.Rest.put=function(urlRest, datax,options){
		self.functionSend(urlRest,"PUT",datax,options);
	};

	self.Rest.delete=function(urlRest,options){
		self.functionSend(urlRest,"DELETE",null,options);
	};

	//Plugins varios del tema

	self.chosen=function(){
		$(".chosen-select").chosen();
	}

	self.message=function(status,message){
		//toastr[status](message);

		$.toast({
		    text: message, // Text that is to be shown in the toast
		    heading: 'Mensaje de Sistema', // Optional heading to be shown on the toast
		    icon: status, // Type of toast icon
		    showHideTransition: 'fade', // fade, slide or plain
		    allowToastClose: true, // Boolean value true or false
		    hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
		    stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
		    position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values		   
		    textAlign: 'left',  // Text alignment i.e. left, right or center
		    loader: false, 
		    beforeShow: function () {}, // will be triggered before the toast is shown
		    afterShown: function () {}, // will be triggered after the toat has been shown
		    beforeHide: function () {}, // will be triggered before the toast gets hidden
		    afterHidden: function () {}  // will be triggered after the toast has been hidden
		});

	}

	self.messageAlert=function(userOptions){

		options={
			title: 'Mensaje de Sistema',
		    content: '',
		    callback:function(){},
		}

		$.extend(true,options,userOptions);

		$.confirm({
		    title: options.title,
		    content: options.content,
		    buttons: {
		        Aceptar: options.callback
		    }
		});
	}
	
	self.messageConfirm=function(userOptions,callbackAceptar,callbackCancelar){
		options={
			title: '',
		    content: '',
		    textoAceptar:'Aceptar',
		    textoCancelar:'Cancelar',
		}

		$.extend(true,options,userOptions);

		$.confirm({
		    title: options.title,
		    content: options.content,
		    buttons: {
		    	aceptar:{
		    		text:options.textoAceptar,
		    		action:callbackAceptar
		    	},
		    	cancelar:{
		    		text:options.textoCancelar,
		    		action:(callbackCancelar===undefined)?function(){}:callbackCancelar
		    	}
		    }
		});
	}

	self.datepicker=function(element,userOptions){
		//Campos de tipo fecha
		
		//var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

	    if(userOptions===undefined){
			userOptions={};
		}

		options=$.extend({
	      //format: "dd-mm-yyyy",
	      format: "yyyy-mm-dd",
	      todayHighlight: true,
	      autoclose: true
	    },userOptions);

	    element.datepicker(options);

	    if(options.defDate!=undefined){
	    	element.datepicker('setDate', options.defDate);
	    }


	}	

	self.datepickerDMY=function(element,defDate){
		//Campos de tipo fecha
		var dp=element.datepicker({
			format: "dd/mm/yyyy",
		}).on('changeDate', function(ev) {
			dp.hide()
		}).data('datepicker');
	}	

	self.showFormErrors=function(form,dataError){
		$(".form-group").removeClass("has-error");
		$(".message-error").remove();

		$.each(dataError,function(index,item){

			$("#"+item.atributo).parents(".form-group").addClass("has-error");
			
			text="";			
			$.each(item.errores,function(i,error){
				text=error+"<br>";
			});

			errorHtml="<small class=\"help-block message-error\">"+text+"</small>";

			$("#"+item.atributo).parent().append(errorHtml);
			//console.log(item.atributo);
			
		});

		self.message("error","Error al guardar la información");
	}

	self.hideFormErrors=function(form){
		$(".form-group").removeClass("has-error");
		$(".message-error").remove();
	}	

	self.click=function(selector,functionCallback){
		$(selector).off("click").click(function(){
			
			functionCallback(this);

		})
	}

	self.scrollTo=function(element){
		$('html, body').animate({
            scrollTop: element.offset().top
        }, 1500);
	}

	//Autocomplete que ocupo en todos que
	self.autocomplete=function(elemento,urlRest,callbackSuccess){
	    $( elemento ).autocomplete({
	      source: function( request, response ) {
	        $.ajax( {
	        type:'post',
	          url: self.getHost()+urlRest,
	          //dataType: "jsonp",
	          data: {
	            term: request.term
	          },
	          beforeSend: function(xhr) {
	            	//Agregamos a las cabeceras la info de authenticacion
	        		//xhr.setRequestHeader('AuthorizationToken', $.cookie("AuthorizationToken") );
	        		//xhr.setRequestHeader('EmpresaID', $.cookie("EmpresaID") );
	        		xhr.setRequestHeader('Clave',$appEngine.getClave());
	            },
	          success: function( json ) {
	            response( json.data );
	          }
	        } );
	      },
	      minLength: 2,
	      select: function( event, ui ) {
	        callbackSuccess(ui.item.id,ui.item.value,ui.item);
	        return false;
	      },
	      selectFirst: true,
			change: function (event, ui) {
			    if (ui.item == null){ 
			     	//here is null if entered value is not match in suggestion list
			        $(this).val((ui.item ? ui.item.id : ""));
			    }
			}
	    } );		
	}

	self.getCurrentDate=function(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
		    dd = '0'+dd
		} 

		if(mm<10) {
		    mm = '0'+mm
		} 

		return yyyy + '-' + mm + '-' + dd;
	}

});
 
/*$(document).ready(function(){
	
	$(document).bind('keyup', 'esc',function(){
		$.magnificPopup.close();
	});	

});*/

//Plugin para recolectar datos de un formulario
(function( $ ) {
	$.fn.getValues = function() {

		var data=new Object;
		var form=$(this);

		$(this).find(":input").each(function() {
       		// Do something to each element here.
			var element=$(this);	
			var tipo=$(this).attr('type');
			//console.log(tipo);
			if( ( element.attr("attr-send")==undefined || element.attr("attr-send")=="send" ) ){		
				if(tipo!="button"){
					if(tipo=="checkbox"){
						//console.log( element.attr("id")+" "+element.attr("name")+" cant:"+form.find("input[name=\""+element.attr("name")+"\"]").length );

						//Si uso el ID, es solo un elemento para 1 y 0
						/*if( element.attr("id")!=undefined ){
							data[element.attr("id")]=(element.prop("checked"))?1:0;
						}

						if( element.attr("name")!=undefined ){
							if(element.prop("checked")){

								if(data[element.attr("name")]==undefined){
									data[element.attr("name")]=[];
								}

								data[element.attr("name")].push(element.val());
						
							}
						}*/
						//Si hay mas de un elemento, entonces es un arreglo
						if(form.find("input[name=\""+element.attr("name")+"\"]").length>1){
							//console.log(element.attr("name")+" es array");
							if(data[element.attr("name")]==undefined){
								data[element.attr("name")]=[];
							}
							
							if(element.prop("checked")){
								data[element.attr("name")].push(element.val());
							}
						}

						if(form.find("input[name='"+element.attr("name")+"']").length==1){
							//console.log(element.attr("name")+" es elemento");
							data[element.attr("id")]=(element.prop("checked"))?1:0;
						}
						
					}else{
						data[element.attr("id")]=element.val();
					}					
				}

			}
    	});

		/*this.each(function() {
       		// Do something to each element here.
			var element=$(this);			
			data[element.attr("id")]=element.val();
    	});*/

		//console.log(data);
    	return data;
    }
}( jQuery ));	

//Funcion para insertar los datos en el formulario
(function( $ ) {
	$.fn.setValues = function(object) {

		for(var name in object) {
		    var value = object[name];		    
		    		    
		    tipo=$(this).find("#"+name).prop("tagName");
		    type=$(this).find("#"+name).attr('type');
		    element=$(this).find("#"+name);

		    //console.log(tipo);
		    //console.log(type);
		    
		    if(tipo=='INPUT' || tipo=='TEXTAREA' || tipo=='SELECT' || tipo=='PASSWORD' || tipo=='HIDDEN' ){
		    	if(type=="checkbox"){
		    		element.prop("checked",value);
		    	}else{
		    		element.val(value);	
		    	}		    	
		    }

		    if(tipo=='IMG'){
		    	element.attr("src",value);	
		    }

		    if(tipo=='P' || tipo=='DIV' || tipo=='TD' || tipo=='LABEL' || tipo=='FONT' ){
		    	element.html(value);		
		    }

		    if(tipo=='A'){
		    	element.attr("href",value);	
		    }
		    
		}

    	//return data;
    }
}( jQuery ));	

(function( $ ) {
	$.fn.mostrarErrores = function(errors) {
		form=$(this);
		form.find("input,textarea,select").removeClass("is-valid").removeClass("is-invalid").removeClass("invalid-feedback");
		//var messageWindow="";		
		$.each(errors,function(i,v){
	        form.find("#"+v.attribute).addClass("is-invalid");
	        html="";
	        $.each(v.message,function(j,m){
	          html+=m+"<br>";
	        });
	        //form.find("#"+v.attribute+"_feedback").addClass("invalid-feedback").html(html);	        
	        form.find("#"+v.attribute).closest(".form-group").find(".feedback").addClass("invalid-feedback").html(html);
	        //form.find("#"+v.attribute).closest(".form-group").find(".feedback").show();
      	});
	}
}( jQuery ));	

(function( $ ) {
	$.fn.removerErrores = function() {
		form=$(this);
		form.find("input,textarea,select").removeClass("is-valid").removeClass("is-invalid").removeClass("invalid-feedback").removeClass("valid-feedback");		
	}
}( jQuery ));	

(function( $ ) {
	$.fn.mostrarAciertos = function() {
		form=$(this);
		form.find("input,textarea,select").addClass("is-valid");		
	}
}( jQuery ));	

(function( $ ) {
	$.fn.formatoMayusculas = function() {
		form=$(this);
		form.find("input:text,textarea,select").css("text-transform","uppercase");	
	}
}( jQuery ));	


//Actiualizado vJulio2021 Para declarar multiples input file
(function( $ ) {
	$.fn.simpleLoadFile = function(customOptions) { //url,elementValue,elementLabel,callback

		return this.each(function() {

			var elem = $( this );

			var options={
				label:"NO CUENTA",
				url: "",
				elementLabel:undefined,
				callbackLoad:function(porcentaje,elem){},
				callbackSuccess:function(jsonResponse){},
				callbackError:function(jsonResponse){},
				getData:function(formData,elem){
					//Por si requerimos mandar más información
					return formData;
				},			
				/*btnEliminarClick:function(form,formData){},
				btnVisualizarClick:function(form,formData){},*/
			};

			if(customOptions===undefined){
				customOptions=options;
			}

			$.extend(true, options, customOptions);

			elem.on("change",function(){
				var input = elem;
				numFiles = input.get(0).files ? input.get(0).files.length : 1;
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [numFiles, label]);
			});

			elem.on('fileselect', function(event, numFiles, label) {
				//console.log("seleccionado",label);
				if(options.elementLabel!==undefined){
					options.elementLabel.html(label);
				}
				//Subimos el archivo y retornamos los valores solicitados
				var formData = new FormData();

				formData=options.getData(formData,elem);
				formData.append("fileupload",document.getElementById($(elem).attr("id")).files[0]);
				
				var ajax = new XMLHttpRequest();			
				ajax.upload.addEventListener("progress", function(event) {
				  //options.elementLabel.html("Uploaded " + event.loaded + " bytes of " + event.total);
				  var percent = (event.loaded / event.total) * 100;
				  //_("progressBar").value = Math.round(percent);
				  if(options.elementLabel!==undefined){
				  	options.elementLabel.html(Math.round(percent) + "%");				  	
				  }

				  options.callbackLoad(Math.round(percent),elem);
				}, false);
				ajax.addEventListener("load", function(event){
					var jsonResponse = JSON.parse(ajax.responseText);
					if(jsonResponse.status=="success"){
						if(options.elementLabel!==undefined){
							options.elementLabel.html(jsonResponse.data.localname);
						}
						options.callbackSuccess(jsonResponse);
					}else{
						if(options.elementLabel!==undefined){
							options.elementLabel.html("Subir Documento");
						}
						//$appEngine.message("error",jsonResponse.message);
						console.log("ERR:"+jsonResponse.message);
						options.callbackError(jsonResponse);
					}
					console.log(jsonResponse);
				}, false);
				ajax.addEventListener("error", function(event){
					//$appEngine.message("error","Error " + event.target.status + " occurred while receiving the document.");
					console.log("ERR"+event.target.status + " occurred while receiving the document.");
				}, false);
				//ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST",$appEngine.getHost()+options.url);
				ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
				ajax.send(formData);

			});

		});

    }
}( jQuery ));

(function( $ ) {
	$.fn.customLoadFile = function(customOptions) {

		var options={
			label:"NO CUENTA",
			url: "",
			getData:function(form,formData){},
			callback:function(form,jsonResponse){},
			btnEliminarClick:function(form,formData){},
			btnVisualizarClick:function(form,formData){},
		};

		if(customOptions===undefined){
			customOptions=options;
		}

		$.extend(true, options, customOptions);

		console.log(options);

		//Aplicar a cada elemento
		return this.each(function() {

			//console.log($(this));

	        // Do something to each element here.

	        var form=$(this);
	        
	        var element=$(this).find("input[type='file']");	        

	        var elementLabel=form.find("#label");	 

	        var porcentaje=form.find("#porcentaje");

			element.on("change",function(){
				var input = element;
				numFiles = input.get(0).files ? input.get(0).files.length : 1;
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				console.log(numFiles,label);
				input.trigger('fileselect', [numFiles, label]);
			});

			element.on('fileselect', function(event, numFiles, label) {
				//console.log("seleccionado",label);
				/*if(elementLabel!==undefined){
					elementLabel.html(label);
				}*/
				//Subimos el archivo y retornamos los valores solicitados
				var formData = new FormData();

				formData.append("fileupload",document.getElementById(element.attr("id")).files[0]);
				
				formData=options.getData(form,formData);

				/*$.each(arrData,function(i,v){
					formData.append(v.parametro,v.valor);
				});*/

				var ajax = new XMLHttpRequest();			
				ajax.upload.addEventListener("progress", function(event) {
				  //elementLabel.html("Uploaded " + event.loaded + " bytes of " + event.total);
				  var percent = (event.loaded / event.total) * 100;
				  //_("progressBar").value = Math.round(percent);
				  porcentaje.html(Math.round(percent) + "%");
				}, false);
				ajax.addEventListener("load", function(event){
					console.log(ajax.responseText);
					var jsonResponse = JSON.parse(ajax.responseText);
					if(jsonResponse.status=="success"){
						//elementValue.val(jsonResponse.data.path);
						//elementLabel.html(jsonResponse.data.localname);
						//if(options.callback!==undefined){
							options.callback(form,jsonResponse);
						//}
					}else{
						//elementLabel.html("Subir Documento");
						$appEngine.message("error",jsonResponse.message);
					}
					console.log(jsonResponse);
				}, false);
				ajax.addEventListener("error", function(event){
					$appEngine.message("error","Error " + event.target.status + " occurred while receiving the document.");
				}, false);
				//ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST",options.url);
				ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
				ajax.send(formData);

			});

			form.find("#btn-upload").off("click").click(function(){
				element.click();
			});

			form.find("#btn-eliminar").off("click").click(function(){
				options.btnEliminarClick(form);
			});

			form.find("#btn-visualizar").off("click").click(function(){
				options.btnVisualizarClick(form);
			});

	    });

    }
}( jQuery ));


(function( $ ) {
	$.fn.loadFile = function(url,elementValue,elementLabel,callback) {

		this.on("change",function(){
			var input = $(this);
			numFiles = input.get(0).files ? input.get(0).files.length : 1;
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
		});

		this.on('fileselect', function(event, numFiles, label) {
			//console.log("seleccionado",label);
			if(elementLabel!==undefined){
				elementLabel.html(label);
			}
			//Subimos el archivo y retornamos los valores solicitados
			var formData = new FormData();

			formData.append("fileupload",document.getElementById($(this).attr("id")).files[0]);
			formData.append("aux","temporal");
			//formData.append('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
			
			/*$appEngine.Rest.post(url,formData,function(jsonResponse){
				if(elementValue!==undefined){
					elementValue.val(jsonResponse.data.path);
				}
				if(callback!==undefined){
					callback(jsonResponse);
				}
			},{
				contentType:false,
				async:false,
			});*/

			var ajax = new XMLHttpRequest();			
			ajax.upload.addEventListener("progress", function(event) {
			  //elementLabel.html("Uploaded " + event.loaded + " bytes of " + event.total);
			  var percent = (event.loaded / event.total) * 100;
			  //_("progressBar").value = Math.round(percent);
			  elementLabel.html(Math.round(percent) + "%");
			}, false);
			ajax.addEventListener("load", function(event){
				var jsonResponse = JSON.parse(ajax.responseText);
				if(jsonResponse.status=="success"){
					elementValue.val(jsonResponse.data.path);
					elementLabel.html(jsonResponse.data.localname);
					if(callback!==undefined){
						callback(jsonResponse);
					}
				}else{
					elementLabel.html("Subir Documento");
					$appEngine.message("error",jsonResponse.message);
				}
				console.log(jsonResponse);
			}, false);
			ajax.addEventListener("error", function(event){
				$appEngine.message("error","Error " + event.target.status + " occurred while receiving the document.");
			}, false);
			//ajax.addEventListener("abort", abortHandler, false);
			ajax.open("POST",$appEngine.getHost()+url);
			ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
			ajax.send(formData);

		});

    }
}( jQuery ));

// Para poblar un select
(function( $ ) {
	$.fn.populate = function(arrData,options) {

		//Si no se declaran las opciones lo declaramos vacio
		if(options===undefined){
			options={};
		}

		var baseOptions={
			value:"id",
			label:"label",
			selectedValue:"",
			emptyOptions:true,
			emptyValue:"",
			emptyLabel:"SELECCIONAR",
			onChange:undefined,
		};

		$.extend(true, baseOptions, options);

		var select=$(this);
		var optionsHtml="";
		if(baseOptions.emptyOptions){
			optionsHtml+="<option value=\""+baseOptions.emptyValue+"\">"+baseOptions.emptyLabel+"</option>";
		}
		//console.log(baseOptions);
		$.each(arrData,function(i,o){
			//console.log(o);
			selected="";
			if(o[baseOptions.value]==baseOptions.selectedValue){
				selected="selected";
			}

			optionsHtml+="<option value=\""+o[baseOptions.value]+"\" "+selected+" >"+o[baseOptions.label]+"</option>";
		});
		select.html(optionsHtml);		

		//On change
		if(baseOptions.onChange!=undefined){
			select.off('change').change(function(){

				$.each(arrData,function(i,o){
					if(o[baseOptions.value]==select.val()){
						baseOptions.onChange(o);
					}
				});

			});
		}
		

    }
}( jQuery ));

(function( $ ) {
	$.fn.populateArray = function(arrData,options) {

		//Si no se declaran las opciones lo declaramos vacio
		if(options===undefined){
			options={};
		}

		baseOptions={
			selectedValue:"",
			emptyOptions:true,
			emptyValue:"",
			emptyLabel:"Seleccionar",
		};

		$.extend(true, baseOptions, options);

		var select=$(this);
		var optionsHtml="";
		if(baseOptions.emptyOptions){
			optionsHtml+="<option value=\""+baseOptions.emptyValue+"\">"+baseOptions.emptyLabel+"</option>";
		}
		//console.log(baseOptions);
		$.each(arrData,function(i,item){
			//console.log(o);
			selected="";
			if(item==baseOptions.selectedValue){
				selected="selected";
			}

			optionsHtml+="<option value=\""+item+"\" "+selected+" >"+item+"</option>";
		});
		select.html(optionsHtml);		


    }
}( jQuery ));

(function( $ ) {
	$.fn.copyToClipBoard = function(options) {
		element=$(this);

		var params = $.extend({		    
		    textValue:function(){},
		    target:null,
		}, options );
		
		$(element).off("click").click(function(){
						
			if(params.target!=null){
				textValue=params.target.val();
			}else{
				textValue=params.textValue();				
			}

			console.log(textValue);
			
			//Script para copiar y pegar
			var dummy = document.createElement("textarea");
		    document.body.appendChild(dummy);
		    dummy.value = textValue;
		    dummy.select();
		    document.execCommand("copy");
		    document.body.removeChild(dummy);

		    $appEngine.message("success","Texto copiado al portapapeles");

		});

	}
}( jQuery ));

(function( $ ) {
	$.fn.customClick = function(callback,options) {
		element=$(this);

		var params = $.extend({		    

		}, options );
		
		$(element).off("click").click(function(){
						
			callback(this);

		});

	}
}( jQuery ));

(function( $ ) {
	$.fn.customChange = function(callback,options) {
		element=$(this);

		var params = $.extend({		    

		}, options );
		
		$(element).off("change").change(function(){
						
			callback(this);

		});

	}
}( jQuery ));

(function( $ ) {
	$.fn.customEnter = function(callback,options) {
		element=$(this);

		var params = $.extend({		    

		}, options );
		
		$(element).off("keypress").on('keypress',function(e) {
		    if(e.which == 13) {
		        callback(this);
		    }
		});

	}
}( jQuery ));

function numero_formato(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

function moneda_formato(monto){
	if(parseFloat(monto)>=0){
		return "$ "+numero_formato(monto,2);
	}else{
		return "<font style=\"color:red\">- $ "+numero_formato(monto,2)+"</font>";
	}
}

function formatoMoneda(monto){
	if(parseFloat(monto)>=0 ){
		return "$ "+numero_formato(monto,2);
	}else{
		return "- $ "+numero_formato(monto,2);
	}
}

function convertirDecimal(texto){

  var cadena=texto;
  if( typeof cadena == String ){
	  var cadena=cadena.replace(/[()-,]/g,"");
	  var cadena=cadena.replace(/\s/g,"");
	}
  return parseFloat(cadena);
}

function getFechaHoy(){
	var nowDate     = new Date();
	var nowDay      = ((nowDate.getDate().toString().length) == 1) ? '0'+(nowDate.getDate()) : (nowDate.getDate());
	var nowMonth    = ((nowDate.getMonth().toString().length) == 1) ? '0'+(nowDate.getMonth()+1) : (nowDate.getMonth()+1);
	var nowYear     = nowDate.getFullYear();
	return    nowYear + "-" + nowMonth + "-" + nowDay;
}

function limpiarCadena(texto){
  var cadena=texto;
  var res=cadena.replace(/[()-]/g,"");
  var res=res.replace(/\s/g,"");
  return res;
}

function marcarMenu(item){

	$(".nav .nav-item").removeClass("active");
	$(item).addClass("active");

}

function formatCreated_at(date){
	if(date){
		date +='';
		let formatted_date = date.slice(0,10);
		return formatted_date;
	}else{
		return '';
	}
	
}
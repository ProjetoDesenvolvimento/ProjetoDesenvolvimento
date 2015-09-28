window.onload = function() {
				areaautor = document.getElementById('autorescontainer');
				buton = document.getElementById('agregarau');
				buton.onclick = function() {
					areaautor.innerHTML += '<input type="text" name="autores[]" >	';
				}

				$("#isbn").keyup(function() {
					//alert("list");
					searchBookHelper($("#isbn"),'isbn');

				});

				$("#isbn").focusout(function() {
					hideHints();
				});
				$("#titulo").keyup(function() {
					//alert("list");
					searchBookHelper($("#titulo"),'title');

				});

				$("#titulo").focusout(function() {
					hideHints();
				});

				$("#descripcion").keyup(function() {
					//alert("list");
					searchBookHelper($("#descripcion"),'description');

				});

				$("#descripcion").focusout(function() {
					hideHints();
				});

				$("#anio").keyup(function() {
					//alert("list");
					searchBookHelper($("#anio"),'year');

				});

				$("#anio").focusout(function() {
					hideHints();
				});

				$("#editora").keyup(function() {
					//alert("list");
					searchBookHelper($("#editora"),'editor');

				});

				$("#editora").focusout(function() {
					hideHints();
				});
			}

			function hideHints(){
				$("#posibilidadescontainer").fadeOut('slow');
			}
			function searchBookHelper(element, type) {
				pos = element.position();
				var x = pos.left + element.outerWidth();
				var y = pos.top - 6;
				console.info("x y " + x + " -  " + y);

				$("#posibilidadescontainer").css("left", x + 'px');
				$("#posibilidadescontainer").css("top", y);
				$("#posibilidadescontainer").fadeIn('slow');
				$("#posibilidadescontainer").css('position', 'absolute');
				//hacer solicitud

				//alert($(this).val());
				$.ajax({
					type : "GET",
					url : "../request/ajax/asinc/livros/getlivros/type/"+type+"/criteria/" + element.val(),
					success : function(data) {
						$("#containerajaxresp").html(data);
						console.info("entre" + data)
					}
				});
			}

			function addHandlingToPosibilities(){
				$(".posibilidad_item").click(function(){
					//alert("entre");
					$("#isbn").val($(this).children(".book_isbn").text());
					$("#titulo").val($(this).children(".book_title").text());
					$("#id").val($(this).children(".book_id").val());
					if($(this).children(".hdescrip")){
						$("#descripcion").val($(this).children(".hdescrip").val());
					}else{
						$("#descripcion").val($(this).children(".book_description").text());

					}

					$("#anio").val($(this).children(".book_publication").text());
					$("#paginas").val($(this).children(".book_paginas").text());
					$("#linkprevio").val($(this).children(".book_moreinfo_link ").val());
					$("#linkprevioimg").val($(this).children(".book_img_link").val());
					$("#autorescontainer").html('');

					$($(this).children(".livro_autor_item")).each(function( index ) {
						console.info("hoasdfasdfasdfasdf");
						$("#autorescontainer").html($("#autorescontainer").html()+"<input type='text' name='autores[]' value='"+$(this).val()+"' >");
					//  console.log( index + ": " + $( this ).text() );
					});

				});
			}

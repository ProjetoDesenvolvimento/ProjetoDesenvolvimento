/*
*   Feito por Francisco Coulon
*   este arquivo contem a funcionalidade da busca de livros para e mais outras funcionalidades para a página de cadastro de livros.
*   Ultima revisao 3 de novembro 2015 15:41
*   Projeto Desenvolvimento
*/

$(document).ready( function() {//adicionar tuda a funcionalidade depois de ser carregada a pagina.

                //inicializacao de variaveis
                //este é a apresentacao de um div contendo as estruturas para gestionar os autores do Livro
				areaautor = document.getElementById('autorescontainer');
				buton = document.getElementById('agregarau');//botom para adicionar Autor

				//configurar o evento do botaoo para adicionar um espaco para os autores
				buton.onclick = function() {
					$("#autorescontainer").append('<input type="text" name="autores[]" >');
				}


                /*
                *   Operacoes de busca, o ordem das funcionalidades é seguinte
                *   primeiro va quando o usuario faze um keyup acima do campo
                *   segundo va um evento se usuario sai do campo.
                *   Só funciona para o titulo só
                */
				$("#titulo").keyup(function() {
					searchBookHelper($("#titulo"),'title');
				});

				$("#titulo").focusout(function() {
					hideHints();
				});
			}
);
            /**
            *   Funcao para ocultar os resultados, seja porque o usuario saiu do campo ou clickou na posibilidade.
            */
			function hideHints(){
				$("#posibilidadescontainer").fadeOut('slow');
			}

			/**
			*   Esta funcao fez a busca dum jeito asincrónico no servidor e retorna os valores  genrados
			*   Params:
            *       element: o elemento html que permite ao script reconhecer de onde estao chamando e assim posicionar bem as respostas
            *       type: os diferentes tipos de busca, pode ser isbn, titulo, mas por enquanto fica em só titulo.
            *   Nao retorna nada mas modifica os elementos pertintentes.
			*/
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
                //uma solicitude asincrónica
				$.ajax({
					type : "GET",
					url : "/trocalivro/books/public/request/ajax/asinc/livros/getlivros/type/"+type+"/criteria/" + element.val(),
					success : function(data) {
						$("#containerajaxresp").html(data);//mostrar as respostas
					}
				});
			}

            /*
            *   Esta funcao o que fez é adicionar os eventos a cada um do elementos de resposta que se obtem na solicitude asinc.
            *   Quando o usuario click numa coincidencia, o que o evento fez é carregar os campos automaticamente para o usuario.
            */
			function addHandlingToPosibilities(){
				$(".posibilidad_item").click(function(){
					//alert("entre");
					$("#isbn").val($(this).children(".book_isbn").text());
					$("#isbn-select").text($(this).children(".book_isbn").text());
					$("#titulo").val($(this).children(".book_title").text());
					$("#id").val($(this).children(".book_id").val());
					if($(this).children(".hdescrip")){
						$("#descricao").val($(this).children(".hdescrip").val());
					}else{
						$("#descricao").val($(this).children(".book_description").text());

					}

					$("#anopublicacao").val($(this).children(".book_publication").text());
					$("#paginas").val($(this).children(".book_paginas").text());
					$("#link").val($(this).children(".book_moreinfo_link ").val());
					$("#imagemurl").val($(this).children(".book_img_link").val());
					$("#autorescontainer").html('');

					$($(this).children(".livro_autor_item")).each(function( index ) {
						console.info("hoasdfasdfasdfasdf");
						$("#autorescontainer").append($("#autorescontainer").html()+"<input type='text' name='autores[]' value='"+$(this).val()+"' >");
					//  console.log( index + ": " + $( this ).text() );
					});

				});
			}

<?php
   $contador=0;

?>

        <?php foreach ($livrosresult as $livro){ ?>
                <?php
                    if($contador==0){
                        echo " <div class='item active'>";
                    }else if($contador%3==0){
                    echo " </div> <div class='item'>";
                    }
                    $contador++;
                ?>
		 		<div class="posibilidad_item slider_item_posibilidad tl-item  col-lg-3 col-md-3 col-sm-4 col-xs-12">
		 			<span class="slider_item_titulolibro"><?php echo $livro->titulo ?></span>

		            <div class="center-block">
		                <div class="thumbnail ">
		                    <img class="img-responsive group list-group-image" src="<?php echo $livro->imagemurl ?>" alt="" />
		                </div>
		            </div>
		            <div class="row ">
		                <div class="col-xs-12 col-md-12">
		                    <span class="slider_itemtext">ISBN: <span class="book_isbn"><?php echo  $livro -> isbn?></span></span>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-xs-12 col-md-12">
		                    <span class="slider_itemtext">Publicado : <span class="book_publication"> <?php echo $livro -> ano ?> </span></span>
		                </div>
		            </div>
					<div class="slider_item_cover">
           			</div>
		             <div class="caption slider_posibilidaditem_options">

		                <div class="row top-buffer">
		                    <div class=" col-md-6 item_botones">
		                        <a style="width: 100%" class="btn btn-success <?php echo $livro->total == 0 ? 'disabled' : '' ?>" href="<?php echo asset('livro/show-book-by-user')?>/<?php echo $livro->id?>">Quero</a>
		                    </div>
		                    <div class="col-md-6 item_botones">
		                        <a style="width: 100%" class="btn btn-warning" href="<?php echo asset('livro/tenho')?>/<?php echo $livro->idgb?>/<?php echo $livro->id?>">Tenho</a>
		                    </div>
		                </div>
           			</div>

		        </div>
       <?php } ?>
		 		<div class="posibilidad_item slider_item_posibilidad tl-item  col-lg-3 col-md-3 col-sm-4 col-xs-12">
		 			<span class="slider_item_titulolibro">Ver más posibilidaddes</span>
		            <hr/>
		            <div class="center-block">
		                <div class="thumbnail ">
		                    <h1>Ver más libros aquí</h1>
		                </div>
		            </div>
					<div class="slider_item_cover">
           			</div>
		             <div class="caption slider_posibilidaditem_options">

		                <div class="row top-buffer">
		                    <div class=" col-md-12 item_botones">
		                        <a style="width: 100%" class="btn btn-success {{$livro->total == 0 ? 'disabled' : '' }}" href="{{asset('livro/show-book-by-user')}}/{{$livro->id}}">Ver mais Livros</a>
		                    </div>
		                </div>
           			</div>

		        </div>

		        </div>

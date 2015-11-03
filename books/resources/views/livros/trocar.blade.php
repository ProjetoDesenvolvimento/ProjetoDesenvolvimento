@extends('layouts.master')

@section('content')

<div>


        <ul class="thumbnails">
          @foreach($livros as $livro)
            <li style="display:inline-block;" class="span3">
                <figure>
                    <img src="http://placehold.it/100x160" alt="3 column placeholder" />
                    <figcaption>
                        <h5 style="text-align: center;">Image 3 title</h5>

                    </figcaption>
                </figure>
            </li>
            @endforeach
        </ul>

</div>

@stop
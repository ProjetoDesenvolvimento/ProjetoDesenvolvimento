<h1>Olá</h1>
<p>Estes são os livros cadastrados</p>

<ul>
    @foreach ($livros as $livro)
    <li>{{ $livro->titulo }}</li>
    @endforeach
</ul>
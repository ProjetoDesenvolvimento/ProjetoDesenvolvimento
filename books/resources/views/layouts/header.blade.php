<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid" >
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#navbar">

                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a style="width: 250px;" class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.svg') }}" />

            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{asset('usuario/criar')}}">cadastro</a></li>
                <li class="navbar-link-separator">|</li>
                <li><a href="{{asset('livro/feed')}}">galeria</a></li>
                <li class="navbar-link-separator">|</li>
                <li><a href="/livro/create">doar livro</a></li>
                <li class="navbar-link-separator">|</li>
                <li><a href="#">sobre nós</a></li>
                <li class="navbar-link-separator">|</li>
                <li><a href="{{asset('login')}}">{{ Auth::check() ? Auth::user()->nome : "entrar" }}</a></li>
            </ul>
        </div>
    </div>
</nav>
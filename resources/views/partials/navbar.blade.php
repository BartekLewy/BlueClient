<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">BlueClient</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item @if(Request::url() == route('panel')) active @endif">
                <a class="nav-link" href="{{route('panel')}}">Home</a>
            </li>
            <li class="nav-item @if(Request::url() == route('panel-item-create'))active @endif">
                <a class="nav-link" href="{{route('panel-item-create')}}">Create</a>
            </li>
        </ul>
    </div>
</nav>
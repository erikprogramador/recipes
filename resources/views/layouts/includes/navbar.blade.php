<nav>
    <div class="nav-wrapper">
        <div class="container">
            <a href="/" class="brand-logo">Recipes</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="/">Home</a></li>
                @unless (auth()->check())
                    <li><a href="/login">Login</a></li>
                    <li><a href="/legister">Register</a></li>
                @endunless
                @if (auth()->check())
                    <li><a href="/recipe/create">Create Recipe</a></li>
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1">{{ auth()->user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                @endif
            </ul>
        </div>
    </div>
</nav>

<nav>
    <div class="nav-wrapper">
        <div class="container">
            <a href="/" class="brand-logo">Recipes</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="/">Home</a></li>
                @unless (auth()->check())
                    <li><a href="/login">Login</a></li>
                    <li><a href="/register">Register</a></li>
                @endunless
                @if (auth()->check())
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown2">Categories<i class="material-icons right">arrow_drop_down</i></a></li>
                    <ul id="dropdown2" class="dropdown-content">
                        @foreach ($categories as $category)
                            <li><a href="/recipe/category/{{ $category->slug }}">{{ $category->title }}</a></li>
                        @endforeach
                    </ul>
                    <li><a href="/category/create">Create Category</a></li>
                    <li><a href="/recipe/create">Create Recipe</a></li>
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1">{{ auth()->user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
                    <ul id="dropdown1" class="dropdown-content">
                        <form action="/logout" method="POST">
                            {{ csrf_field() }}
                            <li>
                                <button type="submit">Logout</button>
                            </li>
                        </form>
                    </ul>
                @endif
            </ul>
        </div>
    </div>
</nav>

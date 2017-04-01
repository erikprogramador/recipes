<div class="card horizontal">
    <div class="card-image">
        <img src="{{ $recipe->cover }}">
    </div>
    <div class="card-stacked">
        <div class="card-content">
            <h4 class="card-title activator grey-text text-darken-4">{{ $recipe->title }}</h4>
            @foreach ($recipe->categories as $category)
                <span class="new badge">{{ $category->title }}</span>
            @endforeach
            <br>
            <p>{{ $recipe->description }}</p>
        </div>
        <div class="card-action">
            <div class="row">
                <div class="col s8">
                    <a href="/recipe/{{ $recipe->id }}">Read recipe...</a>
                </div>
                @if ($recipe->isOwner())
                    <div class="col s2">
                        <a class="btn blue" href="/recipe/{{ $recipe->id }}/update">Edit</a>
                    </div>
                    <div class="col s2">
                        <form action="/recipe/{{ $recipe->id }}/delete" method="POST">
                            <button class="btn red" type="submit">Delete</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card horizontal">
    <div class="card-image">
        <img src="{{ $recipe->cover }}">
    </div>
    <div class="card-stacked">
        <div class="card-content">
            <h4 class="card-title activator grey-text text-darken-4">{{ $recipe->title }}</h4>
            <p>{{ $recipe->description }}</p>
        </div>
        <div class="card-action">
            <a href="/recipe/{{ $recipe->id }}">Read recipe...</a>
        </div>
    </div>
</div>

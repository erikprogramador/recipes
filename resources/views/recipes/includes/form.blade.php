{{ csrf_field() }}
<div>
    <select name="category_id[]" id="category_id" multiple required style="display: block;">
        <option value="" disabled selected>Choose categories</option>
        {{-- TODO: Move this to the view --}}
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ isset($recipe) ? $recipe->categoryIsSelected($category) : '' }}>{{ $category->title }}</option>
        @endforeach
    </select>
    {{-- <label for="category_id">Select categories</label> --}}
</div>

<div class="input-field">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" placeholder="Title" value="{{ old('title') }}{{ $recipe->title ?? null }}">
</div>

<div class="input-field">
    <label for="description">Description:</label>
    <textarea name="description" id="description" class="materialize-textarea" rows="10" placeholder="Description">{{ $recipe->description ?? null }}{{ old('description') }}</textarea>
</div>

<div class="input-field">
    <label for="ingredients">Ingredients:</label>
    <input type="text" name="ingredients[]" id="ingredients" placeholder="Ingredients" value="{{ $recipe->ingredients[0]->name ?? null }}">
</div>

<div class="input-field">
    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity[]" id="quantity" placeholder="Quantity" value="{{ $recipe->ingredients[0]->quantity ?? null }}">
</div>

<div class="input-field">
    <label for="ingredients">Ingredients:</label>
    <input type="text" name="ingredients[]" id="ingredients" placeholder="Ingredients" value="{{ $recipe->ingredients[1]->name ?? null }}">
</div>

<div class="input-field">
    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity[]" id="quantity" placeholder="Quantity" value="{{ $recipe->ingredients[1]->quantity ?? null }}">
</div>

<div class="input-field">
    <label for="ingredients">Ingredients:</label>
    <input type="text" name="ingredients[]" id="ingredients" placeholder="Ingredients" value="{{ $recipe->ingredients[2]->name ?? null }}">
</div>

<div class="input-field">
    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity[]" id="quantity" placeholder="Quantity" value="{{ $recipe->ingredients[2]->quantity ?? null }}">
</div>

<div class="input-field">
    <label for="cover">Cover:</label>
    <input type="text" name="cover" id="cover" placeholder="Put the link to the recipe cover" value="{{ $recipe->cover ?? null }}{{ old('cover') }}">
</div>

<div>
    <input type="checkbox" name="featured" id="featured" {{ isset($recipe) ? $recipe->checked() : null }}>
    <label for="featured">Featured</label>
</div>

<div class="center">
    <button class="btn-floating btn-large waves-effect waves-light red" type="submit">Save</button>
</div>

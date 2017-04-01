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
    <input type="text" name="ingredients[]" id="ingredients" placeholder="Ingredients" value="">
</div>

<div class="input-field">
    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity[]" id="quantity" placeholder="Quantity" value="">
</div>

<div class="input-field">
    <label for="ingredients">Ingredients:</label>
    <input type="text" name="ingredients[]" id="ingredients" placeholder="Ingredients" value="">
</div>

<div class="input-field">
    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity[]" id="quantity" placeholder="Quantity" value="">
</div>

<div class="input-field">
    <label for="ingredients">Ingredients:</label>
    <input type="text" name="ingredients[]" id="ingredients" placeholder="Ingredients" value="">
</div>

<div class="input-field">
    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity[]" id="quantity" placeholder="Quantity" value="">
</div>

<div>
    <input type="checkbox" name="featured" id="featured" {{ isset($recipe) ? $recipe->checked() : null }}>
    <label for="featured">Featured</label>
</div>

<div class="file-container">
    <label for="cover" class="waves-effect waves-light btn red">
        Select a cover {{ $recipe->cover ?? null }}
    </label>
    <input type="file" name="cover" id="cover" class="file-input" value="{{ $recipe->cover ?? null }}">
</div>

<div class="center">
    <button class="btn-floating btn-large waves-effect waves-light red" type="submit">Save</button>
</div>

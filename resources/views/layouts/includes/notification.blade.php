@if (isset($message))
    <div class="container">
        <div class="alert">
            <p>{{ $message }}</p>
        </div>
    </div>
@endif

@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="container">
            <div class="alert">
                <p>{{ $error }}</p>
            </div>
        </div>
    @endforeach
@endif

@if(count($errors)>0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-primary margin-top-10px" role="alert">
            {{ $error }}</div>
    @endforeach
@endif
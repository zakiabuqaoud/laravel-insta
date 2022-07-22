@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <p>{{ $error }}
    @endforeach
</div>
@endif
<div class="form-group">
    <label for="">Post</label>
    <textarea name="content" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content) }}</textarea>
    @error('content')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <label for="">Image</label>
    <input type="file" name="media" class="form-control @error('media') is-invalid @enderror">
    @error('media')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<button type="submit" class="btn btn-primary">Save</button>

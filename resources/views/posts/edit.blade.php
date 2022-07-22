<x-front-layout>

<h3>Edit Post</h3>

<form action="{{ route('posts.update', [$post->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    @include('posts._form')
</form>

</x-front-layout>
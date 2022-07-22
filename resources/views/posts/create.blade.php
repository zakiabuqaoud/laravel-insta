<x-front-layout>

<h3>Create Post</h3>

<form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('posts._form', [
        'post' => new App\Models\Post(),
    ])
</form>

</x-front-layout>
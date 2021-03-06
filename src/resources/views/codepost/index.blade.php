@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif


                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Create Post</a>
                    <a href="{{ route('admin.posts.deleted') }}" class="btn btn-dark btn-sm">Deleted Posts</a>

                    <br>
                    <br>
                    <hr>

                    <h4>Posts</h4>


                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-outline-info">Show post</a>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-outline-primary">Edit post</a>
                                    {!! Form::model($post, ['route' => ['admin.posts.destroy', $post->id], 'method' => 'delete', 'style' => 'display: inline;']) !!}
                                        {!! Form::submit('Delete post', ['class' => 'btn btn-outline-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

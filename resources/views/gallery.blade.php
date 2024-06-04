@extends('layouts.app')

@section('content')
<div class="container">
    @if ($images->isEmpty())
        <p>You have no images uploaded yet.</p>
        <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                @if (Route::has('home'))
                    <a class="btn btn-link" href="{{ route('home') }}">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Upload') }}
                        </button>
                    </a>
                @endif
            </div>
        </div>
    @else
        <div class="row">
            @foreach ($images as $image)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="{{ route('image.show', $image->id) }}" class="card-img-top" alt="{{ $image->filename }}">
                        <div class="card-body">
                            <form action="{{ route('image.delete', $image->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
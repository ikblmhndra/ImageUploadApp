@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image">
                    <button type="submit">Upload</button>
                </form>  
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                                                     
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            @if (Route::has('image.gallery'))
                                <a class="btn btn-link" href="{{ route('image.gallery') }}">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Gallery') }}
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Fileupload') }}</div>
                    <div class="card-body">
                        <form action="{{ route('fileupload_store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            Select image to upload:<br>
                            <input type="file" name="path" id="path"><br><br>
                            <input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-between flex-wrap">

            @foreach ($files as $file)
                <figure class="figure mx-1">
                    <img width="200" class="img-thumbnail figure-img img-fluid rounded" src="{{ asset('storage/' . $file->path) }}">
                    <figcaption class="figure-caption">A caption for the above image.</figcaption>
                </figure>
            @endforeach

            </div>
        </div>
    @endsection

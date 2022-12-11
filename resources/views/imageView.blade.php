@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Image Type</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($images as $image)


                            <tr>
                                <th scope="row">1</th>
                                <td>
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($image->image_url) }}" alt="" class="img-fluid" width="200" height="200">
                                </td>
                                <td>{{ str_replace('_',' ',$image->image_type) }}</td>
                                <td>
                                    <a href="{{ route('delete.image',['id'=>$image->id]) }}" class="btn btn-danger">Delete</a>
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

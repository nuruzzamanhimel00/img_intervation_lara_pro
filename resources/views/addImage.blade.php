@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form method="post" action="{{ route('images.store') }}"
                            enctype="multipart/form-data">
                        @csrf
                        <div class="image">
                            <label><h4>Add image</h4></label>
                            <input type="file" class="form-control" required name="image" accept="image/*">
                        </div>

                        <div class="mt-2">
                            <label><h4> image Type</h4></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="image_type" id="exampleRadios1" value="{{ \App\Models\Images::BACKUP_IMAGE }}" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                 {{ str_replace('_',' ',\App\Models\Images::BACKUP_IMAGE) }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="image_type" id="exampleRadios1" value="{{ \App\Models\Images::BLUR_IMAGE }}" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                 {{ str_replace('_',' ',\App\Models\Images::BLUR_IMAGE) }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="image_type" id="exampleRadios1" value="{{ \App\Models\Images::BRIGHTNESS_IMAGE }}" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                 {{ str_replace('_',' ',\App\Models\Images::BRIGHTNESS_IMAGE) }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="image_type" id="exampleRadios1" value="{{ \App\Models\Images::CIRCLE_IMAGE }}" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                 {{ str_replace('_',' ',\App\Models\Images::CIRCLE_IMAGE) }}
                                </label>
                            </div>

                        </div>

                        <div class="post_button">
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

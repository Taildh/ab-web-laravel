@extends('layouts.main')

@section('breadcrumb')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Banner</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Banner</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="post" action="{{ route('banner.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề"
                                   value="{{ $banner->title }}">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="short_desc">Tiêu đề phụ</label>
                            <input type="text" class="form-control" id="short_desc" name="short_desc"
                                   placeholder="Nhập tiêu đề phụ" value="{{ old('short_desc', $banner->short_desc) }}">
                            @error('short_desc')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Banner</label>
                            <input type="file" id="formFile" name="image" onchange="previewImage(event)">
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="mt-3">
                                <img src="{{ asset('storage/') . '/' .$banner->image }}" alt="" id="preview" class="img-fluid" style="height: 300px">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bannerMobile" class="form-label">Banner mobile</label>
                            <input type="file" id="bannerMobile" name="image_mobile" onchange="previewImageMobile(event)">
                            @error('image_mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="mt-3">
                                <img src="{{ asset('storage/') . '/' .$banner->image_mobile }}" alt="" id="preview-mobile" class="img-fluid" style="height: 300px">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="button" class="btn btn-default">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.classList.hide('show');
            });
        });

        function previewImage(event) {
            var preview = document.getElementById('preview');
            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewImageMobile(event) {
            var preview = document.getElementById('preview-mobile');
            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection

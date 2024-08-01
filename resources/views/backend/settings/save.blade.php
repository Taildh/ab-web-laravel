@extends('layouts.main')

@section('breadcrumb')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Thiết lập</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Thiết lập</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <form method="post" action="{{ route('settings.save') }}" enctype="multipart/form-data">
        @csrf
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
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Giới thiệu</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Nội dung</label>
                            <textarea class="form-control" rows="5"
                                      name="introduce_text">{{ $setting->introduce_text }}</textarea>

                            @error('introduce_text')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Hình ảnh</label>
                            <input type="file" id="formFile" name="introduce_image" onchange="previewImage(event)">
                            @error('introduce_image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="mt-3">
                                <img src="{{ asset('storage/') . '/' .$setting->introduce_image }}" alt=""
                                     id="preview" class="img-fluid" style="height: 300px">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Liên hệ</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Link facebook</label>
                            <input class="form-control" name="facebook_url" value="{{ $setting->facebook_url }}"/>
                            @error('facebook_url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Link instagram</label>
                            <input class="form-control" name="instagram_url" value="{{ $setting->instagram_url }}"/>

                            @error('instagram_url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Địa chỉ email</label>
                            <input class="form-control" name="email" value="{{ $setting->email }}"/>

                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Số điện thoại</label>
                            <input class="form-control" name="phone_number" value="{{ $setting->phone_number }}"/>

                            @error('phone_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Địa chỉ</label>
                            <input class="form-control" name="address" value="{{ $setting->address }}"/>

                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Đối tác</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="formFilePartner" class="form-label">Hình ảnh</label>
                            <input type="file" id="formFilePartner" name="partner_image" onchange="previewImagePartner(event)">
                            @error('partner_image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="mt-3">
                                <img src="{{ asset('storage/') . '/' .$setting->partner_image }}" alt=""
                                     id="preview_partner_image" class="img-fluid" style="height: 300px">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-default">Hủy</button>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </form>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                alert.classList.hide('show');
            });
        });

        function previewImage(event) {
            var preview = document.getElementById('preview');
            var reader = new FileReader();
            reader.onload = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewImagePartner(event) {
            var preview = document.getElementById('preview_partner_image');
            var reader = new FileReader();
            reader.onload = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection

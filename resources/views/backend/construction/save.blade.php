@extends('layouts.main')

@section('style')
    <style>
        .image-container {
            display: flex;
            margin: 10px 0;
            align-items: center;
            gap: 10px;
        }

        .remove-existing-image {

        }

        .btn-danger {
            width: 20px;
            height: 20px;
            font-size: 12px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .construct-image {
            width: 50%;
            height: 200px;
            object-fit: contain;
        }

        .alert {
            display: none;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Thêm mới công trình</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('construction.index') }}">Danh sách công trình</a>
                </li>
                <li class="breadcrumb-item active">Thêm mới công trình</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <form method="post" id="construction-form" action="{{ route('construction.save', ['id' => $construction->id]) }}" onsubmit="submit(e)"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề"
                                   value="{{ $construction->title }}">
                            <span class="text-danger" id="error-title"></span>
                        </div>
                        <div class="form-group">
                            <label for="area">Diện tích</label>
                            <input type="text" class="form-control" id="area" name="area"
                                   placeholder="Nhập diện tích"
                                   value="{{ old('area', $construction->area) }}">
                            <span class="text-danger" id="error-area"></span>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter ...">{{ $construction->description }}</textarea>
                            <span class="text-danger" id="error-description"></span>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <input type="file" name="images[]" multiple id="new-images">
                        <div id="new-image-previews"></div>

                        <div id="existing-images" class="mt-2">
                            @foreach ($construction->images as $image)
                                <div class="image-container" data-id="{{ $image->id }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="construct-image">
                                    <button type="button" class="btn btn-danger remove-existing-image" data-id="{{ $image->id }}"><i class="fas fa-trash"></i></button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-default">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')

    <script>
        const uploadForm = document.getElementById('construction-form');
        const hiddenInputsFile = document.getElementById('hiddenInputsFile');
        const previewContainer = document.getElementById('new-image-previews');
        let allFiles = [];

        document.getElementById('new-images').addEventListener('change', function (event) {
            const files = event.target.files;
            const fileArray = Array.from(files)
            allFiles.unshift(...fileArray);

            updatePreviewImages(allFiles)
            updatehiddenInputsFile(allFiles);

        });

        document.querySelectorAll('.remove-existing-image').forEach(button => {
            button.addEventListener('click', function () {
                const imageId = this.dataset.id;
                const container = this.parentElement;

                let removeInput = document.querySelector('input[name="remove_images[]"][value="' + imageId + '"]');
                if (!removeInput) {
                    removeInput = document.createElement('input');
                    removeInput.type = 'hidden';
                    removeInput.name = 'remove_images[]';
                    removeInput.value = imageId;
                    document.getElementById('construction-form').appendChild(removeInput);
                }

                container.remove();
            });
        });

        function removeNewFile(index) {
            const input = document.getElementById('new-images');
            const dataTransfer = new DataTransfer();
            const files = Array.from(input.files);
            allFiles.splice(index, 1);

            updatePreviewImages(allFiles)
        }

        function updatePreviewImages(allFiles) {
            previewContainer.innerHTML = '';

            allFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.classList.add('construct-image')
                    img.src = e.target.result;

                    const removeButton = document.createElement('button');
                    removeButton.innerHTML = '<i class="fas fa-trash"></i>';
                    removeButton.classList.add('btn', 'btn-danger');
                    removeButton.onclick = function () {
                        img.remove();
                        removeButton.remove();
                        removeNewFile(index);
                    };

                    const wrapper = document.createElement('div');
                    wrapper.classList.add('image-container');
                    wrapper.appendChild(img);
                    wrapper.appendChild(removeButton);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }

        function updatehiddenInputsFile(allFiles) {
            hiddenInputsFile.innerHTML = '';
            allFiles.forEach((file, index) => {
                const fileInputElement = document.createElement('input');
                fileInputElement.type = 'hidden';
                fileInputElement.name = 'images[]';
                fileInputElement.value = file.name;  // File names to keep trac

                uploadForm.appendChild(fileInputElement);
            });
        }

        uploadForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('title', $('#title').val());
            formData.append('area', $('#area').val());
            formData.append('description', $('#description').val());

            $('input[name="remove_images[]"]').each(function() {
                formData.append('remove_images[]', $(this).val());
            });

            allFiles.forEach(file => {
                formData.append('images[]', file);
            });

            $.ajax({
                url: $("#construction-form").attr('action'),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    sessionStorage.setItem('successMessage', response.message);
                    window.location.href = '/constructions';
                },
                error: function(error) {
                    if (error.status === 422) {
                        Object.keys(error.responseJSON.errors).forEach(function (field) {
                            $(`#error-${field}`).show();
                            $(`#error-${field}`).text(error.responseJSON.errors[field]);
                        })
                    }

                    sessionStorage.setItem('errorMessage', error.message);
                }
            });
        })
    </script>

@endsection

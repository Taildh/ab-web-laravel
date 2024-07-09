@extends('layouts.main')

@section('style')
    <style>
        .image-container {
            display: flex;
            margin: 10px 0;
        }

        .remove-existing-image {
            width: 30px;
            height: 30px;
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
            box-shadow: ;
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
    <form method="post" id="construction-form" action="{{ route('construction.save', ['id' => $construction->id]) }}" enctype="multipart/form-data">
        @csrf
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

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề"
                                   value="{{ $construction->title }}">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="area">Diện tích</label>
                            <input type="text" class="form-control" id="area" name="area"
                                   placeholder="Nhập diện tích"
                                   value="{{ old('area', $construction->area) }}">
                            @error('area')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" name="description" rows="5" placeholder="Enter ...">{{ $construction->description }}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <input type="file" name="images[]" multiple id="new-images">

                        <div id="existing-images" class="mt-2">
                            @foreach ($construction->images as $image)
                                <div class="image-container" data-id="{{ $image->id }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="construct-image">
                                    <button type="button" class="btn btn-danger remove-existing-image" data-id="{{ $image->id }}"><i class="fas fa-trash"></i></button>
                                </div>
                            @endforeach
                        </div>

                        <div id="new-image-previews"></div>
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
        document.getElementById('new-images').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('new-image-previews');
            previewContainer.innerHTML = ''; // Clear existing previews

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.classList.add('construct-image')
                    img.src = e.target.result;

                    const removeButton = document.createElement('button');
                    removeButton.innerHTML = '<i class="fas fa-trash"></i>';
                    removeButton.classList.add('btn', 'btn-danger');
                    removeButton.style.marginLeft = '10px';
                    removeButton.onclick = function() {
                        img.remove();
                        removeButton.remove();
                        removeNewFile(index);
                    };

                    const wrapper = document.createElement('div');
                    wrapper.appendChild(img);
                    wrapper.appendChild(removeButton);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });

        document.querySelectorAll('.remove-existing-image').forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.dataset.id;
                const container = this.parentElement;

                // Add the image ID to a hidden input for removal
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

            files.splice(index, 1);
            files.forEach(file => {
                dataTransfer.items.add(file);
            });

            input.files = dataTransfer.files;
        }
    </script>

@endsection

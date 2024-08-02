@extends('layouts.main')

@section('style')
    <style>
        .alert {
            display: none;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Công trình</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Công trình</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="col-12">
        <div class="alert alert-success">
        </div>
        <div class="alert alert-danger">
        </div>
        <div class="card">
            <div class="card-header ">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Danh sách công trình</h3>
                    <a class="btn btn-success d-block" href="{{ route('construction.create') }}">
                        <i class="fa fa-plus"> Thêm mới công trình</i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Diện tích</th>
                        <th>Mô tả</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($constructions as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->area }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->description, 100) }}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-primary mx-1"
                                       href="{{ route('construction.edit', ['id' => $item->id]) }}">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <form action="{{ route('construction.destroy', ['id' => $item->id]) }}"
                                          id="{{ 'delete-form-' . $item->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger mx-1" type="button"
                                                onclick="confirmDelete({{ $item->id }})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    </div>
@endsection

@section('js')
    <script>
        function confirmDelete(itemId) {
            if (confirm('Bạn có muốn xóa công trình này không?')) {
                document.getElementById('delete-form-' + itemId).submit();
            }
        }
    </script>
    <script>
        $(function () {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

        });

        $(document).ready(function () {
            const successMessage = sessionStorage.getItem('successMessage');
            const errorMessage = sessionStorage.getItem('errorMessage');
            console.log(successMessage);
            if (successMessage) {
                $(".alert-success").show();
                $('.alert-success').text(successMessage);
                sessionStorage.removeItem('successMessage');
            }

            if (errorMessage) {
                $(".alert-danger").show();
                $('.alert-danger').text(successMessage);
                sessionStorage.removeItem('errorMessage');
            }
        });
    </script>
@endsection

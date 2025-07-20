@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout top-spacing">
            <div class="page-title">
            <h3>Create Role</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <form action="{{ route('store.roles') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="display_name">Display Name</label>
                            <input type="text" name="display_name" class="form-control">
                        </div>
                        <div class="form-group mb-4">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="permissions">Permissions</label>
                            <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-success" onclick="checkAllPermissions()">
                                <i class="fas fa-check-square"></i> Check All
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="clearAllPermissions()">
                                <i class="fas fa-square"></i> Clear All
                            </button>
                        </div>
                        @foreach ($permissions as $model => $modelPermissions)
                        <div class="card mb-3 col-md-8">
                            <div class="card-header">
                                {{ ucfirst($model) }} Permissions
                            </div>
                            <div class="card-body">
                                @foreach ($modelPermissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="form-check-input permission-checkbox">
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function checkAllPermissions() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function clearAllPermissions() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    </script>
@endsection

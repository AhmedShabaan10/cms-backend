@extends('layouts.app')


@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Create User</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('store.user') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" placeholder="Enter Name" class="form-control"
                            value="{{ old('name') }}"
                            required="">
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                            value="{{ old('email') }}">
                    </div>

                    <div class="form-group mb-4">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <div class="form-group mb-4">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter password Again">
                    </div>

                    <div class="form-group mb-4">
                        <label for="is_active">Is Active:</label>
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                            {{ old('is_active') ? 'checked' : '' }}>
                    </div>

                    <div class="form-group mb-4">
                        <label for="role">Role:</label>
                        <select class="form-control" id="role" name="role" class="form-control"
                            placeholder="Select a role..." autocomplete="off">
                            @foreach ($roles as $role)
                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('src/plugins/src/tomSelect/tom-select.base.js') }}"></script>
    <script src="{{ asset('src/plugins/src/tomSelect/custom-tom-select.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new TomSelect("#category-select", {
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
            });
        });
    </script>

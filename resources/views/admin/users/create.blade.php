<x-layout-hub>
    <div class="card">
        <h4 class="card-header">Add New User</h4>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i>
                    Back</a>
            </div>
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label"><strong>Username:</strong></label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                        id="username" placeholder="Username" value="{{ old('username', '') }}">
                    @error('username')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="user-roles" class="form-label"><strong>Roles:</strong></label>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card acard h-100">
                                <div class="card-body">
                                    @foreach ($roles as $role)
                                        <div class="mb-1">
                                            <label>
                                                <input type="checkbox" class="input-lg bgc-blue" name="user-roles[]"
                                                    {{ (is_array(old('user-roles')) and in_array($role->id, old('user-roles'))) ? ' checked' : '' }}
                                                    value="{{ $role->id }}" />
                                                {{ $role->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('user-roles')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>
                    Submit</button>
            </form>
        </div>
    </div>
</x-layout-hub>

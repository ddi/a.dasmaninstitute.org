<x-layout-hub>
    <div class="card">
        <h4 class="card-header">Add New Hub Link</h4>
        <div class="card-body">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-primary btn-sm" href="{{ route('hublinks.index') }}"><i class="fa fa-arrow-left"></i>
                    Back</a>
            </div>

            <form action="{{ route('hublinks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="inputName" class="form-label"><strong>Title:</strong></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        id="inputName" placeholder="Title" value="{{ old('title') }}">
                    @error('title')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label"><strong>Description:</strong></label>
                    <input type="text" name="description"
                        class="form-control @error('description') is-invalid @enderror" id="description"
                        placeholder="Description" value="{{ old('description') }}">
                    @error('description')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label"><strong>Order:</strong></label>
                    <input type="text" name="order" class="form-control @error('order') is-invalid @enderror"
                        id="order" placeholder="Order" value="{{ old('order') }}">
                    @error('Order')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputName" class="form-label"><strong>URL:</strong></label>
                    <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
                        id="inputName" placeholder="URL" value="{{ old('url') }}">

                    @error('url')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputName" class="form-label"><strong>Icon:</strong></label>
                    <input type="file" name="icon" class="form-control @error('icon') is-invalid @enderror">

                    @error('icon')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
            </form>

        </div>
    </div>
</x-layout-hub>

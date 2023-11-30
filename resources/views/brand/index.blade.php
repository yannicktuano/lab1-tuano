<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Brands
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-md-8">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="card bg-white rounded">
                        <div class="card-header bg-warning text-white">
                            All Brands
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Brand Name</th>
                                            <th scope="col">Brand Image</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($brands as $brand)
                                        <tr>
                                            <th scope="row">{{ $i++ }}</th>
                                            <td>{{ $brand->brand_name }}</td>
                                            <td><img src="{{ asset($brand->brand_image) }}" alt="Brand Image"
                                                    style="max-width: 70px; max-height: 40px"></td>
                                            <td>{{ $brand->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ url('brand/edit/'.$brand->id) }}"
                                                    class="btn btn-info">Update</a>
                                                <a href="{{ url('brand/remove/'.$brand->id) }}"
                                                    class="btn btn-danger">Remove</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light rounded">
                            {{ $brands->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-white rounded">
                        <div class="card-header bg-info text-white">
                            Add Brands
                        </div>
                        <div class="card-body">
                            <form action="{{ route('add.brand') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="brand_name" class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" name="brand_name">
                                    @error('brand_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="brand_image" class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" name="brand_image">
                                    @error('brand_image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-4">
                <div class="card bg-white rounded">
                    <div class="card-header bg-dark text-white">
                        Deleted List
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Brand Name</th>
                                        <th scope="col">Brand Image</th>
                                        <th scope="col">Deleted At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($trashCat as $trash)
                                    <tr>
                                        <th scope="row">{{ $brands->firstItem() + $loop->index }}</th>
                                        <td>{{ $trash->brand_name }}</td>
                                        <td>
                                            @if ($trash->brand_image)
                                            <img src="{{ asset($trash->brand_image) }}" alt="Brand Image"
                                                style="max-width: 70px; max-height: 40px">
                                            @else
                                            No Image
                                            @endif
                                        </td>
                                        <td>{{ $trash->deleted_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('brand/restore/'.$trash->id) }}"
                                                class="btn btn-info">Restore</a>
                                            <a href="{{ url('brand/delete/'.$trash->id) }}"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light rounded">
                        {{ $trashCat->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

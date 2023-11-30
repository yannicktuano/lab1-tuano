<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Category
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
                        <div class="card-header bg-primary text-white">
                            Added List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Category Name</th>
                                            <th scope="col">User Id</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($categories as $category)
                                        <tr>
                                            <th scope="row">{{ $categories->firstItem() + $loop->index }}</th>
                                            <td>{{ $category->category_name }}</td>
                                            <td>{{ $category->user_id }}</td>
                                            <td>{{ $category->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ url('category/edit/'.$category->id) }}"
                                                    class="btn btn-info btn-sm">Update</a>
                                                <a href="{{ url('category/remove/'.$category->id) }}"
                                                    class="btn btn-danger btn-sm">Remove</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light rounded">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-white rounded">
                        <form action="{{ route('add.category') }}" method="POST">
                            @csrf
                            <div class="card-header bg-success text-white">
                                Add Category
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name">
                                    @error('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- List of Deleted Items -->
            <div class="col-md-8 mt-4">
                <div class="card bg-white rounded">
                    <div class="card-header bg-danger text-white">
                        Deleted List
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">User Id</th>
                                        <th scope="col">Deleted At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($trashCat as $trash)
                                    <tr>
                                        <th scope="row">{{ $trashCat->firstItem() + $loop->index }}</th>
                                        <td>{{ $trash->category_name }}</td>
                                        <td>{{ $trash->user_id }}</td>
                                        <td>{{ $trash->deleted_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('category/restore/'.$trash->id) }}"
                                                class="btn btn-info btn-sm">Restore</a>
                                            <a href="{{ url('category/delete/'.$trash->id) }}"
                                                class="btn btn-danger btn-sm">Delete</a>
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

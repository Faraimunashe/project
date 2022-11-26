<x-app-layout>
    <div class="pagetitle">
        <h1>Employees</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Employees</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-md-12">

                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h5 class="card-title">Employees</h5>
                                    </div>
                                    <div class="col-md-2 mt-3 justify-end">
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#largeModal">Add New</button>
                                    </div>
                                </div>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Fullname</th>
                                            <th scope="col">National ID</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Projects</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($employees as $item)
                                            <tr>
                                                <th scope="row">
                                                    <a href="#">
                                                        @php
                                                            $count++;
                                                            echo $count;
                                                        @endphp
                                                    </a>
                                                </th>
                                                <td>{{ $item->fname }} {{ $item->lname }}</td>
                                                <td>{{ $item->natid }}</td>
                                                <td>{{ $item->sex }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ \App\Models\Project::where('assigned_to', $item->id)->count() }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Change</button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#smallModal{{ $item->id }}">Remove</button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="smallModal{{ $item->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('admin-delete-employee') }}">
                                                            @csrf
                                                            <input type="hidden" name="employee_id" value="{{ $item->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Employee</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete {{ $item->fname }} {{ $item->lname }} from employees?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">Yes delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Delete Modal-->
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('admin-update-employee') }}">
                                                            @csrf
                                                            <input type="hidden" name="employee_id" value="{{ $item->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Project</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{-- <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Employee: </label>
                                                                    <div class="col-sm-10">
                                                                        <select name="employee_id" class="form-control" required>
                                                                            <option selected disabled>Assign Employee</option>
                                                                            @foreach (\App\Models\Employee::all() as $emp)
                                                                                <option value="{{$emp->id}}">{{$emp->fname}} {{$emp->lname}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div> --}}
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Fullname: </label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" name="fname" class="form-control" value="{{ $item->fname }}" required>
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" name="lname" class="form-control" value="{{ $item->lname }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Natid: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="natid" class="form-control" value="{{ $item->natid }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Gender: </label>
                                                                    <div class="col-sm-10">
                                                                        <select name="sex" class="form-control" required>
                                                                            <option selected value="{{$item->sex}}">{{$item->sex}}</option>
                                                                            <option value="Male">Male</option>
                                                                            <option value="Female">Female</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Phone: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="phone" class="form-control" value="{{ $item->phone }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Address: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="address" class="form-control" value="{{ $item->address }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Edit Modal-->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
    <div class="modal fade" id="largeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin-add-employee') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Fullname: </label>
                            <div class="col-sm-5">
                                <input type="text" name="fname" class="form-control" required>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="lname" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Natid: </label>
                            <div class="col-sm-10">
                                <input type="text" name="natid" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Gender: </label>
                            <div class="col-sm-10">
                                <select name="sex" class="form-control" required>
                                    <option selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Phone: </label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Address: </label>
                            <div class="col-sm-10">
                                <input type="text" name="address" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->
</x-app-layout>

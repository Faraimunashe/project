<x-app-layout>
    <div class="pagetitle">
        <h1>Projects</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Projects</li>
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
                                        <h5 class="card-title">Projects</h5>
                                    </div>
                                    <div class="col-md-2 mt-3 justify-end">
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#largeModal">Add New</button>
                                    </div>
                                </div>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Project</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Assigned To</th>
                                            <th scope="col">Deadline</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($projects as $item)
                                            <tr>
                                                <th scope="row">
                                                    <a href="#">
                                                        @php
                                                            $count++;
                                                            echo $count;
                                                        @endphp
                                                    </a>
                                                </th>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->cost }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ get_employee($item->assigned_to)->fname.' '.get_employee($item->assigned_to)->lname }}</td>
                                                <td>{{ $item->deadline }}</td>
                                                <td>
                                                    <a href="{{route('admin-see-project', $item->id)}}" class="btn btn-dark btn-sm">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#smallModal{{ $item->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="smallModal{{ $item->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('admin-delete-project') }}">
                                                            @csrf
                                                            <input type="hidden" name="project_id" value="{{ $item->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Project</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete {{ $item->name }} from projects?
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
                                                        <form method="POST" action="{{ route('admin-update-project') }}">
                                                            @csrf
                                                            <input type="hidden" name="project_id" value="{{ $item->id }}" required>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Project</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Assign To: </label>
                                                                    <div class="col-sm-10">
                                                                        <select name="project_id" class="form-control" required>
                                                                            <option selected disabled>Assign Employee</option>
                                                                            @foreach (\App\Models\Employee::all() as $emp)
                                                                                <option value="{{$emp->id}}">{{$emp->fname}} {{$emp->lname}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Name: </label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Cost: </label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" name="cost" class="form-control" value="{{ $item->cost }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Description: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" name="description" class="form-control" value="{{ $item->description }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Status: </label>
                                                                    <div class="col-sm-10">
                                                                        <select name="status" class="form-control" required>
                                                                            <option selected value="{{$item->status}}">{{$item->status}}</option>
                                                                            <option value="In Progress">In Progress</option>
                                                                            <option value="Complete">Complete</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Start Date: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="date" name="start_date" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-2 col-form-label">Deadline: </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="date" name="deadline" class="form-control" required>
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
                <form method="POST" action="{{ route('admin-add-project') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Assign To: </label>
                            <div class="col-sm-10">
                                <select name="employee_id" class="form-control" required>
                                    <option selected disabled>Assign Employee</option>
                                    @foreach (\App\Models\Employee::all() as $emp)
                                        <option value="{{$emp->id}}">{{$emp->fname}} {{$emp->lname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Name: </label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Cost: </label>
                            <div class="col-sm-10">
                                <input type="text" name="cost" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Start Date: </label>
                            <div class="col-sm-10">
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Deadline: </label>
                            <div class="col-sm-10">
                                <input type="date" name="deadline" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Description: </label>
                            <div class="col-sm-10">
                                <textarea name="description" class="form-control" rows="4" required>
                                </textarea>
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

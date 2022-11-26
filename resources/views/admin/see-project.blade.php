<x-app-layout>
    <div class="pagetitle">
        <h1>{{$project->name}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Project</li>
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
            <div class="col-xl-12">
                <div class="card">
                  <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">Overview</button>
                      </li>

                      <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" tabindex="-1" role="tab">Requirements</button>
                      </li>

                      <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings" aria-selected="false" tabindex="-1" role="tab">Risks
                      </li>

                      <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" aria-selected="false" tabindex="-1" role="tab">Activities</button>
                      </li>

                    </ul>
                    <div class="tab-content pt-2">

                      <div class="tab-pane fade show active profile-overview" id="profile-overview" role="tabpanel">
                        <h5 class="card-title">{{$project->name}}</h5>
                        <p class="small fst-italic">{{$project->description}}</p>

                        <h5 class="card-title">Project Details</h5>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label ">Cost</div>
                          <div class="col-lg-9 col-md-8">{{$project->cost}}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Status</div>
                          <div class="col-lg-9 col-md-8">{{$project->status}}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Assigned To</div>
                          <div class="col-lg-9 col-md-8">{{get_employee($project->assigned_to)->fname.' '.get_employee($project->assigned_to)->lname}}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Start Date</div>
                          <div class="col-lg-9 col-md-8">{{$project->start_date}}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Deadline</div>
                          <div class="col-lg-9 col-md-8">{{$project->deadline}}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Estimated Hours Required</div>
                          <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                        </div>

                      </div>

                      <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h5 class="card-title">Requirements</h5>
                                </div>
                                <div class="col-md-2 mt-3 justify-end">
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRequirementModal">Add New</button>
                                </div>
                            </div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Requirement</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($requirements as $item)
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
                                            <td>{{ $item->description }}</td>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>

                      <div class="tab-pane fade pt-3" id="profile-settings" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h5 class="card-title">Risks</h5>
                                </div>
                                <div class="col-md-2 mt-3 justify-end">
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRiskModal">Add Risk</button>
                                </div>
                            </div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($risks as $item)
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
                                            <td>{{ $item->description }}</td>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>

                      <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h5 class="card-title">Activities</h5>
                                </div>
                                <div class="col-md-2 mt-3 justify-end">
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addActivityModal">Add Activity</button>
                                </div>
                            </div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Hours</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($activities as $item)
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
                                            <td>{{ $item->hours }}</td>
                                            <td>{{ $item->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>

                    </div><!-- End Bordered Tabs -->

                  </div>
                </div>

            </div>
        </div>
    </section>
    <div class="modal fade" id="addRiskModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin-add-risk') }}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{$project->id}}" required>
                    <div class="modal-header">
                        <h5 class="modal-title">Add Risk To {{$project->name}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Risk: </label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" required>
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
    <div class="modal fade" id="addActivityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin-add-activity') }}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{$project->id}}" required>
                    <div class="modal-header">
                        <h5 class="modal-title">Add Activity To {{$project->name}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Activity: </label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Hours: </label>
                            <div class="col-sm-10">
                                <input type="number" name="hours" class="form-control" required>
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
    <div class="modal fade" id="addRequirementModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin-add-requirement') }}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{$project->id}}" required>
                    <div class="modal-header">
                        <h5 class="modal-title">Add Requirement To {{$project->name}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Requirement: </label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" required>
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

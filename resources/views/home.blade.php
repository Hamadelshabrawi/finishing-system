@extends('layouts.app')

@section('title') Home @endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-12">
    <div class="row align-items-center mb-2">
      <div class="col">
        <h2 class="h5 page-title">Welcome!</h2>
      </div>
      <div class="col-auto">
        <form class="form-inline">
          <div class="form-group d-none d-lg-inline">
            <label for="reportrange" class="sr-only">Date Ranges</label>
            <div id="reportrange" class="px-2 py-2 text-muted">
              <span class="small"></span>
            </div>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
            <button type="button" class="btn btn-sm mr-2"><span class="fe fe-filter fe-16 text-muted"></span></button>
          </div>
        </form>
      </div>
    </div>


    <div class="mb-2 align-items-center">
      <div class="card shadow mb-4">
        <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Projects</h5>
                        <h2 class="text-primary">{{ $stats['total_projects'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <h2 class="text-success">{{ $stats['total_products'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Clients</h5>
                        <h2 class="text-info">{{ $stats['total_clients'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Materials</h5>
                        <h2 class="text-warning">{{ $stats['total_materials'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        </div> <!-- .card-body -->
      </div> <!-- .card -->
    </div>


    <div class="mb-2 align-items-center">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row mt-1 align-items-center">
            <div class="col-12 col-lg-4 text-left pl-4">
              <p class="mb-1 small text-muted">Total Projects</p>
              <span class="h3">{{ $projectStats['total_projects'] }}</span>
              <span class="small text-muted">+{{ $projectStats['active_projects'] }} active</span>
              <span class="fe fe-arrow-up text-success fe-12"></span>
              <p class="text-muted mt-2">Projects in system</p>
            </div>
            <div class="col-6 col-lg-2 text-center py-4">
              <p class="mb-1 small text-muted">Active Projects</p>
              <span class="h3">{{ $projectStats['active_projects'] }}</span><br />
              <span class="small text-muted">{{ $projectStats['technical_pending'] }} pending</span>
              <span class="fe fe-arrow-up text-success fe-12"></span>
            </div>
            <div class="col-6 col-lg-2 text-center py-4 mb-2">
              <p class="mb-1 small text-muted">Completed Projects</p>
              <span class="h3">{{ $projectStats['completed_projects'] }}</span><br />
              <span class="small text-muted">{{ $projectStats['active_projects'] }} active</span>
              <span class="fe fe-arrow-up text-success fe-12"></span>
            </div>
            <div class="col-6 col-lg-2 text-center py-4">
              <p class="mb-1 small text-muted">Pending Approval</p>
              <span class="h3">{{ $projectStats['pending_approval'] }}</span><br />
              <span class="small text-muted">{{ $projectStats['technical_pending'] }} technical</span>
              <span class="fe fe-arrow-up text-success fe-12"></span>
            </div>
            <div class="col-6 col-lg-2 text-center py-4">
              <p class="mb-1 small text-muted">Project Status</p>
              <span class="h3">{{ $projectStatus['approved'] }}</span><br />
              <span class="small text-muted">{{ $projectStatus['pending'] }} pending</span>
              <span class="fe fe-arrow-up text-success fe-12"></span>
            </div>
            <div class="col-6 col-lg-2 text-center py-4">
              <p class="mb-1 small text-muted">Project Completion</p>
              <span class="h3">{{ number_format(($projectStats['completed_projects'] / $projectStats['total_projects']) * 100, 2) }}%</span><br />
              <span class="small text-muted">+{{ number_format(($projectStats['completed_projects'] / $projectStats['total_projects']) * 100, 2) }}%</span>
              <span class="fe fe-arrow-up text-success fe-12"></span>
            </div>
          </div>
        </div> <!-- .card-body -->
      </div> <!-- .card -->
    </div>
    <div class="row items-align-baseline">
        <div class="col-md-12 col-lg-4">
            <div class="card shadow eq-card mb-4">
                <div class="card-body mb-n3">
                    <div class="row items-align-baseline h-100">
                        <div class="col-md-6 my-3">
                            <p class="mb-0"><strong class="mb-0 text-uppercase text-muted">Projects</strong></p>
                            <h3>{{ $stats['total_projects'] }}</h3>
                            <p class="text-muted">Total number of projects in the system</p>
                        </div>
                        <div class="col-md-6 my-4 text-center">
                            <div lass="chart-box mx-4">
                                <div id="radialbarWidgett"></div>
                            </div>
                        </div>
                        <div class="col-md-6 border-top py-3">
                            <p class="mb-1"><strong class="text-muted">Pending Approval</strong></p>
                            <h4 class="mb-0">{{ $projectStats['pending_approval'] }}</h4>
                            <p class="small text-muted mb-0"><span>Projects waiting initial approval</span></p>
                        </div>
                        <div class="col-md-6 border-top py-3">
                            <p class="mb-1"><strong class="text-muted">Technical Pending</strong></p>
                            <h4 class="mb-0">{{ $projectStats['technical_pending'] }}</h4>
                            <p class="small text-muted mb-0"><span>Waiting technical approval</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card shadow eq-card mb-4">
                <div class="card-body">
                    <div class="chart-widget mb-2">
                    </div>
                    <div class="row items-align-center">
                        <div class="col-4 text-center">
                            <p class="text-muted mb-1">Clients</p>
                            <h6 class="mb-1">{{ $stats['total_clients'] }}</h6>
                            <p class="text-muted mb-0">Total clients</p>
                        </div>
                        <div class="col-4 text-center">
                            <p class="text-muted mb-1">Products</p>
                            <h6 class="mb-1">{{ $stats['total_products'] }}</h6>
                            <p class="text-muted mb-0">Total products</p>
                        </div>
                        <div class="col-4 text-center">
                            <p class="text-muted mb-1">Materials</p>
                            <h6 class="mb-1">{{ $stats['total_materials'] }}</h6>
                            <p class="text-muted mb-0">Total materials</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card shadow eq-card mb-4">
                <div class="card-body">
                    <div class="d-flex mt-3 mb-4">
                        <div class="flex-fill pt-2">
                            <p class="mb-0 text-muted">Active Projects</p>
                            <h4 class="mb-0">{{ $projectStats['active_projects'] }}</h4>
                            <span class="small text-muted">Currently in progress</span>
                        </div>
                        <div class="flex-fill chart-box mt-n2">
                        </div>
                    </div>
                    <div class="row border-top">
                        <div class="col-md-6 pt-4">
                            <h6 class="mb-0">{{ $projectStats['completed_projects'] }} <span class="small text-muted">Completed</span></h6>
                            <p class="mb-0 text-muted">Finished projects</p>
                        </div>
                        <div class="col-md-6 pt-4">
                            <h6 class="mb-0">{{ $recentProjects->count() }} <span class="small text-muted">Recent</span></h6>
                            <p class="mb-0 text-muted">Recently added</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </div> <!-- .col-12 -->
</div> <!-- .row -->
@endsection

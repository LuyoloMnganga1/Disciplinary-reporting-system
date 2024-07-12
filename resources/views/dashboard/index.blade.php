@extends('layouts.main')
@section('content')
<!-- Container fluid -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-12">
                    {{-- TOP ROW --}}
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="dashboard-detail-card shadow card mt-1 mb-2 p-2 rounded-0">

                                {{-- FLEX CONTAINER --}}
                                <div class="flex-container">
                                    <div class="icon-div"><i class="fa fa-file"></i></div>
                                    <div><span>Disciplinaries</span></div>
                                </div>
                                {{-- END FLEX CONTAINER --}}
                                <span style="margin-left:1rem;"> Filed Disciplinaries <span style="float:right; color:#000 !important;" class="badge badge-light">20</span></span>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="dashboard-detail-card shadow card mt-1 mb-2 p-2 rounded-0">

                                {{-- FLEX CONTAINER --}}
                                <div class="flex-container">
                                    <div class="icon-div"><i class="fa fa-check"></i></div>
                                    <div><span>Clients</span></div>
                                </div>
                                {{-- END FLEX CONTAINER --}}
                                <span style="margin-left:1rem;"> Total Clients<span style="float:right; color:#000 !important;" class="badge badge-light">56</span></span>

                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="dashboard-detail-card shadow card mt-1 mb-2 p-2 rounded-0">

                                {{-- FLEX CONTAINER --}}
                                <div class="flex-container">
                                    <div class="icon-div"><i class="fa fa-users"></i></div>
                                    <div><span>Employees</span></div>
                                </div>
                                {{-- END FLEX CONTAINER --}}
                                <span style="margin-left:1rem;"> Total employees <span style="float:right; color:#000 !important;" class="badge badge-light">124</span></span>

                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="dashboard-detail-card shadow card mt-1 mb-2 p-2 rounded-0">

                                {{-- FLEX CONTAINE --}}
                                <div class="flex-container">
                                    <div class="icon-div"><i class="fa fa-user"></i></div>
                                    <div><span>Administrators</span></div>
                                </div>
                                {{-- END FLEX CONTAINER --}}

                                <span style="margin-left:1rem;">System administrators <span style="float:right; color:#000 !important;" class="badge badge-light">6</span></span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    {{-- BOTTOM ROW --}}
                    <div class="row d-flex justify-content-center">
                        {{-- START OF CHARTS --}}
                        <div class="col-lg-12">
                            <div class="pt-2">
                                <div class="card shadow rounded-0 p-5">
                                    <div class="card-body">
                                        <h5 class="text-dark text-center">Year to Date</h5>
                                        <div class="chart">
                                            <canvas id="myChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END OF CHARTS --}}
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-2">
                        <div class="filters h-100 dashboard-detail-card shadow card mt-1 mb-2 p-2 rounded-0">
                        <form id="filters-form">
                            @csrf
                            {!! csrf_field() !!}
                            <div class="row">
                            {{-- FLEX CONTAINER --}}
                            <div class="flex-container">
                                <div class="icon-div"><i class="fa fa-filter"></i></div>
                                <div><span style="color: #fff !important;">Filters</span></div>
                            </div>
                            {{-- END FLEX CONTAINER --}}
                        </div>
                            <div class="form-group pb-2">
                                <label for="" class="text-light">Clients</label>
                                <select class="form-control selectpicker" name="client" id="client">
                                    <option selected readonly value="">Select Client<i class="fa fa-caret-down" aria-hidden="true"></i></option>
                                </select>
                            </div>

                            <div class="form-group pb-2">
                                <label for="" class="text-light">Employees</label>
                                <select class="form-control selectpicker" name="client" id="client">
                                    <option selected readonly value="">Select employee<i class="fa fa-caret-down" aria-hidden="true"></i></option>
                                </select>
                            </div>

                            <div class="form-group pb-2">
                                <label for="" class="text-light">Desciplinary Type</label>
                                <select class="form-control selectpicker" name="type" id="type">
                                    <option value="">Select Desciplinary type</option>
                                </select>
                            </div>
                            <div class="form-group pb-2">
                                <label for="" class="text-light">Desciplinary From Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>

                            <div class="form-group pb-2">
                                <label for="" class="text-light">Desciplinary To Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>

                            <div class="form-group my-1 d-grid gap-2">
                                <button id="filters_form_submit" type="submit" class="btn btn-sm btn-dark btn-block">Apply</button>
                            </div>
                        </form>
                    </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Utility function to generate month labels
    const Utils = {
            months: function (config) {
                const cfg = config || {};
                const count = cfg.count || 12;
                const section = cfg.section;
                const values = [];

                for (let i = 0; i < count; ++i) {
                    const value = new Date(1970, i, 1).toLocaleString('en-US', { month: 'short' });
                    values.push(value);
                }

                return values;
            }
        };
    // Use the Utils.months function
    var labels = Utils.months({count: 12});
    console.log(labels);
    var graph_data={
            labels: labels,
            datasets: [{
                label: 'Desciplinary Demographics',
                data: [48, 5, 91, 25, 78,59,9,48, 12, 19, 20, 87],
                backgroundColor: [
                    'rgb(0,0,0, 0.5)',
                    'rgb(0,0,0, 0.6)',
                ],
                borderColor: [
                    'rgb(0,0,0, 0.2)',
                    'rgb(0,0,0, 0.2)',
                ],
                borderWidth: 0
            }]
        }
    const grp = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(grp, {
        type: 'bar',
        data: graph_data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection

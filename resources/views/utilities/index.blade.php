@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @if (session('message'))
            <div class="alert alert-dark">
                {{ session('message') }}
            </div>
            @endif
            <div class="row py-2">
                <div class="card card-rounded-3 p-3">
                    <div class="card-content">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="card p-4 my-2 mx-2 bg-light text-dark">
                                    <h5>Upload Desciplinary Register from Excel file</h5><br>
                                    <a href="" class="btn btn-sm btn-dark">Upload Excel</a>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-4 my-2 mx-2 bg-light text-dark">
                                    <h5>Upload Desciplinary file on PDF format</h5><br>
                                    <a href="" class="btn btn-sm btn-dark">Upload PDF</a>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-4 my-2 mx-2 bg-light text-dark">
                                    <h5>Upload Desciplinary file on Word format</h5><br>
                                    <a href="" class="btn btn-sm btn-dark">Upload Word</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection

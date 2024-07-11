@extends('layouts.main')
@section('content')
<!-- Container fluid -->
<div class="container-fluid col-lg-12">
    <div class="col-lg-12">
        <a href="{{route('audit')}}"  class="btn btn-sm btn-secondary mt-1 mb-1"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back</a>
    </div>
   @foreach ($audit as $item)
   <div class="row card card-rounded shadow-regular my-2 mx-1 py-3 px-1">
    <div class="card-header bg bg-success">
       <h4 class="text-light text-bold"> Audit Information</h4>
    </div>
    <div class="col-lg-12">
        @if (session('message'))
        <div class="alert alert-success  mt-2">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{session('message')}}</strong>
        </div>
        @endif
    </div>
        <div class="row">
            @php
            $user = $item->user_id ? App\Http\Controllers\AuditController::getuser($item->user_id):null;
            @endphp
            <div class="col-lg-4">
                <label for=""> User </label>
                <p class="text-dark" id="user_name">{{$user?$user[0]:null}}</p>
            </div>
            <div class="col-lg-4">
                <label for="">Email </label>
                <p class="text-dark" id="email">{{$user?$user[1]:null}}</p>
            </div>
            <div class="col-lg-4">
                <label for="">Log Type</label>
                <p class="text-dark">
                    @php
                    $color = '';
                        if($item->event == 'deleted'){
                           $color = 'danger';
                        }
                        if($item->event == 'created'){
                           $color = 'success';
                        }
                        if($item->event == 'updated'){
                           $color = 'info';
                        }
                        if($item->event == 'restored'){
                           $color = 'secondary';
                        }
                    @endphp
                    {{$item->auditable_type?substr($item->auditable_type,11):''}} &nbsp;&nbsp; <span class="badge badge-{{$color}}">{{ucfirst($item->event)}}</span></td>
                </p>
            </div>
            <div class="col-lg-4">
                <label for=""> Auditable Type</label>
                <p class="text-dark">{{$item->auditable_type}}</p>
            </div>
            <div class="col-lg-4">
                <label for=""> Old values</label>
                <p class="text-dark">{{$item->old_values}}</p>
            </div>
            <div class="col-lg-4">
                <label for="">New values </label>
                <p class="text-dark">{{$item->new_values}}</p>
            </div>
            <div class="col-lg-4">
                <label for=""> Url</label>
                <p class="text-dark">{{$item->url}}</p>
            </div>
            <div class="col-lg-4">
                <label for=""> Ip Address</label>
                <p class="text-dark">{{$item->ip_address}}</p>
            </div>
            <div class="col-lg-4">
                <label for=""> User Agent</label>
                <p class="text-dark">{{$item->user_agent}}</p>
            </div>
            <div class="col-lg-4">
                <label for=""> Tags</label>
                <p class="text-dark">{{$item->tags}}</p>
            </div>
            <div class="col-lg-4">
                <label for=""> Created At</label>
                <p class="text-dark">{{$item->created_at}}</p>
            </div>
        </div>

     </div>
</div>
   @endforeach
</div>
@endsection
@section('scripts')

@endsection

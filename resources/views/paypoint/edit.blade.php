@extends('layout.master')

@section('title',__('dash.edit_paypoint'))
@section('title_page',__('dash.edit_paypoint'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" id="form">
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="name_ar" class="form-control" placeholder="{{__('dash.name_ar')}}"  value="{{$payPoint->name_ar}}">
                                            <label for="name_ar">{{__('dash.name_ar')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="name_en" class="form-control" placeholder="{{__('dash.name_en')}}"  value="{{$payPoint->name_en}}">
                                            <label for="name_en">{{__('dash.name_en')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="email" class="form-control" placeholder="{{__('dash.email')}}"  value="{{$payPoint->email}}">
                                            <label for="email">{{__('dash.email')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="mobile" class="form-control" placeholder="{{__('dash.mobile')}}"  value="{{$payPoint->mobile}}">
                                            <label for="mobile">{{__('dash.mobile')}}</label>
                                        </div>
                                    </div>




                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <label for="compony_id">{{__('dash.compony')}}</label>

                                            <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" id="compony_id">
                                                <option value="-1">{{__('dash.compony')}}</option>
                                                @foreach ($compony as $c)
                                                    <option value="{{$c->id}}" @selected($c->id == $payPoint->compony_id)>{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <label for="role_id">{{__('dash.role')}}</label>
                                            <select class="select2 form-control select2-hidden-accessible" data-select2-id="2" tabindex="-1" aria-hidden="true" id="role_id">
                                                <option value="-1">{{__('dash.role')}}</option>
                                                @foreach ($roles as $r)
                                                    <option value="{{$r->id}}" @selected($payPoint->hasRole($r))>{{$r->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                   
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" onclick="performUpdate()">{{__('dash.save')}}</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">{{__('dash.reset')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function performUpdate(){
        let name_ar = document.getElementById('name_ar').value;
        let name_en = document.getElementById('name_en').value;
        let email = document.getElementById('email').value;
        let mobile = document.getElementById('mobile').value;
        let compony_id = document.getElementById('compony_id').value;
        let role_id = document.getElementById('role_id').value;

        let dataObj = {
            name_ar : name_ar,
            name_en : name_en,
            email : email,
            mobile : mobile,
            compony_id : compony_id,
            role_id : role_id,
            _method : 'PUT'

        };

  
        performUpdateWithTostar('/pay_points/{{$payPoint->id}}',dataObj);
    }
</script>
@endsection
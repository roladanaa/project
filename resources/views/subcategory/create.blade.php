@extends('layout.master')

@section('title',__('dash.create_subcategory'))
@section('title_page',__('dash.create_subcategory'))

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
                                            <input type="text" id="name_ar" class="form-control" placeholder="{{__('dash.name_ar')}}"  >
                                            <label for="name_ar">{{__('dash.name_ar')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="name_en" class="form-control" placeholder="{{__('dash.name_en')}}"  >
                                            <label for="name_en">{{__('dash.name_en')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="file" id="image" class="form-control" placeholder="{{__('dash.upload_image')}}" required>
                                            <label for="image">{{__('dash.upload_image')}}</label>
                                            <p class="text-muted ml-75 mt-50"><small>JPG,JPGE, GIF or PNG. </small></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <label for="city_id">{{__('dash.city')}}</label>
                                            <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" id="city_id">
                                                <option value="-1">{{__('dash.city')}}</option>
                                                @foreach ($city as $c)
                                                    <option value="{{$c->id}}" >{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <label for="category_id">{{__('dash.category')}}</label>
                                            <select class="select2 form-control select2-hidden-accessible" data-select2-id="2" tabindex="-1" aria-hidden="true" id="category_id">
                                                <option value="-1">{{__('dash.category')}}</option>
                                                @foreach ($category as $c)
                                                    <option value="{{$c->id}}" >{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <div class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                                <p class="mb-0">{{__('dash.active')}}</p>
                                                <input type="checkbox" class="custom-control-input" id="active" required>
                                                <label class="custom-control-label" for="active"></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                   
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light" onclick="performStore()">{{__('dash.save')}}</button>
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
    function performStore(){

            let name_en = document.getElementById('name_en').value;
            let name_ar = document.getElementById('name_ar').value;
            let category_id = document.getElementById('category_id').value;
            let city_id = document.getElementById('city_id').value;
            let image = document.getElementById('image').files[0];
            let active = document.getElementById('active').checked;

        let formData = new FormData();
        formData.append('name_ar',name_ar);
        formData.append('name_en',name_en);
        formData.append('category_id',category_id);
        formData.append('city_id',city_id);
        formData.append('image',image);
        formData.append('active',active);
       

        performStoreWithTostar('/sub_categories',formData,'form');
    }
</script>
@endsection
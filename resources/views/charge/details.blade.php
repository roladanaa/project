@extends('layout.master')

@section('title',__('dash.index_charge'))
@section('title_page',__('dash.index_charge'))

@section('content')



<section id="basic-datatable">
    <div class="row">
        
        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                          
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.name')}}</th>
                                        <th>{{__('dash.email')}}</th>
                                        <th>{{__('dash.mobile')}}</th>
                                        <th>{{__('dash.national_id')}}</th>
                                        <th>{{__('dash.pay_points')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                        <th>{{__('dash.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody id='data'>
                                    @foreach ($employees as $e)
                                    <tr>
                                        <td>{{$e->name}}</td>
                                            <td>{{$e->email}}</td>
                                            <td>{{$e->mobile}}</td>
                                            <td>{{$e->national_id}}</td>
                                            <td>{{$e->PayPoint->name}}</td>
                                            <td>{{$e->created_at->format('Y-m-d')}}</td>
                                        <td class="action-table">
                                            <a href="{{route('charge.show',$e->id)}}"  class="btn bg-gradient-info   waves-effect waves-light"><i class="fa-solid fa-file-invoice-dollar"></i></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
 
//  document.getElementById('employee_id').onchange = function(){
//     getDataEmployee()
//  };

 function getDataEmployee(){
    let employee_id = document.getElementById('employee_id').value;
    axios.get('/charge/employees/'+employee_id).then(function(response){

        let htmlData = ``;

        for(let i = 0 ; i < response.data.length;i++){

            htmlData += `

                <tr>
                    <td>${++i}</td>
                    <td>${response.data[i].user.name}</td>
                    <td>${response.data[i].description}</td>
                    <td>${response.data[i].amount}</td>
                    <td>${response.data[i].type}</td>
                    <td>${response.data[i].updated_at}</td>
                    <td class="action-table">
                        <a href="/charge/report/${response.data[i].id}"  class="btn bg-gradient-info   waves-effect waves-light"><i class="fa-solid fa-file-invoice-dollar"></i></i></a>
                    </td>
                </tr>

`;

        }
        
        document.getElementById('data').innerHTML = htmlData;
        console.log(response.data);
    }).catch(function(error){});
 }
    function performDelete(el,id){
        performDeleteWithTostar('/roles/'+id,{"_method" : 'DELETE'},el,'tr');
    }
</script>
@endsection
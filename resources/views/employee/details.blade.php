@extends('layout.master')

@section('title',__('dash.show_charge'))
@section('title_page',__('dash.show_charge'))

@section('content')



<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                            <table class='customTable'>
                                <tbody><tr>
                                    <td class="font-weight-bold">{{__('dash.name')}}</td>
                                    <td>{{$employee->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{__('dash.mobile')}}</td>
                                    <td>{{$employee->mobile}}</td>
                                </tr>
                               
                            </tbody></table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="customTable">
                                
                                <tbody><tr>
                                    <td class="font-weight-bold">{{__('dash.email')}}</td>
                                    <td>{{$employee->email}}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{__('dash.national_id')}}</td>
                                    <td>{{$employee->national_id}}</td>
                                </tr>
                               
                            </tbody></table>
                            
                        </div>
                        <div class="col-12">
                            <a href="{{route('employees.report',$employee->id)}}" class="btn btn-primary mr-1 waves-effect waves-light"><i class="feather icon-edit-1"></i> {{__('dash.reports')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="col-12">
            <div class="card">
               
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                          
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>{{__('dash.name_user')}}</th>
                                        <th>{{__('dash.type')}}</th>
                                        <th>{{__('dash.amount')}}</th>
                                        <th>{{__('dash.add_date2')}}</th>
                                    </tr>
                                </thead>
                                <tbody id='data'>
                                    @foreach ($employee->senderWalletUsers as $e)
                                    <tr>
                                        <td>{{$e->user->name}}</td>
                                            <td>{{$e->type}}</td>
                                            <td>{{$e->amount}}</td>
                                            <td>{{$e->created_at->format('Y-m-d')}}</td>
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
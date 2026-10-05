@extends('admin.admin_master')
@section('admin')

<div class="content"> 

    <!-- Start Content-->
    <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    
                </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
                                <div class="card">

                                    <div class="card-header">
                                        <h5 class="card-title mb-0">All Reviews</h5>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="datatable_length"><label class="form-label">Show <select name="datatable_length" aria-controls="datatable" class="form-select form-select-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="datatable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="datatable"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap dataTable no-footer dtr-inline" aria-describedby="datatable_info" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 60.667px;" aria-sort="ascending" aria-label="Sl: activate to sort column descending">Sl</th>
                                                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 180.333px;" aria-label="Name: activate to sort column ascending">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 116.333px;" aria-label="Position: activate to sort column ascending">Position</th>
                                                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 100.3333px;" aria-label="Image: activate to sort column ascending">Image</th>
                                                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 100.3333px;" aria-label="Massage: activate to sort column ascending">Message</th>
                                                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 100.3333px;" aria-label="Action: activate to sort column ascending">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                 @foreach ( $review as $key=> $item)
                                            <tr class="odd">
                                               
                                                    
                                                
                                                    <td class="sorting_1 dtr-control" tabindex="0">{{$key+1}}</td>
                                                    <td style="">{{$item->name}}</td>
                                                    <td style="">{{$item->position}}</td>
                                                    <td style=""><img src="{{asset($item->image)}}" style="width:70px; height:40px;"></td>
                                                    <td style="">{{$item->message}}</td>
                                                    <td style="">

                                                        <a href= "{{route('edit.review',$item -> id)}}" class ="btn btn-success btn-sm ">edit</a>
                                                         <a href= "" class ="btn btn-danger btn-sm ">Delete</a>

                                                    </td>
                                                
                                                </tr>
                                                @endforeach
                                             
                                            </tbody>
                                        </table></div></div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-5"><div class="dataTables_info" id="datatable_info" role="status" aria-live="polite"></div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="datatable_previous"><a href="#" aria-controls="datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="datatable_next"><a href="#" aria-controls="datatable" data-dt-idx="3" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                                    </div>

                                </div>
                            </div>
                        </div> 
                  



@endsection
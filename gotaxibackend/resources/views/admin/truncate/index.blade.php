@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Truncate Data')

@section('content')

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="box box-block border-radius-10">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px">
                <h5 class="mb-1">{{ translateKeyword('Truncate Data')}}</h5>
                @if ($delete_permission == 1)
                    <button class="btn btn-danger delete-data" data-id="All">
                        <i class="fa fa-trash"></i> {{ translateKeyword('Truncate All Data')}}
                    </button>
                @endif
            </div>
            @include('common.notify')

            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                <tr>
                    <th>{{ translateKeyword('id') }}</th>
                    <th>{{ translateKeyword('module')}}</th>
                    <th>{{ translateKeyword('action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($modules as $index => $faq)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$faq->name}}</td>
                        <td>
                        @if ($delete_permission == 1)
                            <button class="btn btn-danger delete-data" data-id="{{$faq->name}}">
                                <i class="fa fa-trash"></i> {{ translateKeyword('Truncate Data')}}
                            </button>
                        @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>{{ translateKeyword('id') }}</th>
                    <th>{{ translateKeyword('module')}}</th>
                    <th>{{ translateKeyword('action')}}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div id="add-promotion-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ translateKeyword('add_promocode')}}</h4>
            </div>
            <form id="promocodes-form" action="{{ route('promocodes.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row no-margin" id="card-payment">
                        <div class="form-group col-md-12 col-sm-12">
                            <label>{{ translateKeyword('promocode')}}</label>
                            <input autocomplete="off" name="promocode" required type="text" class="form-control" placeholder="{{ translateKeyword('add_promocode')}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">{{ translateKeyword('add_promocode')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    $(document).ready(function(){
        $('body').on('click', '.delete-data', function(){
            const type = $(this).attr('data-id');
            const conf = confirm('Are you sure you want to truncate this data?');
            if(conf){
                const password = prompt('Please enter your password');
                console.log(password, !$.trim(password))
                if($.trim(password)){       
                    $.ajax({
                        url:"{{ route('admin.truncate.truncate-data') }}",
                        method:"GET",
                        data:{type, password},
                        success:function(res){
                            if(res == 'false'){
                                return alert('Password is not correct');
                            }
                            alert('Data Truncate Successfull!');
                        },error:function(xhr){
                            console.log(xhr.responseText);
                        }
                    });
                }
            }

        });
    });
</script>
@endsection

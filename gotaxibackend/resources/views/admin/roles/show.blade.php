@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Update Role ')

@section('content')
    <style>
         .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }
        .table thead th, .table thead td {
            font-weight: 600;
            font-size: 1rem !important;
            border-bottom-width: 1px;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        input[type=checkbox] {
            transform: scale(1.2);
        }
        .table-responsive {
            max-height: 2200px; /* Adjust this value as needed */
            overflow-y: auto;
        }
        .table-responsive thead {
            position: sticky;
            top: 0;
            z-index: 1000; /* Ensures the header stays above the table content */
            background-color: #f5f5f5; /* Matches the header background color */
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.role.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back')}}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Update Role')}}</h5>
                @include('common.notify')
                <!--begin: Datatable-->
                            <div class="table-responsive">
                                <form method="POST" action="{{ route('admin.role.update', $role->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                <table class="table table-bordered table-sm " >
                                    <thead style="background-color:#f5f5f5 !important; font-weight: bold;">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>{{ translateKeyword('Module Name')}}</th>
                                            <th>{{ translateKeyword('Function Name')}}</th>
                                            <th>
                                                {{ translateKeyword('View')}}
                                                <p style="display: inline-block;margin:0px;margin-left:5px;">
                                                <input type="checkbox" name="" id="fn_view" value="1" @if($role->is_default == 1) disabled @endif>
                                                </p>
                                            </th>
                                            <th>
                                                {{ translateKeyword('add')}}
                                                <p style="display: inline-block;margin:0px;margin-left:5px;">
                                                    <input type="checkbox" name="" id="fn_add" value="1" @if($role->is_default == 1) disabled @endif>
                                                </p>
                                            </th>
                                            <th>
                                                {{ translateKeyword('edit')}}
                                                <p style="display: inline-block;margin:0px;margin-left:5px;">
                                                    <input type="checkbox" name="" id="fn_edit" value="1" @if($role->is_default == 1) disabled @endif>
                                                </p>
                                            </th>
                                            <th>
                                                {{ translateKeyword('Notify')}}
                                                <p style="display: inline-block;margin:0px;margin-left:5px;">
                                                    <input type="checkbox" name="" id="fn_notify" value="1" @if($role->is_default == 1) disabled @endif>
                                                </p>
                                            </th>
                                            <th>
                                                {{ translateKeyword('status')}}
                                                <p style="display: inline-block;margin:0px;margin-left:5px;">
                                                    <input type="checkbox" name="" id="fn_status" value="1" @if($role->is_default == 1) disabled @endif>
                                                </p>
                                            </th>
                                            <th>
                                                {{ translateKeyword('delete')}}
                                                <p style="display: inline-block;margin:0px;margin-left:5px;">
                                                    <input type="checkbox" name="" id="fn_delete" value="1" @if($role->is_default == 1) disabled @endif>
                                                </p>
                                            </th>
                                            <th>
                                                {{ translateKeyword('Show All Data')}}
                                                <p style="display: inline-block;margin:0px;margin-left:5px;">
                                                    <input type="checkbox" name="" id="fn_data" value="1" @if($role->is_default == 1) disabled @endif>
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>
                                    @if ($modules->count())
                                        @php $count = 0; @endphp
                                        @for ($i = 0; $i < $modules->count() ; $i++)
                                            @php 
                                            $modulePrivileg = App\Privilege::where([
                                                        'module_id' => $modules[$i]['id'],
                                                        'role_id' => $role->id])
                                                        ->first();
                                            @endphp
                                           <tr>
                                               <td style="background: #ececec; font-weight: bold;">{{ ++$count }}</td>
                                               <td colspan="{{ !$modules[$i]['operations']->count() ? 0 : 9 }}" style="background: #ececec; font-weight: bold;">{{  $modules[$i]['name']  }}</td>
                                               @if (!$modules[$i]['operations']->count())
                                                        <td></td>
                                                        <input type="hidden" name="module_id[{{ $modulePrivileg->id }}]" value="{{ $modulePrivileg->id }}">
                                                        <td>
                                                        @if ($modules[$i]['is_view'] == 1)
                                                            <input type="checkbox" name="is_view[{{ $modulePrivileg->id }}]" class="fn_view" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['is_view'] == $modulePrivileg->is_view ? "checked" : '' }}/>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($modules[$i]['is_add'] == 1)
                                                            <input type="checkbox" name="is_add[{{ $modulePrivileg->id }}]" class="fn_add" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['is_add'] == $modulePrivileg->is_add ? "checked" : '' }}/>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($modules[$i]['is_edit'] == 1)
                                                            <input type="checkbox" name="is_edit[{{ $modulePrivileg->id }}]" class="fn_edit" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['is_edit'] == $modulePrivileg->is_edit ? "checked" : '' }}/>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($modules[$i]['is_notify'] == 1)
                                                            <input type="checkbox" name="is_notify[{{ $modulePrivileg->id }}]" class="fn_notify" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['is_notify'] == $modulePrivileg->is_notify ? "checked" : '' }}/>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($modules[$i]['is_status'] == 1)
                                                        <input type="checkbox" name="is_status[{{ $modulePrivileg->id }}]" class="fn_status" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['is_status'] == $modulePrivileg->is_status ? "checked" : '' }}/>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($modules[$i]['is_delete'])
                                                        <input type="checkbox" name="is_delete[{{ $modulePrivileg->id }}]" class="fn_delete" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['is_delete'] == $modulePrivileg->is_delete ? "checked" : '' }}/>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($modules[$i]['is_view_all_data'])
                                                        <input type="checkbox" name="is_view_all_data[{{ $modulePrivileg->id }}]" class="fn_data" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['is_view_all_data'] == $modulePrivileg->is_view_all_data ? "checked" : '' }}/>
                                                        @endif
                                                    </td>
                                               @endif
                                           </tr>
                                           @php
                                               $sub_count = 1;
                                           @endphp
                                           @for ($j = 0 ; $j < $modules[$i]['operations']->count() ; $j++)
                                           <tr>
                                               <td>{{ $count .'.'. $sub_count++ }}</td>
                                               <td></td>
                                               <td>{{  $modules[$i]['operations'][$j]['name']  }}
                                               @php
                                                    $privileg = App\Privilege::where([
                                                        'module_id' => $modules[$i]['operations'][$j]['id'],
                                                        'role_id' => $role->id])
                                                        ->first();
                                               @endphp
                                               <input type="hidden" name="module_id[{{ $privileg->id }}]" value="{{ $privileg->id }}">
                                               </td>
                                               <td>
                                                    @if ($modules[$i]['operations'][$j]['is_view'] == 1)
                                                        <input type="checkbox" name="is_view[{{ $privileg->id }}]" class="fn_view" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['operations'][$j]['is_view'] == $privileg->is_view ? "checked" : '' }}/>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($modules[$i]['operations'][$j]['is_add'] == 1)
                                                        <input type="checkbox" name="is_add[{{ $privileg->id }}]" class="fn_add" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['operations'][$j]['is_add'] == $privileg->is_add ? "checked" : '' }}/>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($modules[$i]['operations'][$j]['is_edit'] == 1)
                                                        <input type="checkbox" name="is_edit[{{ $privileg->id }}]" class="fn_edit" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['operations'][$j]['is_edit'] == $privileg->is_edit ? "checked" : '' }}/>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($modules[$i]['operations'][$j]['is_notify'] == 1)
                                                        <input type="checkbox" name="is_notify[{{ $privileg->id }}]" class="fn_edit" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['operations'][$j]['is_notify'] == $privileg->is_notify ? "checked" : '' }}/>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($modules[$i]['operations'][$j]['is_status'] == 1)
                                                    <input type="checkbox" name="is_status[{{ $privileg->id }}]" class="fn_status" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['operations'][$j]['is_status'] == $privileg->is_status ? "checked" : '' }}/>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($modules[$i]['operations'][$j]['is_delete'])
                                                    <input type="checkbox" name="is_delete[{{ $privileg->id }}]" class="fn_delete" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['operations'][$j]['is_delete'] == $privileg->is_delete ? "checked" : '' }}/>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($modules[$i]['operations'][$j]['is_view_all_data'])
                                                    <input type="checkbox" name="is_view_all_data[{{ $privileg->id }}]" class="fn_data" value="1" @if($role->is_default == 1) disabled @endif {{ $modules[$i]['operations'][$j]['is_view_all_data'] == $privileg->is_view_all_data ? "checked" : '' }}/>
                                                    @endif
                                                </td>
                                           </tr>
                                           @endfor
                                        @endfor
                                    @endif
                                </table>
                                <a href="{{ route('admin.role.index') }}" class="btn btn-dark">{{ translateKeyword('cancel')}}</a>
                                @if ($role->is_default == 0)
                                    <button type="submit" class="btn btn-danger">{{ translateKeyword('Update Role Permission')}}</button>
                                @else
                                    <button type="button" class="btn btn-danger">{{ translateKeyword('Cant Update Default Role')}}</button>
                                @endif
                                </form>
                            </div>
                            <!--end: Datatable-->
            </div>
        </div>
    </div>
@include('admin.roles.js.show')
@endsection


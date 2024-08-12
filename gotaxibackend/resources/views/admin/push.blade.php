@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Push Notification')

@section('content')
<style>
    #table-2{
        width:100%!important;
    }
</style>
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">
            @include('common.notify')
        </div>
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <ul class="nav nav-tabs" id="serviceTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-modes" data-toggle="tab" href="#userNotification" role="tab"
                            aria-controls="userNotification" aria-selected="true">
                            {{ translateKeyword('user') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-settings" data-toggle="tab" href="#driverNotification" role="tab"
                            aria-controls="driverNotification" aria-selected="false">
                            {{ translateKeyword('provider') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show" id="driverNotification" role="tabpanel" aria-labelledby="tab-push">
                    @if ($add_permission == 1)
                        <div class="box box-block bg-white border-radius-10">

                            <h5 style="margin-bottom: 2em;">{{ translateKeyword('s_p_t_d_a') }}</h5>
                            <form class="form-horizontal" action="{{ route('admin.push.driver_push') }}" method="POST"
                                enctype="multipart/form-data" role="form">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label for="title"
                                        class="col-xs-12 col-form-label">{{ translateKeyword('Title') }}</label>
                                    <div class="col-xs-12 col-md-6 col-lg-6">
                                        <input class="form-control" type="text" value="{{ old('title') }}"
                                            name="title" required id="title" placeholder="Title">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="message"
                                        class="col-xs-12 col-form-label">{{ translateKeyword('Message') }}</label>
                                    <div class="col-xs-12 col-md-6 col-lg-6">
                                        <textarea class="form-control pure-input-1-2" style="width: 100%;" name="message" id="message1" rows="5"
                                            placeholder="Notification message!"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="zipcode" class="col-xs-12 col-form-label"></label>
                                    <div class="col-xs-10">
                                        <button type="submit"
                                            class="btn btn-primary">{{ translateKeyword('Send') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    <div class="box box-block bg-white border-radius-10">
                        <h5 class="mb-1">{{ translateKeyword('push-notification-history-provider') }}</h5>
                        <table class="table table-striped table-bordered dataTable" id="table-2">
                            <thead>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('Title') }}</th>
                                    <th>{{ translateKeyword('Message') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($driverPushNotifications as $index => $driverPushNotification)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $driverPushNotification->title }}</td>
                                        <td>{{ $driverPushNotification->message }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('Title') }}</th>
                                    <th>{{ translateKeyword('Message') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade show active in" id="userNotification" role="tabpanel" aria-labelledby="tab-push">
                    @if ($add_permission == 1)
                        <div class="box box-block bg-white border-radius-10">

                            <h5 style="margin-bottom: 2em;">{{ translateKeyword('s_p_t_u_a') }}</h5>
                            <form class="form-horizontal" action="{{ route('admin.push.user_push') }}" method="POST"
                                enctype="multipart/form-data" role="form">
                                {{ csrf_field() }}

                                <div class="form-group row">
                                    <label for="title"
                                        class="col-xs-12 col-form-label">{{ translateKeyword('Title') }}</label>
                                    <div class="col-xs-12 col-md-6 col-lg-6">
                                        <input class="form-control" type="text" value="{{ old('title') }}"
                                            name="title" required id="title" placeholder="Title">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="message"
                                        class="col-xs-12 col-form-label">{{ translateKeyword('Message') }}</label>
                                    <div class="col-xs-12 col-md-6 col-lg-6">
                                        <textarea class="form-control pure-input-1-2" style="width: 100%;" name="message" id="message" maxlength="255"
                                            rows="5" placeholder="Notification message!"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="zipcode" class="col-xs-12 col-form-label"></label>
                                    <div class="col-xs-10">
                                        <button type="submit"
                                            class="btn btn-primary">{{ translateKeyword('Send') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif


                    <div class="box box-block bg-white border-radius-10">
                        <h5 class="mb-1">{{ translateKeyword('push-notification-history--user') }}</h5>
                        <table class="table table-striped table-bordered dataTable" id="table-1">
                            <thead>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('Title') }}</th>
                                    <th>{{ translateKeyword('Message') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userPushNotifications as $index => $userPushNotification)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $userPushNotification->title }}</td>
                                        <td>{{ $userPushNotification->message }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ translateKeyword('id') }}</th>
                                    <th>{{ translateKeyword('Title') }}</th>
                                    <th>{{ translateKeyword('Message') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

@endsection

@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'App CMS')


@section('content')
    <style>
        /* Bootstrap-like tab styles */
        .nav-tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            padding-left: 0;
        }

        .nav-tabs .nav-link {
            padding: .5rem 1rem;
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            margin-right: 2px;
            cursor: pointer;
        }

        .tab-content {
            display: none;
            padding: 1rem;
            border: 1px solid #ddd;
            border-top: 0;
        }

        .tab-content.active {
            display: block;
        }
    </style>

    <style>
        /* */

        .panel-default>.panel-heading {
            color: #333 !important;
            background-color: #fff;
            border-color: #e4e5e7;
            padding: 0;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .panel-default>.panel-heading a {
            display: block;
            padding: 10px 15px;
            color: #333 !important;
        }

        .panel-default>.panel-heading a:after {
            content: "";
            position: relative;
            top: 1px;
            display: inline-block;
            font-family: 'Glyphicons Halflings';
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            float: right;
            transition: transform .25s linear;
            -webkit-transition: -webkit-transform .25s linear;
        }

        .panel-default>.panel-heading a[aria-expanded="true"] {
            background-color: #eee;
        }

        .panel-default>.panel-heading a[aria-expanded="true"]:after {
            content: "\2212";
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .panel-default>.panel-heading a[aria-expanded="false"]:after {
            content: "\002b";
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }
    </style>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header" style="border-bottom: none">
                            @include('common.notify')
                            <h3 class="card-title">{{ translateKeyword('App Settings') }}</h3>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <div class="nav-link {{ session('activeTab') === 'cancelation' ? 'active' : (session('activeTab') ? '' : 'active') }}"
                                    data-target="#cancelation" role="tab">
                                    Ride Cancelation Reason</div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-link {{ session('activeTab') === 'faqs' ? 'active' : '' }}"
                                    data-target="#faqs" role="tab">
                                    FAQs</div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-link {{ session('activeTab') === 'documents' ? 'active' : '' }}"
                                    data-target="#documents" role="tab">
                                    Documents</div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-link {{ session('activeTab') === 'onboarding' ? 'active' : '' }}"
                                    data-target="#onboarding" role="tab">
                                    OnBoarding</div>
                            </li>

                        </ul>
                        <div class="tab-content {{ session('activeTab') === 'cancelation' ? 'active' : (session('activeTab') ? '' : 'active') }}"
                            id="cancelation" role="tabpanel">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-xs-2 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('cancellation-reason') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-10">
                                            <form class="form-horizontal"
                                                action="{{ route('admin.cms.app.cancellation-update') }}"
                                                id="updateSettingForm" method="POST" enctype="multipart/form-data"
                                                role="form">
                                                {{ csrf_field() }}

                                                <input @if (Setting::get('cancel_reason') == 1) checked @endif name="cancel_reason"
                                                    id="cancel_reason" onchange="cancelselect()" type="checkbox"
                                                    class="js-switch" data-color="#43b968">
                                            </form>
                                        </div>
                                    </div>
                                    <div id="cancel_reason_div">
                                        <!-- DataTable HTML Table -->
                                        <h5 class="mb-1 d-inline"> {{ translateKeyword('cancellation-reason') }}</h5>

                                        @if ($add_permission)
                                            <a href="{{ route('admin.cancellation.create') }}" style="margin-left: 1em;"
                                                class="btn btn-primary pull-right color-white mb-2"><i
                                                    class="fa fa-plus"></i>
                                                {{ translateKeyword('add-new-reason') }}</a>
                                        @endif

                                        <table class="table table-striped table-bordered dataTable" id="table-2">
                                            <thead>
                                                <tr>
                                                    <th>{{ translateKeyword('id') }}</th>
                                                    <th>{{ translateKeyword('reason') }}</th>
                                                    <th>{{ translateKeyword('type') }}</th>
                                                    <th>{{ translateKeyword('action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cancellationReasons as $index => $reason)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $reason->reason }}</td>
                                                        <td>{{ $reason->type }}</td>
                                                        <td>
                                                            <!-- Separate form for deletion -->
                                                            @if ($delete_permission == 1)
                                                                <form
                                                                    action="{{ route('admin.cancellation.destroy', $reason->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger"
                                                                        onclick="return confirm('Are you sure?')">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <!-- Edit link -->
                                                            @if ($edit_permission == 1)
                                                                <a href="{{ route('admin.cancellation.edit', $reason->id) }}"
                                                                    class="btn btn-info">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>{{ translateKeyword('id') }}</th>
                                                    <th>{{ translateKeyword('reason') }}</th>
                                                    <th>{{ translateKeyword('type') }}</th>
                                                    <th>{{ translateKeyword('action') }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if ($edit_permission == 1)
                                <div class="panel panel-default box box-block bg-white">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary"
                                            form="updateSettingForm">{{ translateKeyword('update-app-settings') }}</button>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="tab-content {{ session('activeTab') === 'faqs' ? 'active' : '' }}" id="faqs"
                            role="tabpanel">
                            <form class="form-horizontal" action="{{ route('admin.settings.appsetting.store') }}"
                                method="POST" enctype="multipart/form-data" role="form">
                                {{ csrf_field() }}

                                <!-- DataTable HTML Table -->
                                <h5 class="mb-1 d-inline">{{ translateKeyword('faqs') }}</h5>

                                @if ($add_permission)
                                    <a href="{{ route('admin.faqs.create') }}" style="margin-left: 1em;"
                                        class="btn btn-primary pull-right color-white mb-2"><i class="fa fa-plus"></i>
                                        {{ translateKeyword('add-new-faq') }}</a>
                                @endif

                                <table class="table table-striped table-bordered dataTable" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>{{ translateKeyword('id') }}</th>
                                            <th>{{ translateKeyword('question') }}</th>
                                            <th>{{ translateKeyword('answer') }}</th>
                                            <th>{{ translateKeyword('type') }}</th>
                                            <th>{{ translateKeyword('action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($faqs as $index => $faq)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $faq->question }}</td>
                                                <td>{{ $faq->answer }}</td>
                                                <td>{{ $faq->type }}</td>
                                                <td>
                                                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}"
                                                        method="POST">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        @if ($edit_permission == 1)
                                                            <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                                                                class="btn btn-info">
                                                                <i class="fa fa-edit"></i> {{ translateKeyword('edit') }}
                                                            </a>
                                                        @endif
                                                        @if ($delete_permission == 1)
                                                            <button class="btn btn-danger"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="fa fa-trash"></i>
                                                                {{ translateKeyword('delete') }}
                                                            </button>
                                                        @endif
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>{{ translateKeyword('id') }}</th>
                                            <th>{{ translateKeyword('question') }}</th>
                                            <th>{{ translateKeyword('answer') }}</th>
                                            <th>{{ translateKeyword('type') }}</th>
                                            <th>{{ translateKeyword('action') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>

                        <div class="tab-content {{ session('activeTab') === 'documents' ? 'active' : '' }}"
                            id="documents" role="tabpanel">
                            <h5 class="mb-1">{{ translateKeyword('documents') }}</h5>
                            @if ($add_permission == 1)
                                <a href="{{ route('admin.document.create') }}" style="margin-left: 1em;"
                                    class="btn btn-primary pull-right color-white mb-2"><i class="fa fa-plus"></i>
                                    {{ translateKeyword('add_new_document') }}</a>
                            @endif
                            <table class="table table-striped table-bordered dataTable" id="table-2">
                                <thead>
                                    <tr>
                                        <th>{{ translateKeyword('id') }}</th>
                                        <th>{{ translateKeyword('document_name') }}</th>
                                        <th>{{ translateKeyword('type') }}</th>
                                        <th>{{ translateKeyword('expiry-required') }}</th>
                                        <th>{{ translateKeyword('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $index => $document)
                                        @php
                                            $name =
                                                $document->translations
                                                    ->where('language_id', session('translation'))
                                                    ->first()->name ?? $document->name;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $name }}</td>
                                            <td>{{ $document->type }}</td>
                                            <td>{{ $document->expiry_required }}</td>
                                            <td>
                                                <form action="{{ route('admin.document.destroy', $document->id) }}"
                                                    method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if ($edit_permission == 1)
                                                        <a href="{{ route('admin.document.edit', $document->id) }}"
                                                            class="btn btn-info"><i class="fa fa-edit"></i>
                                                            {{ translateKeyword('edit') }}</a>
                                                    @endif
                                                    @if ($delete_permission == 1)
                                                        <button class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash"></i> {{ translateKeyword('delete') }}
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{ translateKeyword('id') }}</th>
                                        <th>{{ translateKeyword('document_name') }}</th>
                                        <th>{{ translateKeyword('type') }}</th>
                                        <th>{{ translateKeyword('expiry-required') }}</th>
                                        <th>{{ translateKeyword('action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="tab-content {{ session('activeTab') === 'onboarding' ? 'active' : '' }}"
                            id="onboarding" role="tabpanel">
                            <h5 class="mb-1">{{ translateKeyword('Onboadings') }}</h5>
                            @if ($add_permission == 1)
                                <a href="{{ route('admin.onboardings.create') }}" style="margin-left: 1em;"
                                    class="btn btn-primary pull-right color-white mb-2"><i class="fa fa-plus"></i>
                                    {{ translateKeyword('add_new_onboarding') }}</a>
                            @endif
                            <table class="table table-striped table-bordered dataTable" id="table-2">
                                <thead>
                                    <tr>
                                        <th>{{ translateKeyword('id') }}</th>
                                        <th>{{ translateKeyword('title') }}</th>
                                        <th>{{ translateKeyword('type') }}</th>
                                        <th>{{ translateKeyword('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($boardings as $index => $boarding)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $boarding->title }}</td>
                                            <td>{{ $boarding->type }}</td>
                                            <td>
                                                <form action="{{ route('admin.onboardings.destroy', $boarding->id) }}"
                                                    method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if ($edit_permission == 1)
                                                        <a href="{{ route('admin.onboardings.edit', $boarding->id) }}"
                                                            class="btn btn-info"><i class="fa fa-edit"></i>
                                                            {{ translateKeyword('edit') }}</a>
                                                    @endif
                                                    @if ($delete_permission == 1)
                                                        <button class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fa fa-trash"></i> {{ translateKeyword('delete') }}
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{ translateKeyword('id') }}</th>
                                        <th>{{ translateKeyword('title') }}</th>
                                        <th>{{ translateKeyword('type') }}</th>
                                        <th>{{ translateKeyword('action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
    </div>

    </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table-2').DataTable({
                responsive: true,
                dom: '<"top"i>rt<"bottom"flp><"clear">'
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll("#myTab .nav-link");
            const tabContents = document.querySelectorAll(".tab-content");

            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    const target = this.getAttribute('data-target');
                    tabs.forEach(t => t.classList.remove("active"));

                    tab.classList.add("active");
                    // const target = document.querySelector(tab.dataset.target);
                    // target.classList.add("active");

                    document.querySelector(target).classList.add('active');
                    tabs.forEach(t => {
                        if (t !== tab) {
                            const paneId = t.getAttribute('data-target');
                            document.querySelector(paneId).classList.remove('active');
                        }
                    });
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Inner tabs
            const innerTabs = document.querySelectorAll('#myInnerTabs .nav-link');

            innerTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('href');

                    document.querySelector(target).classList.add('show', 'active');
                    innerTabs.forEach(t => {
                        if (t !== tab) {
                            const paneId = t.getAttribute('href');
                            document.querySelector(paneId).classList.remove('show',
                                'active');
                        }
                    });
                });
            });
        });

        
        
        function cancelselect() {
            if ($('#cancel_reason').is(":checked")) {
                $("#cancel_reason_div").fadeIn(700);
            } else {
                $("#cancel_reason_div").fadeOut(700);
            }
        }
        cancelselect()
    </script>
@endsection

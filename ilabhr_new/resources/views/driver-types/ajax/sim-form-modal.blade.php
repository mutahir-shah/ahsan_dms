
<link rel="stylesheet" href="{{ asset('vendor/css/dropzone.min.css') }}">

<div class="modal-header">
    <h5 class="modal-title">@lang('app.addSimForm')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <x-form id="save-sim-form-data-form" method="PUT" class="ajax-form">
            <div class="row">
                <div class="col-lg-12">
                    <x-forms.file allowedFileExtensions="png jpg jpeg svg pdf doc docx" class="mr-0 mr-lg-2 mr-md-2"
                        :fieldLabel="__('modules.drivers.simForm')" fieldName="sim_form"
                        :fieldValue="$driver->sim_form ? $driver->sim_form_url : '' "
                        fieldId="file">
                    </x-forms.file>
                </div>
            </div>
        </x-form>
    </div>
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">@lang('app.cancel')</x-forms.button-cancel>
    <x-forms.button-primary id="save-sim-form" icon="check">@lang('app.save')</x-forms.button-primary>
</div>

<script>

    $('#save-sim-form').click(function(){
        $.easyAjax({
                url: "{{ route('drivers.update', $driver->id) }}",
                container: '#save-sim-form-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: 'save-sim-form',
                file: true,
                data: $('#save-sim-form-data-form').serialize(),
                success: function (response) {
                if (response.status === 'success') {
                    window.location.reload();
                }
            }
        });
    });

    init(MODAL_LG);
</script>

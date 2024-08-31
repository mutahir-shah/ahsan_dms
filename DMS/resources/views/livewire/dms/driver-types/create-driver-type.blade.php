<div>
    <x-layouts.breadcrum
        :main_menu="$main_menu"
        :menu="$menu"
    />
    <x-ui.message />
    <x-ui.row>
        <x-ui.col class="col-lg-12">
            <form wire:submit='create'>
                <!-- Begin: Details Card -->
                <x-ui.card>
                    <x-ui.card-header title="Driver Type Details"/>
                    <x-ui.card-body>
                    <x-ui.row>

                    <!-- Begin: Name Card -->
                    <x-ui.col class="col-lg-3 col-md-3 mb-4">
                        <x-form.label for="name" name="Name" :required="true"/>
                        <x-form.input-text  id="name" :placeholder="@translate('Name')" wire:model="name"/>
                        <x-ui.alert error="name"/>
                    </x-ui.col>
                    <!-- End: Name Card -->

                    <!-- Begin: Fields Card -->
                    <x-ui.col class="col-lg-12 col-md-12 mb-3">
                        <div class="form-check form-check-secondary">
                            <input class="form-check-input" wire:model='fields' type="checkbox" id="vehicle_monthly_cost" value="vehicle_monthly_cost">
                            <label class="form-check-label" for="vehicle_monthly_cost">
                                Vehicle Monthly Cost
                            </label>
                        </div>
                        <div class="form-check form-check-secondary">
                            <input class="form-check-input" wire:model='fields' type="checkbox" id="mobile_data" value="mobile_data">
                            <label class="form-check-label" for="mobile_data">
                                Mobile Data
                            </label>
                        </div>
                        <div class="form-check form-check-secondary">
                            <input class="form-check-input" wire:model='fields' type="checkbox" id="accommodation" value="accommodation">
                            <label class="form-check-label" for="accommodation">
                                Accommodation
                            </label>
                        </div>
                        <div class="form-check form-check-secondary">
                            <input class="form-check-input" wire:model='fields' type="checkbox" id="fuel" value="fuel">
                            <label class="form-check-label" for="fuel">
                                Fuel
                            </label>
                        </div>
                        <div class="form-check form-check-secondary">
                            <input class="form-check-input" wire:model='fields' type="checkbox" id="gprs" value="gprs">
                            <label class="form-check-label" for="gprs">
                               GPRS
                            </label>
                        </div>
                    </x-ui.col>
                    <!-- End: Fields Card -->

                    <!-- Begin: Login Allowed? Card -->
                    <x-ui.col class="col-lg-3 col-md-3 mb-3">
                        <x-form.label for="is_freelancer" name="Mark as Freelancer"/>
                    <div class="flex gap-5">
                        <div class="form-check form-radio-secondary mb-3">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="is_freelancer"
                                id="is_freelancer_yes"
                                value="1"
                                wire:model='is_freelancer'
                            />
                            <label class="form-check-label" for="is_freelancer_yes">
                                @translate('Yes')
                            </label>
                        </div>
                        <div class="form-check form-radio-secondary mb-3">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="is_freelancer"
                                id="is_freelancer_no"
                                value="0"
                                checked
                                wire:model='is_freelancer'
                            />
                            <label class="form-check-label" for="is_freelancer_no">
                                @translate('No')
                            </label>
                        </div>

                    </div>
                    <x-ui.alert error="is_receive_email_notification"/>
                    </x-ui.col>
                    <!-- End: Login Allowed? Card -->

                    </x-ui.row>
                    </x-ui.card-body>
                </x-ui.card>
                <!-- End: Other Details Card -->
                  <!-- end card -->
            <div class="text-end mb-4">
                <a href="{{ route('driver-types.index') }}" wire:navigate class="btn btn-danger w-sm">@translate('Cancel')</a>
                <button type="submit" class="btn btn-success w-sm">@translate('Create')</button>
            </div>
            </form>


        </x-ui.col>
    </x-ui.row>
</div>

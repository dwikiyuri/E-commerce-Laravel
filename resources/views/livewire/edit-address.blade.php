<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">

	<form wire:submit.prevent='update'>
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-12 col-span-12">
                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                           Edit My Shipping Address
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                    First Name
                                </label>
                                <input wire:model='first_name' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="first_name" type="text">
                                </input>
                                <div class="text-red-500 text-sm">
                                    @error('first_name') {{ $message }} @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                    Last Name
                                </label>
                                <input wire:model='last_name' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="last_name" type="text">
                                </input>
                                <div class="text-red-500 text-sm">
                                    @error('last_name') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="phone">
                                Phone
                            </label>
                            <input wire:model='phone' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="phone" type="text">
                            </input>
                            <div class="text-red-500 text-sm">
                                @error('phone') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="address">
                                Street Address
                            </label>
                            <input wire:model='street_address' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="address" type="text">
                            </input>
                            <div class="text-red-500 text-sm">
                                @error('street_address') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 dark:text-white mb-1" for="province">
                                        Province
                                    </label>
                                    <select wire:model.live="selectedProvince"   wire:key="{{ $selectedProvince }}" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="province">
                                        <option value="">Select a Province</option>
                                        @foreach($province as $prov)
                                            <option value="{{ $prov->province_code }}" >{{ $prov->province_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-red-500 text-sm">
                                        @error('selectedProvince') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4" >
                                    <label class="block text-gray-700 dark:text-white mb-1" for="city">
                                        City
                                    </label>
                                    <select wire:model.live="selectedCity" wire:key="{{ $selectedCity }}"  class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="city">
                                        <option value="">Select a City</option>
                                        @if(!empty($city))
                                            @foreach($city as $cityItem)
                                        <option  value="{{ $cityItem }}" >{{ $cityItem }}</option>
                                        @endforeach
                                         @endif
                                    </select>
                                    <div class="text-red-500 text-sm">
                                        @error('selectedCity') {{ $message }} @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Debugging output -->
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="village">
                                    District
                                </label>
                                <select wire:model.live="selectedVillage" wire:key="{{ $selectedCity }}" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="village">
                                    <option value="">Select a District</option>
                                    @if(!empty($village))
                                    @foreach($village as $villages)
                                        <option value="{{ $villages }}">{{ $villages}}</option>
                                    @endforeach
                                 @endif
                                </select>
                                <div class="text-red-500 text-sm">
                                    @error('selectedVillage') {{ $message }} @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="village_district">
                                    Sub-District
                                </label>
                                <select wire:model.live="selectedVillageDistrict" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="village_district">
                                    <option value="" >Select a Sub-District</option>
                                    @if(!empty($village_district))
                                    @foreach($village_district as $villagess)
                                        <option value="{{ $villagess }}">{{ $villagess }}</option>
                                    @endforeach
                                 @endif
                                </select>
                                <div class="text-red-500 text-sm">
                                    @error('selectedVillageDistrict') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="zip">
                                    Postal Code
                                </label>
                                <select wire:model.live="selectedPostalcode" class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="village_district">
                                    <option value="">Select a Postal Code</option>
                                    @if(!empty($postal_code))
                                    @foreach($postal_code as $postal)
                                        <option value="{{ $postal->postal_code }}">{{ $postal->postal_code }}</option>
                                    @endforeach
                                 @endif
                                </select>
                                <div class="text-red-500 text-sm">
                                    @error('selectedPostalcode') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mt-4">
                            <button type="submit" class="bg-blue-500 mt-4 w-84 p-3 rounded-lg text-lg text-white hover:bg-green-600">
                                <span wire:loading.remove>Save Address</span>
                                <span wire:loading>Processing.....</span>
                            </button>
                        </div>
                    </div>


                </div>
                <!-- End Card -->
            </div>

        </div>
    </form>

</div>

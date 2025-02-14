<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
	<h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
		Checkout
	</h1>
	<form wire:submit.prevent='placeOrder'>
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <!-- Shipping Address -->
                    <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <h2 class="text-xl font-bold underline text-gray-700 dark:text-white">
                                    Shipping Address
                                </h2>
                                @if($hasAddress)
                                      <div class="flex items-center">
                                        <input type="checkbox" id="hs-small-switch" wire:model.live='useMyAddressToggle' class="relative w-11 h-6 p-px bg-gray-500 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600
                                        before:inline-block before:size-5 before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-200">
                                        <label for="hs-small-switch" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Use My Address</label>
                                      </div>
                                      @endif
                            </div>
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
                                <label class="block text-gray-700 dark:text-white mb-1" for="city">
                                    Province
                                </label>
                                <select wire:model.live='selectedProvince' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="city" type="text">
                                    <option value="">Select a Province</option>
                                    @foreach($province as $prov)
                                        <option value="{{ $prov->province_code }}" >{{ $prov->province_name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-red-500 text-sm">
                                    @error('selectedProvince') {{ $message }} @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="state">
                                    City
                                </label>
                                <select wire:model.live="selectedCity" wire:key='{{$selectedCity}}' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="state" type="text">
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
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="state">
                                   District
                                </label>
                                <select wire:model.live="selectedVillage" wire:key='{{$selectedVillage}}' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="state" type="text">
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
                                <label class="block text-gray-700 dark:text-white mb-1" for="zip">
                                    Sub District
                                </label>
                                <select wire:model.live="selectedVillageDistrict" wire:key='{{$selectedVillageDistrict}}' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="zip" type="text">
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
                        <div class=" mt-4">
                                <label class="block text-gray-700 dark:text-white mb-1" for="zip">
                                    ZIP Code
                                </label>
                                <select wire:model.live="selectedPostalcode" wire:key='{{$selectedPostalcode}}' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none" id="zip" type="text">
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
                    <div class="text-lg font-semibold mb-4">
                        Select Payment Method
                    </div>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input wire:model='payment_method' class="hidden peer" id="hosting-small"  required="" type="radio" value="cod"  />
                            <label class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700" for="hosting-small">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Cash on Delivery
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                        <li>
                            <input wire:model='payment_method' class="hidden peer" id="hosting-big"  type="radio" value="midtrans">
                            <label class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700" for="hosting-big">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                       Transfer
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                            </input>
                        </li>
                    </ul>
                    <div class="text-red-500 text-sm">
                        @error('payment_method') {{ $message }} @enderror
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        ORDER SUMMARY
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Subtotal
                        </span>
                        <span>
                            {{Number::currency($grand_total, 'IDR')}}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Taxes
                        </span>
                        <span>
                            {{Number::currency(0, 'IDR')}}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Shipping Cost
                        </span>
                        <span>
                            {{Number::currency(0, 'IDR')}}
                        </span>
                    </div>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Grand Total
                        </span>
                        <span>
                            {{Number::currency($grand_total, 'IDR')}}
                        </span>
                    </div>
                    </hr>
                </div>
                <button type="submit" class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                    <span wire:loading.remove>Place Order</span>
                    <span wire:loading>Processing.....</span>

                </button>
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        BASKET SUMMARY
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @foreach($cart_items as $cart )
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img alt={{$cart['name']}}" class="w-12 h-12 rounded-full" src="{{ url('storage', $cart['image'])}}">
                                    </img>
                                </div>
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{$cart['name']}}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        {{$cart['quantity']}}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{Number::currency($cart['total_amount'], 'IDR')}}
                                </div>
                            </div>
                        </li>
                        @endforeach


                    </ul>
                </div>
            </div>
        </div>
    </form>

</div>

<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800">
        <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
          <div class="flex flex-col md:flex-row items-center md:items-start -mx-4">
            <!-- Profile Avatar -->
            <div class="w-full md:w-1/3 lg:w-1/4 px-4 mb-8 md:mb-0">
              <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                <div class="mb-4">
                  <img class="w-24 h-24 rounded-full mx-auto" src="https://via.placeholder.com/150" alt="User Avatar">
                </div>
              </div>
            </div>
            <!-- Profile Information -->
            <div class="w-full md:w-2/3 lg:w-3/4 px-4 mb-8">
              <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Profile Information</h2>
                <div class="mb-4">
                  <label class="block text-gray-600 dark:text-gray-300">Name:</label>
                  <p class="text-gray-800 dark:text-gray-200">{{ $user->name }}</p>
                </div>
                <div class="mb-4">
                  <label class="block text-gray-600 dark:text-gray-300">Email:</label>
                  <p class="text-gray-800 dark:text-gray-200">{{ $user->email }}</p>
                </div>
              </div>
              <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                @if (session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
                @endif
                <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 md:mb-0">My Address</h2>
                    @if($myaddress)
                    <a href="/my-account/edit-address/{{$myaddress->id}}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4  rounded w-full md:w-auto">
                        Edit Address
                    </a>
                    @endif
                </div>
                @if($myaddress)
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label class="block text-gray-600 dark:text-gray-300">Full Name:</label>
                        <p class="text-gray-800 dark:text-gray-200">{{ $myaddress->first_name }}{{ $myaddress->last_name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600 dark:text-gray-300">Phone Number:</label>
                        <p class="text-gray-800 dark:text-gray-200">{{ $myaddress->phone }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600 dark:text-gray-300">Street Address:</label>
                        <p class="text-gray-800 dark:text-gray-200">{{ $myaddress->street_address }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600 dark:text-gray-300">Province:</label>
                        <p class="text-gray-800 dark:text-gray-200">{{ $myaddress->province }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600 dark:text-gray-300">City:</label>
                        <p class="text-gray-800 dark:text-gray-200">{{ $myaddress->city }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600 dark:text-gray-300">District:</label>
                        <p class="text-gray-800 dark:text-gray-200">{{ $myaddress->village }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600 dark:text-gray-300">Sub-District:</label>
                        <p class="text-gray-800 dark:text-gray-200">{{ $myaddress->village_district }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-600 dark:text-gray-300">Postal Code:</label>
                        <p class="text-gray-800 dark:text-gray-200">{{ $myaddress->zip_code }}</p>
                    </div>

                </div>
                @else
                <div class="w-full flex justify-center items-center">
                    <div class="mb-4 text-center bg-slate-100 p-6 md:p-10 rounded-lg shadow-lg">
                        <p class="text-gray-600">You have not added an address yet</p>
                        <a class="font-semibold hover:text-blue-500" href="/create-address">Add Address</a>
                    </div>
            @endif
            </div>

              <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Change Password</h2>
                @if (session()->has('status'))
                            <div class="text-green-500">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="text-red-500">
                                {{ session('error') }}
                            </div>
                        @endif
                <form wire:submit.prevent='updatePassword'>
                    <div class="grid gap-y-4">
                        <!-- Form Group -->
                        <div>
                            <label for="currentpassword" class="block text-sm mb-2 dark:text-white">Current Password</label>
                            <div class="relative md:max-w-96">
                                <input type="password" id="currentpassword" wire:model="currentpassword" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" aria-describedby="email-error">
                                <button type="button" data-hs-toggle-password='{"target": "#currentpassword"}' class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                    <svg class="flex-shrink-0 size-3.5 text-gray-400 dark:text-neutral-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                        <path class="hs-password-active:hidden" d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                        <path class="hs-password-active:hidden" d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                        <line class="hs-password-active:hidden" x1="2" x2="22" y1="2" y2="22"></line>
                                        <path class="hidden hs-password-active:block" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                        <circle class="hidden hs-password-active:block" cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                @error('currentpassword')
                                <div class="absolute inset-y-0 end-10 flex items-center pointer-events-none pe-3">
                                    <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                                @enderror
                            </div>
                            @error('currentpassword')
                            <p class=" text-red-600 mt-2" id="password-error">{{$message}}</p>
                            @enderror
                        </div>
                        <!-- End Form Group -->
                        <div>
                            <label for="newpassword" class="block text-sm mb-2 dark:text-white">New Password</label>
                            <div class="relative md:max-w-96">
                                <input type="password" id="newpassword" wire:model="newpassword" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" aria-describedby="email-error">
                                <button type="button" data-hs-toggle-password='{"target": "#newpassword"}' class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                    <svg class="flex-shrink-0 size-3.5 text-gray-400 dark:text-neutral-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                        <path class="hs-password-active:hidden" d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                        <path class="hs-password-active:hidden" d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                        <line class="hs-password-active:hidden" x1="2" x2="22" y1="2" y2="22"></line>
                                        <path class="hidden hs-password-active:block" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                        <circle class="hidden hs-password-active:block" cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                @error('newpassword')
                                <div class="absolute inset-y-0 end-10 flex items-center pointer-events-none pe-3">
                                    <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                                @enderror
                            </div>
                            @error('newpassword')
                            <p class=" text-red-600 mt-2" id="password-error">{{$message}}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="newpassword_confirmation" class="block text-sm mb-2 dark:text-white">Confirm Password</label>
                            <div class="relative md:max-w-96">
                              <input type="password" id="newpassword_confirmation" wire:model="newpassword_confirmation" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" aria-describedby="email-error">
                              <button type="button" data-hs-toggle-password='{"target": "#newpassword_confirmation"}' class="absolute top-0 end-0 p-3.5 rounded-e-md">
                                <svg class="flex-shrink-0 size-3.5 text-gray-400 dark:text-neutral-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                    <path class="hs-password-active:hidden" d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                    <path class="hs-password-active:hidden" d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                    <line class="hs-password-active:hidden" x1="2" x2="22" y1="2" y2="22"></line>
                                    <path class="hidden hs-password-active:block" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                    <circle class="hidden hs-password-active:block" cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                              @error('newpassword_confirmation')
                                <div class=" inset-y-0 end-10 flex items-center pointer-events-none pe-3">
                                    <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                  </div>
                                @enderror
                            </div>
                            @error('newpassword_confirmation')
                            <p class="text-xs text-red-600 mt-2" id="password_confirmation-error">{{$message}}</p>
                            @enderror
                        </div>

                        <button type="submit" class="md:max-w-80 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            Save password
                        </button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
       <!-- Change Password Modal -->

  </div>

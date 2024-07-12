<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\province;
use App\Models\addressuser;
use App\Models\subprovince;

class EditAddress extends Component
{
    public $myaddress_id;
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;

    public $province;
    public $city;
    public $village;
    public $village_district;
    public $postal_code;

    public $selectedProvince = null;
    public $selectedCity = null;
    public $selectedVillage = null;
    public $selectedVillageDistrict = null;
    public $selectedPostalcode = null;

    public function mount($myaddress_id)
    {
        if ($myaddress_id) {
            $address = addressuser::findOrFail($myaddress_id); // Replace with your user address model

            $this->first_name = $address->first_name;
            $this->last_name = $address->last_name;
            $this->phone = $address->phone;
            $this->street_address = $address->street_address;
            $this->selectedProvince = $address->province;
            $province = Province::where('province_name', $address->province)->first();
            if ($province) {
                $this->selectedProvince = $province->province_code;
            }
            $this->updatedSelectedProvince($this->selectedProvince);

            // Set the city and load villages based on the selected city
            $this->selectedCity = $address->city;
            $this->updatedSelectedCity($this->selectedCity);

            // Set the village and load village districts based on the selected village
            $this->selectedVillage = $address->village;
            $this->updatedSelectedVillage($this->selectedVillage);

            // Set the village district and load postal codes based on the selected village district
            $this->selectedVillageDistrict = $address->village_district;
            $this->updatedSelectedVillageDistrict($this->selectedVillageDistrict);

            // Set the postal code
            $this->selectedPostalcode = $address->zip_code;
        }

        $this->province = Province::all();

    }

    public function updatedSelectedProvince($province)
    {

        $this->city = subprovince::where('province_code', $province)->groupBy('city')
        ->pluck('city');

        $this->selectedCity = null;
        $this->selectedVillage = null;
        $this->selectedVillageDistrict = null;
        $this->selectedPostalcode = null;
    }
    public function updatedSelectedCity($city)
    {
        $this->village = Subprovince::where('city', $city)->groupBy('sub_district')
        ->pluck('sub_district');
        $this->selectedVillage = null;
        $this->selectedVillageDistrict = null;
        $this->selectedPostalcode = null;
    }

    public function updatedSelectedVillage($village)
    {
        $this->village_district = Subprovince::where('sub_district', $village)->groupBy('urban')
        ->pluck('urban');
        $this->selectedVillageDistrict = null;
        $this->selectedPostalcode = null;
    }
    public function updatedSelectedVillageDistrict($village_district)
    {
        $this->postal_code = Subprovince::where('urban', $village_district)->get();
    }
    public function update()
{
    $validatedData = $this->validate([
        'first_name' => 'required|string|max:30',
        'last_name' => 'required|string|max:30',
        'phone' => 'required|string|max:17',
        'street_address' => 'required|string|max:70',
        'selectedProvince' => 'required',
        'selectedCity' => 'required',
        'selectedVillage' => 'required',
        'selectedVillageDistrict' => 'required',
        'selectedPostalcode' => 'required',
    ], [
        'selectedVillage.required' => 'The selected district field is required.',
        'selectedVillageDistrict.required' => 'The selected sub-district field is required.',
    ]);

    $provinceName = Province::where('province_code', $validatedData['selectedProvince'])->first()->province_name;

    // Cari record berdasarkan ID
    $address = AddressUser::findOrFail($this->myaddress_id);

    // Update record dengan data yang divalidasi
    $address->update([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'phone' => $validatedData['phone'],
        'street_address' => $validatedData['street_address'],
        'province' => $provinceName,
        'city' => $validatedData['selectedCity'],
        'village' => $validatedData['selectedVillage'],
        'village_district' => $validatedData['selectedVillageDistrict'],
        'zip_code' => $validatedData['selectedPostalcode'],
        'user_id' => auth()->id(), // Assuming you want to associate the address with the currently authenticated user
    ]);

    // Redirect atau kirim pesan sukses
    return redirect()->to('/my-account')->with('message', 'Alamat berhasil diperbarui.');
}
    public function render()
    {

        return view('livewire.edit-address');
    }
}

<?php

namespace App\Livewire;

use App\Models\addressuser;
use Livewire\Component;
use App\Models\province;
use App\Models\subprovince;
use Illuminate\Support\Facades\Log;

class CreateAddress extends Component
{

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

    public function mount()
    {
        $this->province = Province::all();
    }

    public function updatedSelectedProvince($province)
    {

        $this->city = Subprovince::where('province_code', $province)->groupBy('city')
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

    public function submit()
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
        addressuser::create([
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
        // Kirim atau simpan data ke database
        return redirect()->to('/my-account')->with('message', 'Alamat berhasil disimpan.');
    }
    public function render()
    {
        return view('livewire.create-address');
    }

}

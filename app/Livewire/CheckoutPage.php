<?php

namespace App\Livewire;

use Exception;
use Stripe\Stripe;
use Midtrans\Config;
use App\Models\order;
use App\Models\address;
use Livewire\Component;
use App\Models\province;
use App\Models\addressuser;
use App\Models\subprovince;
use Illuminate\Http\Request;
use Midtrans\PaymentRequest;
use Stripe\Checkout\Session;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Providers\MidtransServiceProvider;

#[Title('Checkout - YuriGshop')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $province;
    public $village;
    public $village_district;
    public $postal_code;

    public $payment_method;

    public $selectedProvince = null;
    public $selectedCity = null;
    public $selectedVillage = null;
    public $selectedVillageDistrict = null;
    public $selectedPostalcode = null;

    public $useMyAddressToggle = false;
    public $hasAddress = false;
    public function mount(){

        $cart_items = CartManagement::getCartItemsFromCookie();
        if(count($cart_items) == 0){
            return redirect('/products');
            }
        $this->province = province::all();
        $this->hasAddress = AddressUser::where('user_id', Auth::id())->exists();

    }
    public function updatedUseMyAddressToggle()
    {
        if ($this->useMyAddressToggle) {
            $this->useMyAddress();
        } else {
            $this->resetForm();
        }
    }
    public function useMyAddress()
    {
        // Ganti ini dengan metode yang sesuai untuk mendapatkan alamat pengguna saat ini
        $address = addressuser::where('user_id', Auth::id())->firstOrFail();

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

    // Handle city selection and update villages
    $this->selectedCity = $address->city;
    $this->updatedSelectedCity($this->selectedCity);

    // Handle village selection and update village districts
    $this->selectedVillage = $address->village;
    $this->updatedSelectedVillage($this->selectedVillage);

    // Handle village district selection and update postal codes
    $this->selectedVillageDistrict = $address->village_district;
    $this->updatedSelectedVillageDistrict($this->selectedVillageDistrict);

    // Set the postal code
    $this->selectedPostalcode = $address->zip_code;
    }
    public function resetForm()
    {
        $this->first_name = null;
        $this->last_name = null;
        $this->phone = null;
        $this->street_address = null;
        $this->selectedProvince = null;
        $this->selectedCity = null;
        $this->selectedVillage = null;
        $this->selectedVillageDistrict = null;
        $this->selectedPostalcode = null;
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

    public function placeOrder(){

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'selectedProvince' => 'required',
            'selectedCity' => 'required',
            'selectedVillage' => 'required',
            'selectedVillageDistrict' => 'required',
            'selectedPostalcode' => 'required',
        ], [
            'selectedVillage.required' => 'The selected district field is required.',
            'selectedVillageDistrict.required' => 'The selected sub-district field is required.',
        ]);


        $cart_items = CartManagement::getCartItemsFromCookie();

        $line_items2 = array();
        $line_items2 = array_map(function ($item, $index) {
            $item_id = 'item' . ($index + 1); // Generate unique ID for each item

            return [
                'id' => $item_id,
                'price' => $item['unit_amount'] , // Convert to cents if not already in cents
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }, $cart_items, array_keys($cart_items));


        // Variabel $line_items sekarang sudah berisi array yang berisi item-item dengan struktur yang benar

        $order = new order();
        $order->user_id = auth()->id(); // Harusnya auth()->id()
        $order->grand_total = CartManagement::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'idr';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes = 'Order Placed by ' . auth()->user()->name;

        $provinceName = Province::where('province_code', $this->selectedProvince)->first()->province_name;
        $address = new address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->street_address;
        $address->province = $provinceName;
        $address->city = $this->selectedCity;
        $address->village = $this->selectedVillage;
        $address->village_district = $this->selectedVillageDistrict;
        $address->zip_code = $this->selectedPostalcode;

        $redirect_url = '';
        $order_id = uniqid();

       if ($this->payment_method == 'midtrans') {

            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false; // Set environment ke Sandbox untuk pengujian
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
            \Midtrans\Config::$overrideNotifUrl = route('payment.callback');
          // Gunakan ID yang unik
            $gross_amount = $order->grand_total; // Jumlah total transaksi dalam IDR

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order_id,
                    'gross_amount' => $gross_amount,

                ),
                'customer_details' => array(
                    'email' => auth()->user()->email,
                    'user_id' =>  auth()->id(),
                    'first_name'       => "$this->first_name",
                    'last_name'        => "$this->last_name",
                    'phone'            => $this->phone,
                ),
                'item_details' => $line_items2,
                'enabled_payments' =>  ['credit_card', 'bank_transfer', 'gopay', 'bca_klikbca', 'alfamart'],
                'callbacks' => array(
                    'callbacks' => array(
                        'finish' => route('success'),
                        'notification' => route('payment.callback')
                    )
            )

            );

            $snapResponse = \Midtrans\Snap::createTransaction($params);
            $paymentUrl = $snapResponse->redirect_url;
            $redirect_url = $paymentUrl;
        } else {
            // Handle other payment methods
            $redirect_url = route('success');
        }
        $order->id_pem = $order_id;
        $order->save();
        $address->order_id = $order->id;
        $address->save();
        $order->items()->createMany($cart_items);
        CartManagement::clearCartItems();
        return redirect($redirect_url);

    }
    public function handleMidtransCallback(Request $request)
    {
        // Ambil data notifikasi dari Midtrans
          // Ambil data dari query parameter
         // Ambil data notifikasi dari Midtrans
    $json = json_decode($request->getContent(), true);

    // Lakukan verifikasi status transaksi
    $transactionStatus = $json['transaction_status'];
    $midtransOrderId = $json['order_id']; // Ini adalah order_id dari Midtrans
    $signatureKey = $json['signature_key'];
    $orderId = $json['order_id'];
    $statusCode = $json['status_code'];
    $grossAmount = $json['gross_amount'];

    $serverKey = env('MIDTRANS_SERVER_KEY'); // Pastikan server key diambil dari environment
    $calculatedSignatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

    if ($signatureKey !== $calculatedSignatureKey) {
        return response()->json(['status' => 'error', 'message' => 'Signature verification failed.'], 403);
    }

    // Misalnya, update status order menjadi 'paid' jika order_id dari Midtrans sama dengan id di database
    $order =order::where('id_pem', $midtransOrderId)->first();
    if ($order) {
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $order->payment_status = 'paid';
           // Atau status lain yang sesuai
        } else if ($transactionStatus == 'pending') {
            $order->payment_status = 'pending';

        } else if ($transactionStatus == 'deny' || $transactionStatus == 'cancel' || $transactionStatus == 'expire') {
            $order->payment_status = 'failed';
            // Atau status lain yang sesuai
        } else {
            $order->payment_status = 'unknown';

        }
        $order->save();
    }

    // Response 200 OK ke Midtrans
    return response()->json(['status' => 'OK'], 200);

    }

    public function afterPayment(Request $request)
    {
        // Ambil data dari query parameter
        $transactionStatus = $request->query('transaction_status');
        $midtransOrderId = $request->query('order_id'); // Ini adalah order_id dari Midtrans

        // Misalnya, update status order menjadi 'paid' jika order_id dari Midtrans sama dengan id di database
        $order = order::where('id_pem', $midtransOrderId)->first();

        if ($order) {
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {

                return redirect()->route('success');
            } else {
                return redirect()->route('cancel');
            }
        } else {
            // Jika order tidak ditemukan, arahkan ke halaman cancel
            return redirect()->route('cancel');
        }
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        return view('livewire.checkout-page', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total
        ]);
    }
}

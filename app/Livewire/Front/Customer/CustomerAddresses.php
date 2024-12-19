<?php

namespace App\Livewire\Front\customer;
use App\Models\Address;
use Livewire\Component;
use App\Models\OrderAddress;

class CustomerAddresses extends Component
{
    public $showForm = false;
    public $editMode = false;
    public $address_id = '';
    public $address_title = '';
    public $default_address = '';
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $mobile = '';
    public $address = '';
    public $address2 = '';
    public $countries;
    public $states = [];
    public $cities = [];
    public $country_id;
    public $state_id;
    public $city_id;
    public $zip_code = '';
    public $po_box = '';
    protected $rules = [
        'address_line_1' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'zip_code' => 'required|string|max:20',
    ];

    public function mount()
    {
        $this->loadAddresses();
    }

    public function loadAddresses()
    {
        $this->addresses = auth()->user()->addresses;
    }

    public function store()
    {
        $this->validate();

        auth()->user()->addresses()->create([
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zip_code' => $this->zip_code,
        ]);

        $this->resetForm();
        $this->loadAddresses();

        session()->flash('success', 'Address added successfully!');
    }

    public function edit($id)
    {
        $address = OrderAddress::findOrFail($id);
        $this->addressId = $address->id;
        $this->address_line_1 = $address->address_line_1;
        $this->address_line_2 = $address->address_line_2;
        $this->city = $address->city;
        $this->state = $address->state;
        $this->country = $address->country;
        $this->zip_code = $address->zip_code;
    }

    public function update()
    {
        $this->validate();

        $address = OrderAddress::findOrFail($this->addressId);
        $address->update([
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zip_code' => $this->zip_code,
        ]);

        $this->resetForm();
        $this->loadAddresses();

        session()->flash('success', 'Address updated successfully!');
    }

    public function delete($id)
    {
        $address = OrderAddress::findOrFail($id);
        $address->delete();

        $this->loadAddresses();

        session()->flash('success', 'Address deleted successfully!');
    }

    private function resetForm()
    {
        $this->addressId = null;
        $this->address_line_1 = '';
        $this->address_line_2 = '';
        $this->city = '';
        $this->state = '';
        $this->country = '';
        $this->zip_code = '';
    }

    public function render()
    {
        return view('livewire.front.customer.customer-addresses');
    }
}
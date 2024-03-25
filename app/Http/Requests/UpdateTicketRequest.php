<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'display_name' => ['required', 'string'],
            'status' => ['required', 'boolean'],
            'type' => ['required', 'integer'],
            'pass_type' => ['required', 'integer'],
            'location_id' => ['required', 'exists:locations,id'],
            'description' => ['nullable', 'string'],
            'display_description' => ['nullable', 'string'],
            'category_ids' => ['required', 'array'],
            'term_and_condition_id' => ['nullable', 'exists:terms_and_conditions,id'],
            'weekend_price' => ['nullable', 'numeric'],
            'weekday_price' => ['nullable', 'numeric'],
            'start_date_time' => ['required', 'date'],
            'end_date_time' => ['required', 'date'],
            'play_time' => ['required', 'array'],
            'play_time_till_close' => ['nullable', 'boolean'],
            'advance_payment' => ['nullable', 'numeric'],
            'tax' => ['nullable', 'numeric'],
            'btn_img' => ['nullable', 'string'],
            'max_sale_per_order' => ['nullable', 'integer'],
            'min_sale_per_order' => ['nullable', 'integer'],
            'pos' => ['nullable', 'boolean'],
            'one_bill_per_item' => ['nullable', 'boolean'],
            'sell_and_register_customer' => ['nullable', 'boolean'],
            'order_locked' => ['nullable', 'boolean'],
            'custom_price' => ['nullable', 'boolean'],
            'print_as_ticket' => ['nullable', 'boolean'],
            'print_tc_on_ticket' => ['nullable', 'boolean'],
            'tc_on_ticket_description' => ['nullable', 'boolean'],
            'add_guests' => ['nullable', 'boolean'],
            'guests' => ['required_if:add_guests,==,true', 'array'],
            'guests.*.guest_age_from' => ['required_if:add_guests,==,true', 'integer'],
            'guests.*.guest_age_to' => ['required_if:add_guests,==,true', 'integer'],
            'guests.*.guest_condition' => ['required_if:add_guests,==,true', 'integer'],
            'guests.*.allowed_guests' => ['required_if:add_guests,==,true', 'integer'],
        ];
    }
}

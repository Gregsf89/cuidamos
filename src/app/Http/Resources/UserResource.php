<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'user_info';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                self::$wrap => [
                    'id' => $this->user_id,
                    'account_id' => $this->user->account_id ?? null,
                    'email' => $this->user->email ?? null,
                    'uid' => $this->user->uid ?? null,
                    'phone' => $this->user->phone ?? null,
                    'state' => $this->city->state->name ?? null,
                    'city' => $this->city->name ?? null,
                    'gender' => $this->gender->name ?? null,
                    'document' => $this->document,
                    'uuid' => $this->uuid,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'address' => $this->address,
                    'zip_code' => $this->zip_code,
                    'date_of_birth' => $this->date_of_birth,
                    'address_complement' => $this->address_complement
                ]
            ];
    }
}

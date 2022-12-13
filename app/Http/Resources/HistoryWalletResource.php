<?php

namespace App\Http\Resources;

use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryWalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'pay_to_user' => $this->senderWalletUsers->map(function($e){
                return [
                    'id' => $e->id,
                    'amount' => intval($e->amount),
                    'to' => new UserNestedResource(User::find($e->user_id)),
                    'description' => $e->description,
                    'date_send' => $e->created_at->format('Y-m-d')
                ];
            }),
            'charge' => $this->reseverWalletUsers->map(function($e){
                return [
                    'id' => $e->id,
                    'amount' => intval($e->amount),
                    'description' => $e->description,
                    'date_charge' => $e->created_at->format('Y-m-d')
                ];
            }), 
            'pay_to_category' => $this->walletSubCategores->map(function($e){
                return [
                    'id' => $e->id,
                    'amount' => intval($e->balance),
                    'to' => new SubCategoryResource(SubCategory::find($e->sub_category_id)),
                    'description' => $e->description,
                    'date_send' => $e->created_at->format('Y-m-d')
                ];
            }), 
        ];
    }
}

<?php

namespace App\Transformers;

use App\Models\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int)$buyer->id,
            'name' => (string)$buyer->name,
            'email' => (string)$buyer->email,
            'isVerified' => (string)$buyer->verified,
            'creationDate' => (string)$buyer->created_at,
            'lastChange' => (string)$buyer->updated_at,
            'deletedDate' => isset($buyer->delete_at) ? (string) $buyer->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => "name",
            'email' => "email",
            'isVerified' => "s",
            'creationDate' => "created_at",
            'lastChange' => "updated_at",
            'deletedDate' => "delete_at",
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}

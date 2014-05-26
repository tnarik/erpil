<?php

class Customer extends Eloquent {

	protected $fillable = array('name', 'surname', 'email', 'verified', 'address',
		'phone', 'comment', 'payment_next_date', 'payment_method', 'customer_id', 'card_id');

	public function events()
	{
		return $this->hasMany('CardEvent', 'card_id', 'card_id');
	}

	public static function boot()
    {
        parent::boot();
 
        static::deleting(function($customer)
        {
        	$customer->events()->delete();
        });
    }

    public static function filter($filter = null)
    {
    	switch ($filter) {
    		case "unverified":
  				return Customer::whereVerified(false);
  				break;
  			case "pending_payment":
				return Customer::whereVerified(true)
					->whereNull('payment_next_date')
					->orWhere('payment_next_date', '<', date('Y-m-d'));
				break;
			case "pending_books":
				//check if the number of book events is pair! come on! that's silly
				$cardEvents = CardEvent::whereFacilityId(Facility::whereCode('LIBRARY')->first()->id)
					->groupBy('card_id')->havingRaw("(events_number % 2) != 0")
					->get(array('card_id', DB::raw('count(*) as events_number')));
				$card_ids = array_pluck($cardEvents, 'card_id');
				return Customer::whereIn('card_id', $card_ids);
			  	break;
			default:
				return Customer::query();
				break;
		}
    }

    public static function searchAndPaginate($search, $filter = null, $perPage = null)
    {
    	$query = Customer::filter($filter);
 
    	if ( $search ) {
			$query = $query->where('name', 'like', "%{$search}%")->orWhere('surname', 'like', "%{$search}%");
		}

		return $query->paginate($perPage);
    }
}

//->select(DB::raw('count(*) as user_count, status'))
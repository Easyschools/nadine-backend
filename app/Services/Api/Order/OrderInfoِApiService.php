<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 07/12/20
 * Time: 04:21 م
 */

namespace App\Services\Order;



use App\Models\Order\Order;
use App\Models\User\User;
use App\Repositories\AppRepository;
use App\Traits\FirebaseFCM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OrderInfoِApiService extends AppRepository
{
    use FirebaseFCM;
    private $assigned = null;

    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function index($request = null)
    {
        $this->handleUserType();

        $user = Auth::user();

        if ($user->type != 4) {
            $this->setSortOrder('asc');
            $this->setSortBy('is_assigned');
        } else {

            $this->setSortOrder('desc');
        }

        $this->setRelations([
            'items' => function ($item) {
                $item->select('id', 'service_model_id', 'order_id', 'item_cost')
                    ->with([
                        'serviceModel' => function ($serviceModel) use ($item) {
                            $serviceModel->with([
                                'orderItemServiceSpareParts' => function ($spare_part) use ($item) {
                                    $spare_part->whereIn('order_item_id', $item->pluck('id')->toArray());
                                },
                            ]);
                        }
                    ]);
            },
            'car' => function ($car) {
                $car->select('id', 'note', 'cc', 'default', 'year_id', 'model_id', 'manufacturer_id')
                    ->with(
                        'manufacturer:id,name_en,name_ar,image,active',
                        'model:id,name_en,name_ar,image,active',
                        'year:id,year,model_id,cc,active'
                    );
            },
            'operator' => function ($operator) {
                $operator->select('id', 'technician_id', 'assigned_id', 'order_id')
                    ->with(
                        'technician:id,name,phone,type',
                        'assigned:id,name,phone,type'
                    );
            },
            'slot:id,end,start,active',
            'waitingSlot:id,end,start,active',
            'alternativeSlot:id,end,start,active',
            'review',
            'address' => function ($address) {
                $address->with(
                    'area',
                    'region'
                );
            },
            'paymentType'
        ]);
        $this->setColumns([
            'is_assigned',
            'id',
            'slot_id',
            'alternative_slot_id',
            'waiting_slot_id', 'payment_type_id', 'subtotal', 'address_id', 'code',
            'tax', 'coupon_price', 'grand_total', 'car_id', 'status', 'day',
            'discount_value',
            'waiting_day',
            'created_at'
        ]);

        $operator_ids = Operator::pluck('order_id');

        if ($this->assigned == 1) {
            $this->setRelatedIds('id', $operator_ids->toArray());
            return $this->paginateInOrder();

        } elseif ($this->assigned == "0") {
            $this->setRelatedIds('id', $operator_ids->toArray());
            return $this->paginateNotInOrder();
        }

        if ($request && $request->waiting_orders) {

            $this->setNotNullColumn('waiting_slot_id');
            return $this->OrderPaginator();
        }

        return $this->OrderPaginator();
    }


    /**
     * it gets all user for making complains
     *
     * @param null $request
     * @return mixed
     */
    public function getOrdersForComplains($request = null)
    {
        $this->handleUserType();
        $this->setSortOrder('asc');
        $this->setSortBy('is_assigned');
        $this->setColumns([
            'code',
            'id'
        ]);

        return $this->all();
    }

    private function handleUserType()
    {
        $user = Auth::User()->load(
            'workArea:id,area_id,user_id',
            'workAreas:id,area_id,user_id'
        );
        switch ($user->type) {
            case 4:
                $this->model = $this->model
                    ->where('user_id', $user->id);
                break;
            case 3:
                $this->model =
                    $this->model
                        ->whereNotIn('status', [4, 9])
                        ->where('day', date('Y-m-d'))
                        ->whereHas('operator', function ($operator) use ($user) {
                            $operator->where('technician_id', $user->id);
                        });
                break;
            case 2:
                $this->model =
                    $this->model
                        ->whereHas('address', function ($address) use ($user) {
                            $areas = $user->workArea()->pluck('area_id')->toArray();
                            $address->whereIn('area_id', $areas);
                        });
                break;
            default:
                return;
        }
    }

    public function getUserOrders(Request $request)
    {
        // Return user's orders ---> just for technician and customer

        $user = User::find($request->user_id);
        switch ($user->type) {
            case 4:
                $this->model = $this->model->where('user_id', $user->id);
                break;
            case 3:
                $this->model =
                    $this->model
                        ->whereHas('operator', function ($operator) use ($user) {
                            $operator->where('technician_id', $user->id);
                        });
                break;
            default:
                return;
        }

        $this->setRelations([
            'id', 'slot_id', 'order_address', 'order_car', 'subtotal',
            'tax', 'coupon_price', 'grand_total', 'car_id',
            'user_id', 'coupon_id', 'address_id', 'status',
            'note', 'day', 'created_at', 'updated_at'
        ]);
        $this->setRelations([
            'items' => function ($item) {
                $item->select('id', 'service_model_id', 'order_id', 'item_cost', 'order_item_labour_price')
                    ->with([
                        'serviceModel' => function ($serviceModel) use ($item) {
                            $serviceModel->with([
                                'orderItemServiceSpareParts' => function ($spare_part) use ($item) {
                                    $spare_part->whereIn('order_item_id', $item->pluck('id')->toArray());
                                },
                            ]);
                        }
                    ]);
            },
            'car' => function ($car) {
                $car->select('id', 'note', 'cc', 'default', 'year_id', 'model_id', 'manufacturer_id')
                    ->with(
                        'manufacturer:id,name_en,name_ar,image,active',
                        'model:id,name_en,name_ar,image,active',
                        'year:id,year,model_id,cc,active'
                    );
            }
            ,
            'operator' => function ($operator) {
                $operator->select('id', 'technician_id', 'assigned_id', 'order_id')
                    ->with([
                        'technician' => function ($technician) {
                            $technician->select('id', 'name', 'phone', 'type');
                        },
                        'assigned:id,name,phone,type'
                    ]);
            },
            'slot:id,end,start,active',
            'customer:id,name,phone,type',
            'PaymentType',
        ]);
        return $this->all();
    }

    public function get($id)
    {
        $this->handleUserType();

        $this->setRelations([
            'id', 'slot_id', 'order_address', 'order_car', 'subtotal',
            'tax', 'coupon_price', 'grand_total', 'car_id',
            'user_id', 'coupon_id', 'address_id', 'status',
            'note', 'day', 'created_at', 'updated_at', 'discount_value'
        ]);
        $this->setRelations([
            'items' => function ($item) {
                $item->select('id', 'service_model_id', 'order_id', 'item_cost', 'order_item_labour_price')
                    ->with([
                        'serviceModel' => function ($serviceModel) use ($item) {
                            $serviceModel->with([
                                'orderItemServiceSpareParts' => function ($spare_part) use ($item) {
                                    $spare_part->whereIn('order_item_id', $item->pluck('id')->toArray());
                                },
                            ]);
                        }
                    ]);
            },
            'car' => function ($car) {
                $car->select('id', 'note', 'cc', 'default', 'year_id', 'model_id', 'manufacturer_id')
                    ->with(
                        'manufacturer:id,name_en,name_ar,image,active',
                        'model:id,name_en,name_ar,image,active',
                        'year:id,year,model_id,cc,active'
                    );
            },
            'operator' => function ($operator) {
                $operator->select('id', 'technician_id', 'assigned_id', 'order_id')
                    ->with(
                        'technician:id,image,name,phone,type',
                        'assigned:id,name,phone,type'
                    );
            },
            'review',
            'feedback',
            'address',
            'slot:id,end,start,active',
            'waitingSlot:id,end,start,active',
            'alternativeSlot:id,end,start,active',
            'customer:id,image,name,phone,type',
            'PaymentType',
        ]);

        return $this->find($id);
    }

    public function getSlots($request)
    {
        $order = Order::findOrFail($request->order_id);

        $d = [];
        $d['alternative_slot']['start'] = ' alternative ' . $order->alternativeSlot->start;
        $d['alternative_slot']['end'] = $order->alternativeSlot->end . ' ' . $order->day;
        $d['alternative_slot']['id'] = $order->alternativeSlot->id;
        if ($order->WaitingSlot)
            $d['waiting_slot']['start'] = ' waiting ' . $order->WaitingSlot->start;
        else {
            $d['waiting_slot']['start'] = ' waiting  error';

        }
        $d['waiting_slot']['end'] = $order->WaitingSlot->end . ' ' . $order->waiting_day;
        $d['waiting_slot']['id'] = $order->WaitingSlot->id;

        return $d;
    }


    /**
     * @param $request
     * @return bool
     */
    public function confirmSlots($request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->update([
            'slot_id' => $request->slot_id,
            'status' => 2,
            'waiting_slot_id' => null,
            'waiting_day' => null,
        ]);

        return true;
    }


    public function statusStatistics()
    {
        $result = [];
        $orderStatus = new \ReflectionClass(new OrderStatus());
        $statuses = array_flip($orderStatus->getConstants());
//        $this->handleUserType();
        $user = Auth::User()->load(
            'workArea:id,area_id,user_id',
            'workAreas:id,area_id,user_id'
        );
        foreach ($statuses as $num => $status) {
            switch ($user->type) {
                case 2:
                    $result[$status] =
                        $this->model
                            ->whereHas('address', function ($address) use ($user) {
                                $areas = $user->workArea()->pluck('area_id')->toArray();
                                $address->whereIn('area_id', $areas);
                            })->where('status', $num)->count();
                    break;
                default :
                    $result[$status] = $this->model->where('status', $num)->count();
            }

        }
        return $result;
    }

    public function filter(Request $request)
    {
        $conditions = [];
        if ($request->status) {
            $conditions[] = ['status', $request->status];
        }
        if ($request->slot_id) {
            $conditions[] = ['slot_id', $request->slot_id];
        }
        if ($request->from) {
            $to = ($request->to) ? $request->to : date('Y-m-d');

            $conditions[] = ['day', '>=', $request->from];

            $conditions[] = ['day', '<=', $to];
        }
        if ($request->code) {
            $conditions[] = ['code', 'LIKE', '%' . $request->code . '%'];
        }


        $this->setConditions($conditions);


        $this->assigned = isset($request->assigned) ? $request->assigned : null;


        return $this->index($request);


    }
}

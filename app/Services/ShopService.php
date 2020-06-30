<?php

namespace App\Services;

use App\Models\Shop;
use App\Models\User;
use App\Models\UserProp;
use Illuminate\Support\Facades\DB;

class ShopService extends Service
{
    public function getShopInfo($shopId)
    {
        return Shop::query()->find($shopId);
    }

    public function buyShopResult(User $user, $shopId)
    {
        $shop = $this->getShopInfo($shopId);
        DB::beginTransaction();
        try {
            if ($shop->price_type == 1) {
                $money = $user->manpower;
                if ($money > $shop->price) {
                    User::query()->where('id', $user->id)->where('manpower', $money)->update([
                        'manpower' => $money - $shop->price,
                    ]);

                    $this->syncUserProp($shop);

                    DB::commit();
                    return true;
                }
            } else {
                $money = $user->current_gold;
                if ($money > $shop->price) {
                    User::query()->where('id', $user->id)->where('current_gold', $money)->update([
                        'current_gold' => $money - $shop->price,
                    ]);

                    $this->syncUserProp($shop);

                    DB::commit();
                    return true;
                }
            }

            return false;
        } catch (\Exception $exception) {
            DB::rollBack();
            logger()->error("用户id：{$user->id} 购买商品异常：" . $exception->getMessage());
            return false;
        }
    }

    public function syncUserProp(Shop $shop)
    {
        UserProp::query()->create([
            'name' => $shop->name,
            'lower' => $shop->lower,
            'upper' => $shop->upper,
            'type' => $shop->type,
            'shop_id' => $shop->id,
        ]);
    }
}

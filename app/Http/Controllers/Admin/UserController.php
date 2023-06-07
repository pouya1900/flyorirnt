<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\User;
use App\Models\Balance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function users()
    {

        $users = User::all();

        return view('admin.user.index', compact('users'));

    }


    public function edit(User $user)
    {
        $country = Country::all();
        return view('admin.user.edit', compact('user', 'country'));

    }


    public function update(User $user, UpdateUserRequest $request)
    {

        unset($request["submit"]);

        $user->update($request->all());

        if ($user->role == User::agency) {
            if (!$user->balance) {
                $balance = Balance::create(["balance" => 0]);
                $user->update(["balance_id" => $balance->id]);
            }
        }

        return redirect()->route('admin.users')->with('message', 'user updated successfully');

    }

    public function delete(Request $request)
    {

        $id = $request->id;

        $user = User::find($id);

        if ($user instanceof User) {
            $user->delete();

            return redirect()->route('admin.users')->with('message', 'user deleted successfully');
        } else {
            return redirect()->route('admin.users')->with('message', 'user not found');
        }


    }

    public function agencies()
    {
        $users = User::where('role', User::agency)->get();

        return view('admin.agencies.index', compact('users'));
    }

    public function agency(User $user)
    {
        $books = $user->books()->where('status', '!=', 'booking')->wherehas('payments', function ($q) {
            return $q->where('method', 'agency');
        })->orderBy('updated_at', 'desc')->get();
        return view('admin.agencies.show', compact('user', 'books'));
    }

    public function agency_update(User $user, Request $request)
    {
        $user->balance()->update([
            'discount_adult'    => $request->input('discount_adult'),
            'discount_child'    => $request->input('discount_child'),
            'discount_infant'   => $request->input('discount_infant'),
            'commission_adult'  => $request->input('commission_adult'),
            'commission_child'  => $request->input('commission_child'),
            'commission_infant' => $request->input('commission_infant'),
            'amount'            => $request->input('balance'),
        ]);

        $user->update([
            'active'  => $request->input('active') ? 1 : 0,
            'code'    => $request->input('code'),
            'address' => $request->input('address'),
            'site'    => $request->input('site'),
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            Storage::disk('upload')->put('images/agency', $file);

            $user->update([
                'logo' => "agency/" . $file->hashName(),
            ]);
        }
        return redirect(route('admin.agency.show', $user->id));

    }

    public function complete_payment(User $user, Payment $payment)
    {
        if ($payment->method == "agency" && $payment->status == "APPROVED") {
            $payment->update(['status' => "COMPLETED"]);

            $amount = $payment->before_balance - $payment->after_balance;

            $balance = $user->balance->amount;

            $user->balance->update(['amount' => $balance + $amount]);

        }

        return redirect()->back();
    }

}

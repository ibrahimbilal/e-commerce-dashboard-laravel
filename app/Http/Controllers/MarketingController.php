<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view marketing', ['only' => ['index']]);
        $this->middleware('permission:add marketing', ['only' => ['store']]);
        $this->middleware('permission:edit marketing', ['only' => ['update']]);
        $this->middleware('permission:delete marketing', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'subscribers'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Subscriber::query()->count(),
            'subscribers' => Subscriber::query()->where('is_subscriber', true)->count(),
            'not_subscribers' => Subscriber::query()->where('is_subscriber', false)->count(),
        ];

        $query = Subscriber::query()->with('customer')->latest('id');

        if ($request->query('subscribers') === '1') {
            $query->where('is_subscriber', true);
        } elseif ($request->query('subscribers') === '0') {
            $query->where('is_subscriber', false);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('email', 'like', '%'.$search.'%')
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('email', 'like', '%'.$search.'%')
                            ->orWhere('first_name', 'like', '%'.$search.'%')
                            ->orWhere('last_name', 'like', '%'.$search.'%');
                    });
            });
        }

        $subscribers = $query->get();

        return view('marketing.index', compact('subscribers', 'counts', 'filters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:100', 'unique:subscribers_list,email'],
            'is_subscriber' => ['nullable', 'boolean'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
        ]);

        Subscriber::query()->create([
            'email' => $data['email'],
            'customer_id' => $data['customer_id'] ?? null,
            'is_subscriber' => $data['is_subscriber'] ?? true,
            'token' => null,
        ]);

        return redirect()->route('marketing.index')->with('status', 'Subscriber created.');
    }

    public function update(Request $request, Subscriber $subscriber)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:100', 'unique:subscribers_list,email,'.$subscriber->id],
            'is_subscriber' => ['nullable', 'boolean'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
        ]);

        $subscriber->update([
            'email' => $data['email'],
            'customer_id' => $data['customer_id'] ?? null,
            'is_subscriber' => $data['is_subscriber'] ?? $subscriber->is_subscriber,
        ]);

        return redirect()->route('marketing.index')->with('status', 'Subscriber updated.');
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('marketing.index')->with('status', 'Subscriber removed.');
    }
}

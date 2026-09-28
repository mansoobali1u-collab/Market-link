@extends('layouts.farmer')

@section('title', 'Customer Reviews')

@section('content')

    <div class="mb-8">
        <h1 class="font-display text-3xl" style="color: var(--ink);">Customer reviews</h1>
        <p class="text-sm mt-1" style="color: var(--ink-soft);">See what customers are saying about your products.</p>
    </div>

    @forelse ($reviews as $review)
        <div class="rounded-lg p-5 mb-4" style="background: var(--card); border: 1px solid var(--line);">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <p class="font-medium" style="color: var(--ink);">{{ $review->product->name }}</p>
                <span style="color: var(--gold);">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
            </div>
            <p class="text-sm mt-1" style="color: var(--ink-soft);">
                by {{ $review->customer->name ?? $review->customer->username }}
                on {{ $review->review_date->format('M d, Y') }}
            </p>
            <p class="mt-3 text-sm" style="color: var(--ink);">{{ $review->comment }}</p>

            @if ($review->farmer_response)
                <div class="mt-4 pl-4 py-1" style="border-left: 3px solid var(--leaf);">
                    <p class="text-sm font-medium" style="color: var(--leaf-dark);">Your response</p>
                    <p class="text-sm mt-1" style="color: var(--ink-soft);">{{ $review->farmer_response }}</p>
                </div>
            @else
                <form method="POST" action="{{ route('farmer.reviews.respond', $review->review_id) }}" class="mt-4">
                    @csrf
                    <textarea name="farmer_response" rows="2" class="field" placeholder="Write a response..."></textarea>
                    <button type="submit" class="mt-2 px-4 py-1.5 rounded-lg text-sm font-medium btn-primary">
                        Post response
                    </button>
                </form>
            @endif
        </div>
    @empty
        <div class="rounded-lg p-10 text-center" style="background: var(--card); border: 1px solid var(--line);">
            <p class="font-medium" style="color: var(--ink);">No reviews yet</p>
            <p class="text-sm mt-1" style="color: var(--ink-soft);">Customer reviews on your products will show up here.</p>
        </div>
    @endforelse

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>

@endsection

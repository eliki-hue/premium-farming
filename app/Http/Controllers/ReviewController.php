<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Display customer reviews.
     */
    public function index()
    {
        try {

            $baseUrl = rtrim(config('services.backend.url'), '/');

            /*
            |--------------------------------------------------------------------------
            | Get All Reviews
            |--------------------------------------------------------------------------
            */

            $reviewsResponse = Http::acceptJson()
                ->timeout(20)
                ->get($baseUrl . '/api/ecommerce/reviews/');

            /*
            |--------------------------------------------------------------------------
            | Get Featured Reviews
            |--------------------------------------------------------------------------
            */

            $featuredResponse = Http::acceptJson()
                ->timeout(20)
                ->get($baseUrl . '/api/ecommerce/reviews/', [
                    'featured' => 'true'
                ]);

            if (
                !$reviewsResponse->successful() ||
                !$featuredResponse->successful()
            ) {
                throw new \Exception('Unable to load reviews.');
            }

            $reviewsData = $reviewsResponse->json();
            $featuredData = $featuredResponse->json();

            /*
            |--------------------------------------------------------------------------
            | DRF Pagination
            |--------------------------------------------------------------------------
            */

            $reviews = collect($reviewsData['results'] ?? []);

            $featuredReviews = collect(
                $featuredData['results'] ?? []
            );

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            $totalReviews = $reviewsData['count'] ?? 0;

            $averageRating = round(
                $reviews->avg('rating') ?? 0,
                1
            );

            $fiveStar = $reviews->where('rating', 5)->count();
            $fourStar = $reviews->where('rating', 4)->count();
            $threeStar = $reviews->where('rating', 3)->count();
            $twoStar = $reviews->where('rating', 2)->count();
            $oneStar = $reviews->where('rating', 1)->count();

            /*
            |--------------------------------------------------------------------------
            | Pagination Links
            |--------------------------------------------------------------------------
            */

            $nextPage = $reviewsData['next'] ?? null;
            $previousPage = $reviewsData['previous'] ?? null;

            return view(
                'reviews',
                compact(
                    'reviews',
                    'featuredReviews',
                    'totalReviews',
                    'averageRating',
                    'fiveStar',
                    'fourStar',
                    'threeStar',
                    'twoStar',
                    'oneStar',
                    'nextPage',
                    'previousPage'
                )
            );

        } catch (\Throwable $e) {

            Log::error('Review API Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return view(
                'reviews',
                [
                    'reviews' => collect(),
                    'featuredReviews' => collect(),
                    'totalReviews' => 0,
                    'averageRating' => 0,
                    'fiveStar' => 0,
                    'fourStar' => 0,
                    'threeStar' => 0,
                    'twoStar' => 0,
                    'oneStar' => 0,
                    'nextPage' => null,
                    'previousPage' => null,
                    'error' => 'Unable to load customer reviews at the moment.',
                ]
            );
        }
    }

    /**
     * Submit Review
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_location' => 'required|string|max:255',
            'farm_type' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:5000',
        ]);

        try {

            $baseUrl = rtrim(config('services.backend.url'), '/');

            $response = Http::acceptJson()
                ->timeout(20)
                ->post(
                    $baseUrl . '/api/ecommerce/reviews/',
                    $validated
                );

            if ($response->successful()) {

                return redirect()
                    ->back()
                    ->with(
                        'success',
                        'Thank you for your review. It has been submitted for approval.'
                    );
            }

            $message = 'Unable to submit your review.';

            if ($response->json('detail')) {
                $message = $response->json('detail');
            }

            return redirect()
                ->back()
                ->withErrors([
                    'review' => $message
                ])
                ->withInput();

        } catch (\Throwable $e) {

            Log::error('Review Submission Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->withErrors([
                    'review' => 'Unable to connect to the review service.'
                ])
                ->withInput();
        }
    }
}
<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quote\StoreQuoteRequest;
use App\Http\Requests\Quote\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
class QuoteController extends Controller {
    public function __construct(private readonly QuoteService $quoteService) {}
    public function index(Request $request): AnonymousResourceCollection {
        return QuoteResource::collection($this->quoteService->getAll((int)$request->query('per_page',15)));
    }
    public function featured(Request $request): AnonymousResourceCollection {
        return QuoteResource::collection($this->quoteService->getFeatured((int)$request->query('per_page',15)));
    }
    public function random(): JsonResponse {
        $quote = $this->quoteService->getRandom();
        if (!$quote) return response()->json(['message'=>'No quotes available.'],404);
        return response()->json(['data'=>new QuoteResource($quote)]);
    }
    public function store(StoreQuoteRequest $request): JsonResponse {
        $quote = $this->quoteService->create(array_merge($request->validated(),['user_id'=>$request->user()?->id]));
        return response()->json(['message'=>'Quote created successfully.','data'=>new QuoteResource($quote)],201);
    }
    public function show(int $id): JsonResponse {
        return response()->json(['data'=>new QuoteResource($this->quoteService->findById($id)->load(['author','category']))]);
    }
    public function update(UpdateQuoteRequest $request, int $id): JsonResponse {
        return response()->json(['message'=>'Quote updated successfully.','data'=>new QuoteResource($this->quoteService->update($id,$request->validated()))]);
    }
    public function destroy(int $id): JsonResponse {
        $this->quoteService->delete($id);
        return response()->json(['message'=>'Quote deleted successfully.']);
    }
}

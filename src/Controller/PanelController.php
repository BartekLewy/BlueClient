<?php

namespace BlueClient\Controller;

use App\Http\Controllers\Controller;
use BlueClient\Application\ApiDataProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

/**
 * Class PanelController
 * @package BlueClient\Controller
 */
class PanelController extends Controller
{
    /**
     * @var ApiDataProvider
     */
    private $apiDataProvider;

    /**
     * PanelController constructor.
     * @param ApiDataProvider $apiDataProvider
     */
    public function __construct(ApiDataProvider $apiDataProvider)
    {
        $this->apiDataProvider = $apiDataProvider;
    }

    /**
     * @return Response
     */
    public function index(): View
    {
        $items = $this->apiDataProvider->findAllItems();
        return view('blue::panel', compact('items'));
    }

    public function remove(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
           return new JsonResponse($this->apiDataProvider->remove($request->id));
        }
    }
}
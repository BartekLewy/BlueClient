<?php

namespace BlueClient\Controller;

use App\Http\Controllers\Controller;
use BlueClient\Application\ApiDataProvider;
use BlueClient\Application\Exception\ItemNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @return View
     */
    public function index(): View
    {
        $items = $this->apiDataProvider->findAllItems();
        return view('blue::panel', compact('items'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function remove(Request $request): RedirectResponse
    {
        try {
            $response = $this->apiDataProvider->remove($request->id);
            $request->session()->flash('success', $response['message']);
        } catch (ItemNotFoundException $exception) {
            $request->session()->flash('error', $exception->getMessage());
        }

        return redirect()->route('panel');
    }
}
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
     * @return View
     */
    public function create(): View
    {
        return view('blue::form');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        $item = $this->apiDataProvider->findItemById($request->id);
        return view('blue::form', compact('item'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $request->session()->flash('success', 'That was updated');
        return redirect()->route('panel');
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
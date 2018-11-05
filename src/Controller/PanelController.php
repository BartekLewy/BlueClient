<?php

namespace BlueClient\Controller;

use App\Http\Controllers\Controller;
use BlueClient\Application\ApiDataProvider;
use BlueClient\Application\Exception\CantCreateItemException;
use BlueClient\Application\Exception\CantUpdateItemException;
use BlueClient\Application\Exception\ItemNotFoundException;
use BlueClient\Application\Exception\ItemWasNotUpdatedException;
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
        try {
            $item = $this->apiDataProvider->findItemById($request->id);
        } catch (ItemNotFoundException $exception) {
            $request->session()->flash('error', 'Item not found');
        }
        return view('blue::form', compact('item'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        if (!$request->id) {
            try {
                $response = $this->apiDataProvider->create($request->name, $request->amount);
                $request->session()->flash('success', 'Item has been created! Here is ID: ' . $response['resourceId']);
            } catch (CantCreateItemException $exception) {
                $request->session()->flash('error', 'Something went wrong! I cant create item');
                return redirect()->route('panel-item-create', ['name' => $request->name, 'amount' => $request->amount]);
            }
        } else {
            try {
                $item = $this->apiDataProvider->findItemById($request->id);
                $updatedItem = $this->apiDataProvider->update($item['id'], $request->name, $request->amount);
                $request->session()->flash('success', 'Item has been created! Here is ID: ' . $updatedItem['resourceId']);
            } catch (ItemNotFoundException $exception) {
                $request->session()->flash('error', 'Item not found');
            } catch (CantUpdateItemException $exception) {
                $request->session()->flash('error', 'Something went wrong! I cant update the item');
                return redirect()->route('panel-item-edit', ['id' => $request->id]);
            } catch (ItemWasNotUpdatedException $exception) {
                $request->session()->flash('warning', 'Item was not updated. You have sent the same values');
                return redirect()->route('panel-item-edit', ['id' => $request->id]);
            }
        }

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
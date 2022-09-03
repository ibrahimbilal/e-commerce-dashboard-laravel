<?php

namespace App\Http\Controllers;

use App\Models\DynamicModel;
use App\Http\Requests\BulkActionRequest;

class AdminController extends Controller
{

	// Admin Panel Index
	public function index()
	{
		return view('admin.index');
	}


	/**
	 * Execute Bulk Action.
	 *
	 * @param \Illuminate\Http\BulkActionRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulk_action(BulkActionRequest $request)
	{
		try {
			$table = DynamicModel::table($request->get('type'));

			switch ($request->get('action')) {
				case 'delete':
					$rows = $table->whereIn('id', $request->get('items'))->delete();
					if ($rows > 0) {
						$status = true;
						$title = __('bulk_action.ajax.actions.delete.title');
						$text = __('bulk_action.ajax.actions.delete.text', ['type' => __('admin.menu.' . $request->get('type') . '.title')]);
					} else {
						$status = false;
						$title = __('bulk_action.ajax.actions.delete.no_items');
						$text = __('');
					}
					break;

				case 'restore':
					$rows = $table->onlyTrashed()->whereIn('id', $request->get('items'))->restore();
					if ($rows > 0) {
						$status = true;
						$title = __('bulk_action.ajax.actions.restore.title');
						$text = __('bulk_action.ajax.actions.restore.text', ['type' => __('admin.menu.' . $request->get('type') . '.title')]);
					} else {
						$status = false;
						$title = __('bulk_action.ajax.actions.restore.no_items');
						$text = __('');
					}
					break;

				case 'force_delete':
					$rows = $table->onlyTrashed()->whereIn('id', $request->get('items'))->forceDelete();
					$status = true;
					$title = __('bulk_action.ajax.actions.delete.title');
					$text = __('bulk_action.ajax.actions.delete.text', ['type' => __('admin.menu.' . $request->get('type') . '.title')]);
					break;

				default:
					return response()->json([
						'errors' => [__('bulk_action.ajax.errors.invalid_action')],
					]);
					break;
			}

			return response()->json([
				'success' => $status,
				'title' => $title,
				'text' => $text
			]);

		} catch (\Exception $ex) {
			return response()->json([
				'errors' => [__('alerts.response.errors.unknown')]
			]);
		}
	}
}

<?php

namespace Phobrv\CoreAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\OptionRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Phobrv\CoreAdmin\Services\UnitServices;
use Storage;

class ConfigAPIController extends Controller {
	protected $optionRepository;
	protected $termRepository;
	protected $unitService;
	protected $app;
	public function __construct(
		OptionRepository $optionRepository,
		TermRepository $termRepository,
		Application $app,
		UnitServices $unitService
	) {
		$this->app = $app;
		$this->optionRepository = $optionRepository;
		$this->termRepository = $termRepository;
		$this->unitService = $unitService;
	}
	public function maintenanceWebsite(Request $request) {

		if (isset($request->off) && $request->off) {
			\Artisan::call('down');
			$message = "Turn off website success!";
		} else {
			\Artisan::call('up');
			$message = "Turn on website success!";
		}
		return response()->json([
			'off' => ($this->app->isDownForMaintenance()) ? 1 : 0,
			'msg' => 'success',
			'message' => $message,
		]);

	}
	public function update(Request $request) {
		try {
			$this->optionRepository->updateOption($request->data);
			return response()->json([
				'msg' => 'success',
				'message' => 'Update config success!',
			]);

		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	public function uploadFile(Request $request) {
		if ($request->hasFile('file')) {
			$key = $request->key;
			$path = $this->unitService->handleUploadImage($request->file);
			$this->optionRepository->updateOption(
				[
					$key => $path,
				]
			);
		}
		return Storage::url($path);
	}
}

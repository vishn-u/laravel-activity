<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PipedrivePanelController;

Route::get('/pipedrive-panel', [PipedrivePanelController::class, 'showPanel']);
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'active')->get();
        
        // Map the services so it matches the expected product format for the App
        $formattedServices = $services->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'price' => $service->price,
                'image' => $service->getFeaturedImage(),
                'description' => $service->description,
            ];
        });

        return response()->json($formattedServices);
    }
}

<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\MqttService;
use Illuminate\Http\Request;

class MqttController extends Controller
{
    protected $mqttService;

    public function __construct(MqttService $mqttService)
    {
        $this->mqttService = $mqttService;
    }

    public function publishMessage(Request $request)
    {
        $topic = $request->input('topic');
        $message = $request->input('message');

        $result = $this->mqttService->publish($topic, $message);

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Message published successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to publish message']);
        }
    }

    public function subscribeToTopic(Request $request)
    {
        $topic = $request->input('topic');

        $this->mqttService->subscribe($topic, function ($topic, $message) {
            // Traiter le message reçu
            \Log::info("Received message on topic $topic: $message");
        });

        return response()->json(['success' => true, 'message' => 'Subscribed to topic']);
    }

    
}

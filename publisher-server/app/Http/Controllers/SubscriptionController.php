<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use App\Models\Topics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Subscribe a topic
     * @param $topic
     * @returns json
     */
    public function subscribeTopic(Request $request, $topic) {
        $validator = Validator::make($request->all(), [
            'url' => ['required', 'url']
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => $validator->errors()], 400);
        } else {
            $url = $request->input('url');

            $topicCheck = Topics::where('title', $topic)->first();

            if(!$topicCheck) {
                $topicModel = new Topics();
                $topicModel->title = $topic;
                $topicModel->save();
            } else {
                $topicModel = Topics::where('title', $topic)->first();
            }

            // Create a subscriber entry (this allows us have multiple subscribers to a pic)
            $subscription = new Subscriptions();
            $subscription->topic_id = $topicModel->id;
            $subscription->url = $url;
            $subscription->save();

            return response()->json(['status' => 'success', 'data' => ['url' => $url, 'topic' => $topic]], 200);
        }
    }
}

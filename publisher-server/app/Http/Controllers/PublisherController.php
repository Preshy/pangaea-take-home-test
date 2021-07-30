<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Models\Topics;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Validator;

class PublisherController extends Controller
{
    public function publicTopic(Request $request, $topic)
    {
        // Validate that request is a JSON request
        if (!$request->isJson()) {
            return response()->json(['status' => 'error', 'data' => ['errors' => ['request_body' => 'Your request body is not a valid JSON object.']]], 400);
        }

        // Validate if topic exists.
        $checkIfTopicExists = Topics::where('title', $topic)->count();

        if ($checkIfTopicExists == 0) {
            // Topic does not exist, return error.
            return response()->json(['status' => 'error', 'data' => ['errors' => ['topic' => 'Topic does not exist']]], 400);
        }

        $topicModel = Topics::where('title', $topic)->first();

        // So topic exists, find all subscribers to this topic
        $subscribers = Subscriptions::where('topic_id', $topicModel->id)->get();

        // check count of subscribers.. 
        // if its greater than 0 then we push the request body to the urls
        // else we just move on and return a success response

        $subscriberResponseCodes = [];

        if (count($subscribers) > 0) {
            foreach ($subscribers as $item) {

                $client = new Client();

                $data = ['topic' => $topic, 'data' => $request->all()];

                $response = $client->post(
                    $item->url,
                    [
                        'content-type' => 'application/json',
                        'http_errors'  => false,
                        'json'         => json_encode($data)
                    ]
                );

                $responseCode = $response->getStatusCode();                
                $responseMessage = ($responseCode == 200 ? 'success' : 'failed');
                $responseBody = $response->getBody()->getContents();

                $subscriberResponseCodes[] = ['topic' => $topic, 'url' => $item->url, 'responseCode' => $responseCode, 'responseMessage' => $responseMessage, 'responseBody' => json_decode($responseBody)];

            }

            return response()->json(['status' => 'success', 'data' => $subscriberResponseCodes], 200);
        } else {
            return response()->json(['status' => 'success', 'data' => []], 200);
        }
    }
}

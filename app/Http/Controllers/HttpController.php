<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SubmittedData;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class HttpController extends Controller
{
    // public function getData()
    // {
    //     // try {
    //         // Retrieve all submitted data from the database
    //         $data = SubmittedData::all();

    //         // Return the retrieved data as a JSON response
    //         return response()->json(['data' => $data], 200);
    //     // } catch (\Exception $e) {
    //     //     // Log the error
    //     //     \Log::error('Failed to retrieve data from the database: ' . $e->getMessage());

    //     //     // Return an error response
    //     //     return response()->json(['error' => 'Failed to retrieve data from the database.'], 500);
    //     // }
    // }

    public function getData()
    {
        // Initialize Guzzle client
        $client = new Client();
        try {
            // Send GET request
            $response = $client->request('GET', 'http://www.google.com');
            // Get response body
            $data = $response->getBody()->getContents();
            // Return response data
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // public function submitData(Request $request)
    // {
    //     // Validation rules
    //     $rules = [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //     ];
    //     // Validation messages
    //     $messages = [
    //         'name.required' => 'The name field is required.',
    //         'name.string' => 'The name must be a string.',
    //         'name.max' => 'The name may not be greater than :max characters.',
    //         'email.required' => 'The email field is required.',
    //         'email.email' => 'The email must be a valid email address.',
    //         'email.max' => 'The email may not be greater than :max characters.',
    //     ];
    //     // Perform validation
    //     $validator = Validator::make($request->all(), $rules, $messages);
    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
    //     // Attempt to save the submitted data
    //     try {
    //         // Create a new SubmittedData instance and fill it with the validated data
    //         $submittedData = new SubmittedData();
    //         $submittedData->fill($request->all());
    //         // Save the submitted data to the database
    //         $submittedData->save();
    //     } catch (\Exception $e) {
    //         // Log the error
    //         \Log::error('Failed to save data to the database: ' . $e->getMessage());
    //         // Return an error response
    //         return response()->json(['error' => 'Failed to save data to the database.'], 500);
    //     }
    //     // Return a success response
    //     return response()->json(['message' => 'Data submitted successfully'], 201);
    // }
    public function storeData(Request $request)
    {
        try {
            $data = $request->all(); // Get all data from the request

            // Store the data in the database using the SubmittedData model
            SubmittedData::create($data);

            return response()->json(['message' => 'Data stored successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to store data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to store data.'], 500);
        }
    }
    public function storeDataUsingGuzzle()
    {
        try {
            $client = new Client();
            $response = $client->post('https://jsonplaceholder.typicode.com/posts', [
                'json' => [
                    'title' => 'this is my name',
                    'body' => 'this is body',
                    'userId' => 1, // Assuming a user ID is required
                ],
            ]);

            $jsonData = $response->getBody()->getContents();

            // Return the response from the API as JSON
            return response()->json(['response' => json_decode($jsonData)], 200);
        } catch (\Exception $e) {
            Log::error('Failed to store data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to store data.'], 500);
        }
    }
    // public function updateDataUsingGuzzle($postId)
    // {
    //     try {
    //         $client = new Client();
    //         $response = $client->put('https://jsonplaceholder.typicode.com/posts/' . $postId, [
    //             'json' => [
    //                 'title' => 'Updated title', // New title
    //                 'body' => 'Updated body', // New body
    //                 // Assuming userId should remain unchanged for an update
    //             ],
    //         ]);
    
    //         $jsonData = $response->getBody()->getContents();
    
    //         // Return the updated response from the API as JSON
    //         return response()->json(['response' => json_decode($jsonData)], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Failed to update data: ' . $e->getMessage());
    //         return response()->json(['error' => 'Failed to update data.'], 500);
    //     }
    // }

public function updateData(Request $request, $id)
    {
        try {
            $data = SubmittedData::findOrFail($id); // Find the data by its ID

            $data->update($request->all()); // Update the data with the new values from the request

            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to update data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update data.'], 500);
        }
    }
   
    // public function updateData(Request $request, $id)
    // {
    //     // Find the submitted data by ID
    //     $submittedData = SubmittedData::find($id);

    //     // Check if submitted data exists
    //     if (!$submittedData) {
    //         return response()->json(['error' => 'Submitted data not found'], 404);
    //     }

    //     // Validation rules
    //     $rules = [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //     ];

    //     // Validation messages
    //     $messages = [
    //         'name.required' => 'The name field is required.',
    //         'name.string' => 'The name must be a string.',
    //         'name.max' => 'The name may not be greater than :max characters.',
    //         'email.required' => 'The email field is required.',
    //         'email.email' => 'The email must be a valid email address.',
    //         'email.max' => 'The email may not be greater than :max characters.',
    //     ];

    //     // Perform validation
    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Attempt to update the submitted data
    //     try {
    //         // Fill the submitted data with the new values
    //         $submittedData->name = $request->input('name');
    //         $submittedData->email = $request->input('email');

    //         // Save the updated data
    //         $submittedData->save();
    //     } catch (\Exception $e) {
    //         // Log the error
    //         \Log::error('Failed to update data: ' . $e->getMessage());

    //         // Return an error response
    //         return response()->json(['error' => 'Failed to update data.'], 500);
    //     }

    //     // Return a success response
    //     return response()->json(['message' => 'Data updated successfully'], 200);
    // }

    public function deleteDataUsingGuzzle($postId)
    {
        try {
            $client = new Client();
            $response = $client->delete('https://jsonplaceholder.typicode.com/posts/' . $postId);
            
            // Check if the request was successful
            if ($response->getStatusCode() === 200) {
                return response()->json(['message' => 'Post deleted successfully.'], 200);
            } else {
                return response()->json(['error' => 'Failed to delete post.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete data.'], 500);
        }
    }



    public function deleteData($id)
    {
        try {
            $data = SubmittedData::findOrFail($id); // Find the data by its ID

            $data->delete(); // Delete the data

            return response()->json(['message' => 'Data deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to delete data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete data.'], 500);
        }
    }
    // public function deleteData($id)
    // {
    //     // Find the submitted data by ID
    //     $submittedData = SubmittedData::find($id);

    //     // Check if submitted data exists
    //     if (!$submittedData) {
    //         return response()->json(['error' => 'Submitted data not found'], 404);
    //     }

    //     // Attempt to delete the submitted data
    //     try {
    //         // Delete the submitted data
    //         $submittedData->delete();
    //     } catch (\Exception $e) {
    //         // Log the error
    //         \Log::error('Failed to delete data: ' . $e->getMessage());

    //         // Return an error response
    //         return response()->json(['error' => 'Failed to delete data.'], 500);
    //     }

    //     // Return a success response
    //     return response()->json(['message' => 'Data deleted successfully'], 200);
    // } 


    // public function makeRequest()
    // {
    //     // Using cURL
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, "https://jsonplaceholder.typicode.com/posts");
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     return $response;
    // }


    public function makeRequest()
{
    try {
        // Send GET request using Laravel HTTP client
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        // Check if the request was successful
        if ($response->successful()) {
            // Get the response body
            return $response->body();
        } else {
            // Return error message if the request was not successful
            return $response->json(); // You can return JSON error message
        }
    } catch (\Exception $e) {
        // Handle exceptions
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    public function makePostRequest()
{
    // Define your POST data
    $postData = [
        'key1' => 'abcd',
        'key2' => 'az'
        // Add more key-value pairs as needed
    ];

    // Set headers
    $headers = [
        'Content-Type: application/json', // Adjust content type as needed
        'Authorization: Bearer your_access_token', // Add authorization token if required
        // Add more headers as needed
    ];

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, "https://jsonplaceholder.typicode.com/posts");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Encode data as JSON if necessary
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set headers
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Use this if you have SSL issues (not recommended for production)

    // Execute cURL request
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Return response
    return $response;
}

public function makePutRequest()
{
    // Define your PUT data
    $putData = [
        'updated_key1' => 'updated_value1',
        'updated_key2' => 'updated_value2'
        // Add more key-value pairs as needed
    ];

    // Set headers
    $headers = [
        'Content-Type: application/json', // Adjust content type as needed
        'Authorization: Bearer your_access_token', // Add authorization token if required
        // Add more headers as needed
    ];

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, "https://jsonplaceholder.typicode.com/posts/1"); // Adjust the URL to include the resource ID you want to update
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Specify the request method as PUT
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($putData)); // Encode data as JSON if necessary
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set headers
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Use this if you have SSL issues (not recommended for production)

    // Execute cURL request
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Return response
    return $response;
}

}




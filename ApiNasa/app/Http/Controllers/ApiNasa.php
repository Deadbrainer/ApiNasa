<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Support\Facades\Http;

class ApiNasa extends Controller
{
    public function events()
    {
        $data = json_decode(Http::acceptJson()->get('https://eonet.gsfc.nasa.gov/api/v3/events?api_key=kThpOQZSW4ax8sJApr7pyfWgV9EfNfmjOvDwEMjA'));

        foreach ($data->events as $info)
        {
            if(Events::find($info->id) == null)
            {
                Events::create([
                   'id' => $info->id,
                   'title' => $info->title,
                   'link' => $info->link,
                   'category' => $info->categories ? $info->categories[0]->title : null,
                   'source_url' => $info->sources ? $info->sources[0]->url : null,
                   'coordinates' => $info->geometry[0]->coordinates ? json_encode($info->geometry[0]->coordinates) : null,
                ]);
            }
        }

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Data from API',
        ];

        return response()->json($response, 200);
    }
}

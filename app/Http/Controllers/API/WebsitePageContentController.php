<?php

namespace App\Http\Controllers\API;

use App\WebsitePageContent;
use Illuminate\Http\Request;
use App\Utils\Logger;

use App\Utils\Util;

use Validator;
use Illuminate\Support\Facades\Input;

class WebsitePageContentController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        new Logger("using WebsitePageController store");
        $requestValues = $request->all();
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'code'       => 'required',
            'content'       => 'required:json',
            'styles'       => 'required:json'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors']);
        } else {
            $webContent = WebsitePageContent::where('code', $requestValues['code'])->first();
            // Update 
            if($webContent) {
                $webContent->content = json_encode($requestValues['content']);
                $webContent->styles = json_encode($requestValues['styles']);
                try {
                    if($webContent->save()) {
                        return response()->json(['status' => true, 'message' => 'Page has been registered']);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Validation errors']);
                    }
                } catch(\Exception $e){
                    new Logger($e->getMessage());
                }
            } else {
                // Create
                $webContent = new WebsitePageContent;
                $webContent->code = $requestValues['code'];
                $webContent->content = json_encode($requestValues['content']);
                $webContent->styles = json_encode($requestValues['styles']);
                try {
                    if($webContent->save()) {
                        return response()->json(['status' => true, 'message' => 'Page has been registered']);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Validation errors']);
                    }
                } catch(\Exception $e){
                    new Logger($e->getMessage());
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebsitePageContent  $websitePageContent
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, String $websitePageContent)
    {
        if($request->input('type') === "html") {
            $page = WebsitePageContent::where('code', $websitePageContent)->first();
            return $page->content;
        }
        if($request->input('type') === "styles") {
            $page = WebsitePageContent::where('code', $websitePageContent)->first();
            return $page->styles;
        }
        $page = WebsitePageContent::where('code', $websitePageContent)->first();
        return $page;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WebsitePageContent  $websitePageContent
     * @return \Illuminate\Http\Response
     */
    public function edit(WebsitePageContent $websitePageContent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WebsitePageContent  $websitePageContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebsitePageContent $websitePageContent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WebsitePageContent  $websitePageContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebsitePageContent $websitePageContent)
    {
        //
    }
}

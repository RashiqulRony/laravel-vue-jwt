<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $data = Product::where('user_id', Auth::guard('api')->user()->id)->orderBy('id', 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $data,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:191',
            'price' => 'required|max:8',
            'image' => 'required|image',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['status' => false, 'errors'=> $validator->messages()]);
        }

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = time() . '_product_' . $file->getClientOriginalName();
                $file->move('image/', $name);
                $image = $name;
            }

            Product::create([
                'user_id'     => Auth::guard('api')->user()->id,
                'title'       => $request->title,
                'price'       => $request->price,
                'description' => $request->description,
                'image'       => $image
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product added successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => true,
                'message' => 'Product added successfully.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $product = Product::where('user_id', Auth::guard('api')->user()->id)->find($id);
            if (!empty($product)) {
                return response()->json([
                    'status' => true,
                    'data' => $product,
                    'message' => 'Product update successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong. This product can not delete please try again.',
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:191',
            'price' => 'required|max:8',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['status' => false, 'errors'=> $validator->messages()]);
        }

        try {
            $product = Product::where('user_id', Auth::guard('api')->user()->id)->find($id);
            if ($request->hasFile('image')) {
                if ($product->image){
                    unlink(public_path('/image/').$product->image);
                }
                $file = $request->file('image');
                $name = time() . '_product_' . $file->getClientOriginalName();
                $file->move('image/', $name);
                $image = $name;
            }

            if (!empty($product)) {
                $product->update([
                    'title'       => $request->title,
                    'price'       => $request->price,
                    'description' => $request->description,
                    'image'       => $image ?? $product->image,
                    'updated_at'  => now()
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Product update successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong. This product can not updated please try again.',
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $product = Product::where('user_id', Auth::guard('api')->user()->id)->find($id);
            if (!empty($product)) {
                if ($product->image){
                    unlink(public_path('/image/').$product->image);
                }
                $product->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Product update successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong. This product can not delete please try again.',
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}

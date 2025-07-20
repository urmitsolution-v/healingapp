<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\SupplierBills;
use App\Models\Setting;
use App\Models\Categories;
use App\Models\Locations;
use App\Models\Advertisement;
use App\Models\Product;
use App\Models\Bull;
use App\Models\Order;
use App\Models\Video;
use App\Models\VillageProductStock;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\HealingRequest;
use App\Models\HealingBid;

class Admincontroller extends Controller
{
        public function dashboard(){
        $data['totalUsers'] = User::where('role','user')->count();
    

        return view('admin.dashboard');
    }
    
    public function users_list(){
        return view('admin.users.index');
    }


    public function getUserdata(Request $request)
{
    $data = User::where('role', 'user')
                ->when($request->type, function ($query) use ($request) {
                    $query->where('status', $request->type);
                })
                ->when($request->from_date && $request->to_date, function ($query) use ($request) {
                    $from = Carbon::parse($request->from_date)->startOfDay();
                    $to = Carbon::parse($request->to_date)->endOfDay();
                    $query->whereBetween('created_at', [$from, $to]);
                })
                ->orderBy('id', 'DESC');

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('full_name', function ($user) {
            return '<img src="' . asset('newadmin/assets/images/user.png') . '" class="img-shadow img-2x rounded-5 me-1" width="30"> ' . e($user->name);
        })
        ->addColumn('phone', function ($user) {
            return '<a href="tel:' . e($user->phone) . '">' . e($user->phone) . '</a>';
        })
        ->addColumn('status', function ($user) {
            $selectedApproved = $user->status == 'approved' ? 'selected' : '';
            $selectedPending = $user->status == 'pending' ? 'selected' : '';
            $selectedRejected = $user->status == 'rejected' ? 'selected' : '';

            return '
                <select class="form-select form-select-sm user-status" data-user-id="' . $user->id . '">
                    <option value="approved" ' . $selectedApproved . '>Approved</option>
                    <option value="pending" ' . $selectedPending . '>Pending</option>
                    <option value="rejected" ' . $selectedRejected . '>Rejected</option>
                </select>
            ';
        })
        ->addColumn('is_block', function ($user) {
            $selectedBlocked  = $user->is_block == 'Y' ? 'selected' : '';
            $selectedActive   = $user->is_block == 'N' ? 'selected' : '';

            return '
                <select class="form-select form-select-sm user-block-status" data-user-id="' . $user->id . '">
                    <option value="Y" ' .  $selectedBlocked. '>Block</option>
                    <option value="N" ' . $selectedActive . '>Unblock</option>
                </select>
            ';
        })
       ->addColumn('actions', function ($user) {
    return '
        <div class="d-inline-flex gap-1">
            <a href="' . url('/admin/delete-user/' . $user->id) . '"
               class="btn btn-outline-danger btn-sm"
               onclick="return confirm(\'Are you sure you want to delete this user?\');">
                <i class="ri-delete-bin-line"></i>
            </a>

            <a href="' . url('/admin/edit-user/' . $user->id) . '" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Edit User Details">
                <i class="ri-edit-box-line"></i>
            </a>
            <a href="' . url('/admin/view-user/' . $user->id) . '" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" title="View Profile">
                <i class="ri-eye-line"></i>
            </a>
        </div>';
})

        ->addColumn('registered_at', function ($user) {
            return $user->created_at->format('d M Y h:i A');
        })
        ->rawColumns(['full_name', 'phone', 'status', 'actions', 'is_block'])
        ->make(true);
}

public function add_user(Request $request){
    if($request->method() == "POST"){
        $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'dob'      => 'required|date',
        'address'  => 'required|string|max:500',
        'phone'    => 'required|numeric|digits:10',
     ]);

   
     $name = strtoupper(preg_replace('/[^A-Z]/', '', strtoupper($request->name)));
    $prefix = substr($name, 0, 2); // e.g. "HB"

    $lastUser = User::orderBy('id', 'desc')->first();
    $nextId = $lastUser ? $lastUser->id + 1 : 1;
    $paddedId = str_pad($nextId, 4, '0', STR_PAD_LEFT); // e.g. 0028

    $randomNumber = rand(10, 99); // 2-digit random number

    $user_code = $prefix . $paddedId . $randomNumber; 

       $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'dob'      => $request->dob,
        'address'  => $request->address,
        'phone'    => $request->phone,
        'user_code' => $user_code,
        'is_block'    => 'Y',
        'role'    => 'user',
        'status'    => 'pending',
    ]);
    
    return redirect('/admin/users-list')->with('success','New User Created Successfully');
    
    }
    return view('admin.users.newuser');
}

public function updateUserStatus(Request $request)
{
    $user = User::find($request->user_id);

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'User not found']);
    }

    $user->status = $request->status;
    $user->save();

    return response()->json(['success' => true]);
}




public function state_list(Request $request){
    if($request->ajax()) {
        $data = Locations::where('type', 'state')->orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
           ->addColumn('actions', function($row){
    $btn = '<div class="d-flex gap-2">';
    $btn .= '<a href="/edit-state/'.$row->id.'" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
    $btn .= '<a href="/delete-state/'.$row->id.'" onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger"><i class="feather feather-trash"></i></a>';
    $btn .= '</div>';
    return $btn;
})

            ->rawColumns(['actions'])
            ->make(true);
    }
    return view('admin.state.index');
}


public function new_state(Request $request)
{
    if ($request->isMethod('post')) {
      $request->validate([
    'state_name' => 'required|string|max:255',
], [
    'state_name.required' => 'कृपया राज्य का नाम दर्ज करें।',
    'state_name.string' => 'राज्य का नाम मान्य होना चाहिए।',
    'state_name.max' => 'राज्य का नाम 255 अक्षरों से अधिक नहीं हो सकता।',
]);

        \App\Models\Locations::create([
            'name' => $request->state_name,
            'type' => 'state',
            'parent_id' => null, // states have no parent
        ]);

        return redirect('/state-list')->with('success', 'राज्य सफलतापूर्वक जोड़ा गया।');
    }

    return view('admin.state.new');
}


public function edit_state(Request $request, $id)
{
    $state = Locations::findOrFail($id);

    if ($request->isMethod('post')) {
        $request->validate([
            'state_name' => 'required|string|max:255',
        ], [
            'state_name.required' => 'कृपया राज्य का नाम दर्ज करें।',
            'state_name.string' => 'राज्य का नाम मान्य होना चाहिए।',
            'state_name.max' => 'राज्य का नाम 255 अक्षरों से अधिक नहीं हो सकता।',
        ]);

        $state->update([
            'name' => $request->state_name,
            'type' => 'state',
            'parent_id' => null, // states have no parent
        ]);

        return redirect('/state-list')->with('success', 'राज्य सफलतापूर्वक अपडेट किया गया।');
    }

    return view('admin.state.edit', compact('state'));
}

public function delete_state($id)
{
    $relatedCities = \App\Models\Locations::where('type', 'city')
        ->where('parent_id', $id)
        ->count();
    if ($relatedCities > 0) {
        return redirect('/state-list')->with('error', 'इस राज्य से संबंधित सिटी मौजूद हैं, पहले उन्हें हटाएं।');
    }
    $state = \App\Models\Locations::findOrFail($id);
    $state->delete();
    return redirect('/state-list')->with('success', 'राज्य सफलतापूर्वक हटाया गया।');
}



public function city_list(Request $request){
    if($request->ajax()) {
        $data = Locations::with('parent')->where('type', 'city')->orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
             ->addColumn('state_name', function($row){
                return $row->parent ? $row->parent->name : 'N/A';
            })
           ->addColumn('actions', function($row){
    $btn = '<div class="d-flex gap-2">';
    $btn .= '<a href="/edit-city/'.$row->id.'" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
    $btn .= '<a href="/delete-city/'.$row->id.'" onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger"><i class="feather feather-trash"></i></a>';
    $btn .= '</div>';
    return $btn;
})

            ->rawColumns(['actions'])
            ->make(true);
    }
    return view('admin.city.index');
}

public function new_city(Request $request)
{
    if ($request->isMethod('post')) {
        $request->validate([
            'state_id' => 'required|exists:locations,id',
            'city_name' => 'required|string|max:255',
        ], [
            'state_id.required' => 'कृपया राज्य चुनें।',
            'state_id.exists' => 'चुना गया राज्य मान्य नहीं है।',
            'city_name.required' => 'कृपया सिटी का नाम दर्ज करें।',
            'city_name.string' => 'सिटी का नाम मान्य होना चाहिए।',
            'city_name.max' => 'सिटी का नाम 255 अक्षरों से अधिक नहीं हो सकता।',
        ]);

        \App\Models\Locations::create([
            'name' => $request->city_name,
            'type' => 'city',
            'parent_id' => $request->state_id,
        ]);

        return redirect('/city-list')->with('success', 'सिटी सफलतापूर्वक जोड़ी गई।');
    }

    $states = \App\Models\Locations::where('type', 'state')->orderBy('id', 'DESC')->get();
    return view('admin.city.new', compact('states'));
}


public function edit_city(Request $request, $id)
{
    $city = Locations::findOrFail($id);

    if ($request->isMethod('post')) {
        $request->validate([
            'state_id' => 'required|exists:locations,id',
            'city_name' => 'required|string|max:255',
        ], [
            'state_id.required' => 'कृपया राज्य चुनें।',
            'state_id.exists' => 'चुना गया राज्य मान्य नहीं है।',
            'city_name.required' => 'कृपया सिटी का नाम दर्ज करें।',
            'city_name.string' => 'सिटी का नाम मान्य होना चाहिए।',
            'city_name.max' => 'सिटी का नाम 255 अक्षरों से अधिक नहीं हो सकता।',
        ]);

        $city->update([
            'name' => $request->city_name,
            'type' => 'city',
            'parent_id' => $request->state_id,
        ]);

        return redirect('/city-list')->with('success', 'सिटी सफलतापूर्वक अपडेट की गई।');
    }

    $states = \App\Models\Locations::where('type', 'state')->orderBy('id', 'DESC')->get();
    return view('admin.city.edit', compact('city', 'states'));
}

public function delete_city($id)
{
    $city = \App\Models\Locations::findOrFail($id);
    
    if($city->type !== 'city') {
        return redirect('/city-list')->with('error', 'यह एक मान्य सिटी नहीं है।');
    }
    $city->delete();
    return redirect('/city-list')->with('success', 'सिटी सफलतापूर्वक हटाई गई।');
    
}




public function category_list(Request $request)
{
    if ($request->ajax()) {
        $data = \App\Models\Categories::where('type', 'category')->orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return $row->image 
                    ? '<img src="' . asset($row->image) . '" width="50" height="50">' 
                    : 'N/A';
            })
            ->addColumn('status', function ($row) {
                return $row->status ? $row->status : 'N/A';
            })
            ->addColumn('actions', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="/edit-category/' . $row->id . '" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
              $btn .= '<a href="/delete-category/' . $row->id . '" onclick="return confirm(\'क्या आप वाकई इसे हटाना चाहते हैं?\')" class="btn btn-sm btn-danger delete-category" data-id="' . $row->id . '"><i class="feather feather-trash"></i></a>';

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['image', 'actions'])
            ->make(true);
    }

    return view('admin.category.index');
}

public function videos(Request $request)
{
    if ($request->ajax()) {
        $data = Video::orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
           ->addColumn('video', function ($row) {
    if ($row->video) {
        $videoUrl = asset($row->video);
        return '
            <a href="' . $videoUrl . '" target="_blank" title="नए टैब में वीडियो चलाएं">
                <video width="100" height="70" style="border:1px solid #ddd; border-radius:4px;">
                    <source src="' . $videoUrl . '" type="video/mp4">
                    आपका ब्राउज़र वीडियो टैग को सपोर्ट नहीं करता.
                </video>
            </a>';
    }
    return 'N/A';
})

            ->addColumn('status', function ($row) {
                return ucfirst($row->status) ?: 'N/A';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y h:i A') : 'N/A';
            })
            ->addColumn('actions', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                // $btn .= '<a href="/edit-video/' . $row->id . '" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
                $btn .= '<a href="/delete-video/' . $row->id . '" onclick="return confirm(\'क्या आप वाकई इसे हटाना चाहते हैं?\')" class="btn btn-sm btn-danger"><i class="feather feather-trash"></i></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['video', 'actions'])
            ->make(true);
    }

    return view('admin.videos.index');
}


public function deleteAnimalBuySell($id)
{
    $video = Video::find($id);

    if (!$video) {
        return redirect()->back()->with('error', 'वीडियो नहीं मिला।');
    }

    // वीडियो फाइल को हटाना
    $videoPath = public_path($video->video);

    if ($video->video && file_exists($videoPath)) {
        if (!unlink($videoPath)) {
            return redirect()->back()->with('error', 'वीडियो फाइल हटाने में समस्या आई।');
        }
    }

    // डेटाबेस से रिकॉर्ड हटाना
    $video->delete();

    return redirect()->back()->with('success', 'वीडियो सफलतापूर्वक हटाया गया।');
}



public function delete_category($id)
{
    $category = \App\Models\Categories::findOrFail($id);

    // Check for related products
    $relatedProducts = \App\Models\Product::where('category_id', $id)->count();

    if ($relatedProducts > 0) {
        return redirect('/category-list')->with('error', 'इस श्रेणी से संबंधित उत्पाद मौजूद हैं, पहले उन्हें हटाएं।');
    }

    // Delete category image if exists
    if ($category->image && file_exists(public_path($category->image))) {
        unlink(public_path($category->image));
    }

    $category->delete();

    return redirect('/category-list')->with('success', 'श्रेणी सफलतापूर्वक हटाई गई।');
}


public function new_category(Request $request)
{
    if ($request->isMethod('post')) {
       $request->validate([
    'category_name' => 'required|string|max:255',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'group' => 'nullable|string|max:255',
    'status' => 'nullable|string|max:255',
], [
    'category_name.required' => 'कृपया श्रेणी का नाम दर्ज करें।',
    'category_name.string' => 'श्रेणी का नाम मान्य होना चाहिए।',
    'category_name.max' => 'श्रेणी का नाम 255 अक्षरों से अधिक नहीं हो सकता।',

    'image.image' => 'कृपया मान्य छवि फ़ाइल अपलोड करें।',
    'image.mimes' => 'छवि केवल jpeg, png, jpg या gif प्रकार की होनी चाहिए।',
    'image.max' => 'छवि का आकार 2MB से अधिक नहीं हो सकता।',

    'group.string' => 'ग्रुप मान्य टेक्स्ट होना चाहिए।',
    'group.max' => 'ग्रुप अधिकतम 255 अक्षरों का हो सकता है।',

    'status.string' => 'स्टेटस मान्य टेक्स्ट होना चाहिए।',
    'status.max' => 'स्टेटस अधिकतम 255 अक्षरों का हो सकता है।',
]);


        $category = new \App\Models\Categories();
        $category->category_name = $request->category_name;
        $category->type = $request->type;
        $category->group = $request->group;
        $category->status = $request->status;
        $category->type = "category";

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $category->image = '/uploads/'.$imageName;
        }

        $category->save();

    return redirect('/category-list')->with('success', 'श्रेणी सफलतापूर्वक जोड़ी गई।');
}

    return view('admin.category.new');
    
}


public function edit_category(Request $request, $id)
{
    $category = \App\Models\Categories::findOrFail($id);

    if ($request->isMethod('post')) {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'group' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $category->category_name = $request->category_name;
        $category->type = $request->type;
        $category->group = $request->group;
        $category->status = $request->status;
        $category->type = "category";

      if ($request->hasFile('image')) {
    if ($category->image && file_exists(public_path($category->image))) {
        unlink(public_path($category->image));
    }
    $image = $request->file('image');
    $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
    $image->move(public_path('uploads'), $imageName);
    $category->image = '/uploads/' . $imageName;
}
        $category->save();

        return redirect('/category-list')->with('success', 'श्रेणी सफलतापूर्वक अपडेट की गई।');
    }

    return view('admin.category.edit', compact('category'));
    
}


public function villages_list(Request $request)
{


     if($request->ajax()) {
        $data = Locations::where('type', 'village')->orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
           ->addColumn('actions', function($row){
    $btn = '<div class="d-flex gap-2">';
    $btn .= '<a href="/edit-village/'.$row->id.'" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
    $btn .= '<a href="/delete-village/'.$row->id.'" onclick="return confirm(\'क्या आप वाकई इस गाँव को हटाना चाहते हैं?\');" class="btn btn-sm btn-danger"><i class="feather feather-trash"></i></a>';
    $btn .= '</div>';
    return $btn;
})

            ->rawColumns(['actions'])
            ->make(true);
    }
    
    return view('admin.villages.index');
    
}


public function new_village(Request $request)
{
    if ($request->isMethod('post')) {
        $request->validate([
            'village_name' => 'required|string|max:255',
        ], [
            'village_name.required' => 'कृपया गाँव का नाम दर्ज करें।',
            'village_name.string'   => 'गाँव का नाम मान्य टेक्स्ट होना चाहिए।',
            'village_name.max'      => 'गाँव का नाम 255 अक्षरों से अधिक नहीं हो सकता।',
        ]);

        \App\Models\Locations::create([
            'name' => $request->village_name,
            'type' => 'village',
            'parent_id' => null,
        ]);

        return redirect('/villages-list')->with('success', 'गाँव सफलतापूर्वक जोड़ा गया।');
    }

    return view('admin.villages.new');
}

public function edit_village(Request $request, $id)
{
    $village = Locations::findOrFail($id);

    if ($request->isMethod('post')) {
        $request->validate([
            'village_name' => 'required|string|max:255',
        ], [
            'village_name.required' => 'कृपया गाँव का नाम दर्ज करें।',
            'village_name.string'   => 'गाँव का नाम मान्य टेक्स्ट होना चाहिए।',
            'village_name.max'      => 'गाँव का नाम 255 अक्षरों से अधिक नहीं हो सकता।',
        ]);

        $village->update([
            'name' => $request->village_name,
            'type' => 'village',
            'parent_id' => null,
        ]);

        return redirect('/villages-list')->with('success', 'गाँव सफलतापूर्वक अपडेट किया गया।');
    }

    return view('admin.villages.edit', compact('village'));
    
}


public function supplier_bills(Request $request)
{

      if ($request->ajax()) {
        $data = \App\Models\SupplierBills::orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('supplier_date', function($row) {
                return \Carbon\Carbon::parse($row->supplier_date)->format('d-m-Y');
            })
             
            ->editColumn('supplier_image', function($row) {
                if ($row->supplier_image) {
                    return '<a href="'.asset($row->supplier_image).'" target="_blank"><img src="'.asset($row->supplier_image).'" width="50" height="50"></a>';
                }
                return 'N/A';
            })
            ->addColumn('actions', function($row){
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="/edit-supplier-bill/'.$row->id.'" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
                // $btn .= '<a href="#" class="btn btn-sm btn-danger delete-bill" data-id="'.$row->id.'"><i class="feather feather-trash"></i></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['supplier_image', 'actions'])
            ->make(true);
    }
    return view('admin.supplier_bills.index');
    
}

public function new_supplier_bill(Request $request)
{
    if ($request->isMethod('post')) {

        // वैलिडेशन
        $request->validate([
            'state_name' => 'required|string|max:255',
            'farmer_mobile' => 'required|digits:10',
            'supplier_mobile' => 'required|digits:10',
            'supplier_date' => 'required',
            'bill_number' => 'required|string|max:255|unique:supplier_bills,bill_number',
            'supplier_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'state_name.required' => 'कृपया राज्य का नाम दर्ज करें।',
            'farmer_mobile.required' => 'कृपया किसान का मोबाइल नंबर दर्ज करें।',
            'farmer_mobile.digits' => 'किसान का मोबाइल नंबर 10 अंकों का होना चाहिए।',
            'supplier_mobile.required' => 'कृपया सप्लायर का मोबाइल नंबर दर्ज करें।',
            'supplier_mobile.digits' => 'सप्लायर का मोबाइल नंबर 10 अंकों का होना चाहिए।',
            'supplier_date.required' => 'कृपया सप्लायर की तारीख दर्ज करें।',
            'supplier_date.date_format' => 'तारीख dd-mm-yyyy प्रारूप में होनी चाहिए।',
            'bill_number.required' => 'कृपया बिल नंबर दर्ज करें।',
            'bill_number.unique' => 'यह बिल नंबर पहले से मौजूद है।',
            'supplier_image.image' => 'सप्लायर छवि मान्य इमेज फॉर्मेट में होनी चाहिए।',
        ]);

        // इमेज अपलोड
      $imagePath = null;

if ($request->hasFile('supplier_image')) {
    $image = $request->file('supplier_image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $destinationPath = public_path('uploads/supplier_bills'); // full public path

    // Ensure directory exists
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $image->move($destinationPath, $imageName);
    $imagePath = 'uploads/supplier_bills/' . $imageName; // path to save in DB
}


  $lastId = \App\Models\SupplierBills::max('id') ?? 0;
        $nextId = $lastId + 1;

        // Generate 6-digit capture code with leading zeros
        $capture_code = str_pad($nextId, 6, '0', STR_PAD_LEFT);

        // डेटा सेव करें
        \App\Models\SupplierBills::create([
            'state_name' => $request->state_name,
            'farmer_mobile' => $request->farmer_mobile,
            'supplier_mobile' => $request->supplier_mobile,
            'supplier_date' => $request->supplier_date,
            'bill_number' => $request->bill_number,
            'supplier_image' => $imagePath,
            'capture_code' => $capture_code,
        ]);

        return redirect('/supplier-bills')->with('success', 'सप्लायर बिल सफलतापूर्वक जोड़ा गया।');
    }

    return view('admin.supplier_bills.new');
}


public function edit_supplier_bill(Request $request, $id)
{
    $bill = \App\Models\SupplierBills::findOrFail($id);

    if ($request->isMethod('post')) {
        $request->validate([
            'state_name' => 'required|string|max:255',
            'farmer_mobile' => 'required|digits:10',
            'supplier_mobile' => 'required|digits:10',
            'supplier_date' => 'required',
            'bill_number' => 'required|string|max:255|unique:supplier_bills,bill_number,'.$bill->id,
            'supplier_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

      $imagePath = $bill->supplier_image; 

if ($request->hasFile('supplier_image')) {
    if ($bill->supplier_image && file_exists(public_path($bill->supplier_image))) {
        unlink(public_path($bill->supplier_image));
    }

    $image = $request->file('supplier_image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $destinationPath = public_path('uploads/supplier_bills');
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $image->move($destinationPath, $imageName);
    $imagePath = 'uploads/supplier_bills/' . $imageName; // path to save in DB
}
        $bill->update([
            'state_name' => $request->state_name,
            'farmer_mobile' => $request->farmer_mobile,
            'supplier_mobile' => $request->supplier_mobile,
            'supplier_date' => $request->supplier_date,
            'bill_number' => $request->bill_number,
            'supplier_image' => $imagePath,
        ]);

        return redirect('/supplier-bills')->with('success', 'सप्लायर बिल सफलतापूर्वक अपडेट किया गया।');
    }

    return view('admin.supplier_bills.edit', compact('bill'));
    
}

public function bullview(Request $request)
{
      if ($request->ajax()) {
        $data = \App\Models\Bull::orderBy('id', 'DESC')->get();

        return \DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('bull_image', function($row) {
                if ($row->bull_image) {
                    return '<img src="'.asset($row->bull_image).'" width="50">';
                }
                return 'N/A';
            })
            ->addColumn('actions', function($row){
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="'.url('/bulls/'.$row->id.'/edit').'" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
                $btn .= '<a href="#" class="btn btn-sm btn-danger delete-bull" data-id="'.$row->id.'"><i class="feather feather-trash"></i></a>';
                $btn .= '<a target="_blank" href="'.url($row->bull_image).'" class="btn btn-sm btn-warning view-bull" data-id="'.$row->id.'"><i class="feather feather-eye"></i></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['bull_image', 'actions'])
            ->make(true);
    }
    
    return view('admin.bullview');
}

public function new_bull(Request $request)
{
    if ($request->isMethod('post')) {
      $request->validate([
    'bull_number' => 'required|string|unique:bulls,bull_number',
    'bull_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=320,min_height=123|max:2048',
], [
    'bull_number.required' => 'कृपया बेल नंबर दर्ज करें।',
    'bull_number.unique' => 'यह बेल नंबर पहले से मौजूद है।',

    'bull_image.image' => 'अपलोड की गई फ़ाइल एक छवि होनी चाहिए।',
    'bull_image.mimes' => 'छवि jpeg, png, jpg या gif प्रारूप में होनी चाहिए।',
    'bull_image.dimensions' => 'छवि का न्यूनतम आकार 320x123 पिक्सल होना चाहिए।',
    'bull_image.max' => 'छवि अधिकतम 2MB की होनी चाहिए।',
]);


    $imagePath = null;
    if ($request->hasFile('bull_image')) {
        $image = $request->file('bull_image');
        $imageName = time() . '_' . Str::random(5) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/bulls'), $imageName);
        $imagePath = 'uploads/bulls/' . $imageName;
    }

    Bull::create([
        'bull_number' => $request->bull_number,
        'mother_milk_capacity' => $request->mother_milk_capacity,
        'grandmother_milk_capacity' => $request->grandmother_milk_capacity,
        'maternal_grandmother_milk_capacity' => $request->maternal_grandmother_milk_capacity,
        'age' => $request->age,
        'height' => $request->height,
        'breed' => $request->breed,
        'bull_image' => $imagePath,
    ]);
        return redirect('/bullview')->with('success', 'बुल सफलतापूर्वक जोड़ा गया।');
    }
    return view('admin.new_bull');
    
}

public function edit_bull(Request $request, $id)
{
    $bull = Bull::findOrFail($id);

    if ($request->isMethod('post')) {
        $request->validate([
            'bull_number' => 'required|string|unique:bulls,bull_number,' . $bull->id,
            'mother_milk_capacity' => 'nullable|numeric',
            'grandmother_milk_capacity' => 'nullable|numeric',
            'maternal_grandmother_milk_capacity' => 'nullable|numeric',
            'age' => 'nullable|string',
            'height' => 'nullable|string',
            'breed' => 'nullable|string',
            'bull_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=320,min_height=123|max:2048',
        ], [
            'bull_number.required' => 'कृपया बैल नंबर दर्ज करें।',
            'bull_number.unique' => 'यह बैल नंबर पहले से मौजूद है।',
            'bull_image.image' => 'बैल छवि एक मान्य इमेज फ़ाइल होनी चाहिए।',
            'bull_image.dimensions' => 'छवि का न्यूनतम आकार 320x123 होना चाहिए।',
        ]);

        $imagePath = $bull->bull_image;

        if ($request->hasFile('bull_image')) {
            if ($bull->bull_image && file_exists(public_path($bull->bull_image))) {
                unlink(public_path($bull->bull_image));
            }

            $image = $request->file('bull_image');
            $imageName = time() . '_' . Str::random(5) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/bulls'), $imageName);
            $imagePath = 'uploads/bulls/' . $imageName;
        }

        $bull->update([
            'bull_number' => $request->bull_number,
            'mother_milk_capacity' => $request->mother_milk_capacity,
            'grandmother_milk_capacity' => $request->grandmother_milk_capacity,
            'maternal_grandmother_milk_capacity' => $request->maternal_grandmother_milk_capacity,
            'age' => $request->age,
            'height' => $request->height,
            'breed' => $request->breed,
            'bull_image' => $imagePath,
        ]);

        return redirect('/bullview')->with('success', 'बैल विवरण सफलतापूर्वक अपडेट किया गया।');
    }

    return view('admin.edit_bull', compact('bull'));
}

public function advertisement(Request $request)
{
  if ($request->ajax()) {
    $ads = Advertisement::latest()->get();

    return DataTables::of($ads)
        ->addIndexColumn()
       ->editColumn('ad_file', function($row) {
        $ext = pathinfo($row->ad_file, PATHINFO_EXTENSION);
        $type = match($ext) {
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'mov' => 'video/quicktime',
            default => 'video/mp4',
        };
        $url = asset($row->ad_file);
        if (in_array($ext, ['mp4', 'webm', 'mov'])) {
            return '<video width="200" controls muted>
                        <source src="' . $url . '" type="' . $type . '">
                    </video>';
        } else {
            return '<img src="' . $url . '" width="80">';
        }
    })
        ->addColumn('actions', function($row){
            $btn = '<div class="d-flex gap-2">';
            $btn .= '<a href="'.url('/advertisement/'.$row->id.'/edit').'" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
            $btn .= '<a href="#" class="btn btn-sm btn-danger delete-bull" data-id="'.$row->id.'"><i class="feather feather-trash"></i></a>';
            $btn .= '</div>';
            return $btn;
        })
        ->rawColumns(['ad_file', 'actions']) 
        ->make(true);
}

    return view('admin.advertisement.index');
}
public function new_advertisement(Request $request){
    
    if($request->method() == "POST"){
         $request->validate([
            'ad_file' => 'required|file|mimes:jpeg,png,gif,mp4,mov,avi', // 10MB max
            'description' => 'nullable|string|max:1000',
            'village_mode' => 'required|in:all,manual',
            'villages' => 'nullable|array',
            'villages.*' => 'exists:locations,id',
        ], [
            'ad_file.required' => 'विज्ञापन फाइल आवश्यक है।',
            'ad_file.mimes' => 'केवल jpg, png, gif इमेज या mp4, mov, avi वीडियो स्वीकार्य हैं।',
            'ad_file.max' => 'फ़ाइल का आकार अधिकतम 10MB होना चाहिए।',
             'village_mode.required' => 'कृपया चयन विधि चुनें।',
        ]);

        $filePath = null;
        if ($request->hasFile('ad_file')) {
            $file = $request->file('ad_file');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ads'), $filename);
            $filePath = 'uploads/ads/' . $filename;
        }

        Advertisement::create([
            'ad_file' => $filePath,
            'description' => $request->description,
            'village_mode' => $request->village_mode,
             'type' => $request->file_type,
            'villages' => $request->village_mode === 'manual' ? $request->villages : null,
        ]);

        return redirect('/advertisement')->with('success', 'विज्ञापन सफलतापूर्वक जोड़ा गया।');
    }
    
    return view('admin.advertisement.new');
    
}

public function edit_advertisement(Request $request, $id)
{
    $ad = Advertisement::findOrFail($id);

    if ($request->isMethod('post')) {
        $request->validate([
            'ad_file' => 'nullable|file|mimes:jpeg,png,gif,mp4,mov,avi', // 10MB
            'description' => 'nullable|string|max:1000',
            'village_mode' => 'required|in:all,manual',
            'villages' => 'nullable|array',
            'villages.*' => 'exists:locations,id',
        ],
    [
            'ad_file.required' => 'विज्ञापन फाइल आवश्यक है।',
            'ad_file.mimes' => 'केवल jpg, png, gif इमेज या mp4, mov, avi वीडियो स्वीकार्य हैं।',
            'ad_file.max' => 'फ़ाइल का आकार अधिकतम 10MB होना चाहिए।',
             'village_mode.required' => 'कृपया चयन विधि चुनें।',
        ]
    );

        $filePath = $ad->ad_file;

        if ($request->hasFile('ad_file')) {
            // ✅ Delete old file if exists
            if ($ad->ad_file && file_exists(public_path($ad->ad_file))) {
                @unlink(public_path($ad->ad_file));
            }

            $file = $request->file('ad_file');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ads'), $filename);
            $filePath = 'uploads/ads/' . $filename;
        }

        $ad->update([
            'ad_file' => $filePath,
            'description' => $request->description,
            'village_mode' => $request->village_mode,
             'type' => $request->file_type,
            'villages' => $request->village_mode === 'manual' ? $request->villages : null,
        ]);

        return redirect('/advertisement')->with('success', 'विज्ञापन सफलतापूर्वक अपडेट किया गया।');
    }

        $villages = Locations::where('type', 'village')->pluck('name', 'id');


    return view('admin.advertisement.edit', compact('ad','villages'));
}


public function products()
{
    if (request()->ajax()) {
        $products = \App\Models\Product::with(['category', 'productTypes'])->latest()->get();

        return DataTables::of($products)
            ->addIndexColumn()

            // उत्पाद नाम
            ->editColumn('product_name', function ($row) {
                return e($row->product_name);
            })

            // श्रेणी
            ->addColumn('category_name', function ($row) {
                return $row->category->category_name ?? 'N/A';
            })

            // छवि
            ->addColumn('product_image', function ($row) {
                return $row->product_image
                    ? '<img src="' . asset($row->product_image) . '" width="50">'
                    : 'N/A';
            })

            // प्रकार
            ->addColumn('types', function ($row) {
                return $row->productTypes->map(function ($type) {
                    return $type->type . ' - ₹' . $type->price;
                })->implode('<br>');
            })

            // स्थिति (Optional – अगर आपके पास `status` कॉलम है)
          ->addColumn('status', function ($row) {
    $checked = $row->status === "Y" ? 'checked' : '';
    return '
        <div class="form-check form-switch">
            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
        </div>';
})

// गतिविधि बटन
            ->addColumn('actions', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="/edit-product/' . $row->id . '" class="btn btn-sm btn-success"><i class="feather feather-edit"></i></a>';
                // $btn .= '<a href="/manage-stock/' . $row->id . '" class="btn btn-sm btn-primary" title="Manage Stock"><i class="feather feather-box"></i></a>';  // नया बटन
                $btn .= '<a onclick="return confirm(\'क्या आप वाकई इस उत्पाद को हटाना चाहते हैं?\');" href="/delete-product/' . $row->id . '" class="btn btn-sm btn-danger delete-product" data-id="' . $row->id . '"><i class="feather feather-trash"></i></a>';
                $btn .= '</div>';
                return $btn;
            })

            ->rawColumns(['product_image', 'types', 'actions','status'])
            ->make(true);
    }

    return view('admin.products.index');
}


public function delete_product($id) {
    $product = \App\Models\Product::findOrFail($id);

    // उत्पाद प्रकार हटाएं
    \App\Models\ProductType::where('product_id', $id)->delete();

    // उत्पाद छवि हटाएं
    if ($product->product_image && file_exists(public_path($product->product_image))) {
        unlink(public_path($product->product_image));
    }

    // उत्पाद हटाएं
    $product->delete();

    return redirect('/products')->with('success', 'उत्पाद सफलतापूर्वक हटाया गया।');
}


public function new_product(Request $request)
{
    if ($request->isMethod('post')) {

        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'product_name.required' => 'कृपया उत्पाद का नाम दर्ज करें।',
            'category_id.required' => 'कृपया श्रेणी चुनें।',
            'product_image.image' => 'कृपया मान्य छवि फ़ाइल अपलोड करें।',
        ]);

        $product = new \App\Models\Product();
        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->status = "Y";

        if ($request->hasFile('product_image')) {
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('uploads/products'), $imageName);
            $product->product_image = '/uploads/products/' . $imageName;
        }

        $product->save();

        // अब product types को सेव करें
        if ($request->has('product') && is_array($request->product)) {
            foreach ($request->product as $typeData) {
                if (!empty($typeData['type']) && isset($typeData['price'])) {
                    \App\Models\ProductType::create([
                        'product_id' => $product->id,
                        'type' => $typeData['type'],
                        'price' => $typeData['price'],
                    ]);
                }
            }
        }

        return redirect('/products')->with('success', 'उत्पाद सफलतापूर्वक जोड़ा गया।');
    }

    $categories = \App\Models\Categories::where('type', 'category')->orderBy('id', 'DESC')->get();
    return view('admin.products.new', compact('categories'));
}

public function edit_product(Request $request, $id)
{
    $product = \App\Models\Product::findOrFail($id);

    if ($request->isMethod('post')) {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->status = "Y";

        // Image update
        if ($request->hasFile('product_image')) {
            if ($product->product_image && file_exists(public_path($product->product_image))) {
                unlink(public_path($product->product_image));
            }
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('uploads/products'), $imageName);
            $product->product_image = '/uploads/products/' . $imageName;
        }

        $product->save();

        // Handle ProductTypes
        $existingTypeIds = $product->productTypes()->pluck('id')->toArray(); // IDs in DB
        $submittedTypeIds = []; // IDs received from request

        if ($request->has('product') && is_array($request->product)) {
            foreach ($request->product as $typeData) {
                if (!empty($typeData['type']) && isset($typeData['price'])) {
                    if (!empty($typeData['id'])) {
                        // Update existing
                        $submittedTypeIds[] = $typeData['id'];
                        $existingType = \App\Models\ProductType::find($typeData['id']);
                        if ($existingType) {
                            $existingType->type = $typeData['type'];
                            $existingType->price = $typeData['price'];
                            $existingType->save();
                        }
                    } else {
                        // New create
                        $newType = \App\Models\ProductType::create([
                            'product_id' => $product->id,
                            'type' => $typeData['type'],
                            'price' => $typeData['price'],
                        ]);
                        $submittedTypeIds[] = $newType->id;
                    }
                }
            }
        }

        // Delete removed types
        $typesToDelete = array_diff($existingTypeIds, $submittedTypeIds);
        if (!empty($typesToDelete)) {
            \App\Models\ProductType::whereIn('id', $typesToDelete)->delete();
        }

        return redirect('/products')->with('success', 'उत्पाद सफलतापूर्वक अपडेट किया गया।');
    }

    return view('admin.products.edit', [
        'product' => $product,
        'categories' => \App\Models\Categories::where('type', 'category')->orderBy('id', 'DESC')->get(),
        'productTypes' => \App\Models\ProductType::where('product_id', $id)->get(),
    ]);
}


public function product_status_update(Request $request)
{
    if ($request->ajax()) {
        $product = \App\Models\Product::find($request->id);
        if ($product) {
            $product->status = $request->status;
            $product->save();
            return response()->json(['success' => true, 'message' => 'उत्पाद स्थिति सफलतापूर्वक अपडेट की गई।']);
        }
        return response()->json(['success' => false, 'message' => 'उत्पाद नहीं मिला।']);
    }
    return response()->json(['success' => false, 'message' => 'अवैध अनुरोध।']);
    
}

public function help_line(Request $request)
{
    $setting = Setting::firstOrNew(['id' => 1]);

    if ($request->isMethod('post')) {
        $request->validate([
            'helplines' => 'required|array|min:1',
            'helplines.*.number' => 'required|string|max:255',
            'helplines.*.destination' => 'required|string|max:255',
        ]);

        $setting->name = 'helpline_number';
        $setting->value = json_encode($request->helplines); // save as JSON array
        $setting->save();

        return redirect()->back()->with('success', 'हेल्पलाइन नंबर सफलतापूर्वक अपडेट किए गए।');
    }

    return view('admin.help_line.index', compact('setting'));
}


public function delete_village($id) {
    $village = \App\Models\Locations::find($id);
    
    if ($village->type !== 'village') {
        return redirect()->back()->with('error', 'केवल गाँव को हटाया जा सकता है।');
    }

    $user = \App\Models\User::where('village', $id)->first();
    if ($user) {
        return redirect()->back()->with('error', 'इस गाँव से संबंधित उपयोगकर्ता मौजूद हैं, पहले उन्हें हटाएं।');
    }
    if ($village) {
        $village->delete();
        return redirect()->back()->with('success', 'गाँव सफलतापूर्वक हटाया गया।');
    }
    return redirect()->back()->with('error', 'गाँव नहीं मिला।');
}

public function products_villages_stock(Request $request)
{
    if ($request->ajax()) {

        // Check user role
        $user = Auth::user();

        if ($user->role == 'admin') {
            // Admin: show all villages
            $data = Locations::where('type', 'village')->orderBy('id', 'DESC')->get();
        } elseif ($user->role == 'team') {
            // Team: show only permitted stock_villages
            $villageIds = json_decode($user->stock_villages, true);

            // If null or not an array, show empty collection
            if (!is_array($villageIds) || empty($villageIds)) {
                $data = collect(); // empty
            } else {
                $data = Locations::where('type', 'village')
                    ->whereIn('id', $villageIds)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
        } else {
            // Default: no access
            $data = collect();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="/manage-stock-village/' . $row->id . '" class="btn btn-sm btn-danger"><i class="feather feather-list me-2"></i>Products</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('admin.stock.villageslist');
}

public function manage_stock_village(Request $request , $id){
    $villageId = $id;

    if (request()->ajax()) {
        $products = \App\Models\Product::with(['category', 'productTypes','village_stocks'])->latest()->get();

        return DataTables::of($products)
            ->addIndexColumn()
            ->editColumn('product_name', function ($row) {
                return e($row->product_name);
            })

            ->addColumn('category_name', function ($row) {
                return $row->category->category_name ?? 'N/A';
            })

            ->addColumn('product_image', function ($row) {
                return $row->product_image
                    ? '<img src="' . asset($row->product_image) . '" width="50">'
                    : 'N/A';
            })
            ->addColumn('types', function ($row) {
                return $row->productTypes->map(function ($type) {
                    return $type->type . ' - ₹' . $type->price;
                })->implode('<br>');
            })

            ->addColumn('quantity', function ($row) use ($villageId) {
    $stock = $row->village_stocks->firstWhere('village_id', $villageId);
    return $stock ? $stock->quantity : 0;
})

          ->addColumn('status', function ($row) {
    $checked = $row->status === "Y" ? 'checked' : '';
    return '
        <div class="form-check form-switch">
            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
        </div>';
})

            ->addColumn('actions', function ($row) use ($villageId) {
               
                $stock = $row->village_stocks->firstWhere('village_id', $villageId);
                $ssstock = $stock ? $stock->quantity : 0;
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a data-bs-toggle="modal" data-bs-target="#myModal" href="javascript:void(0)" class="btn btn-sm btn-success mymodel" data-id="'.$row->id.'" stock="'. $ssstock.'" village-id="'.$villageId.'" >Open Stock Model</a>';
                $btn .= '</div>';
                return $btn;
            })

            ->rawColumns(['product_image', 'types', 'actions','status','quantity'])
            ->make(true);
    }
    return view('admin.stock.manage_stock_village_productlisg',compact('id'));
}

public function updateStock(Request $request)
{
    $request->validate([
        'village_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity'   => 'required|integer|min:0',
    ]);

    VillageProductStock::updateOrCreate(
        [
            'village_id' => $request->village_id,
            'product_id' => $request->product_id,
        ],
        [
            'quantity' => $request->quantity,
        ]
    );

    return response()->json(['success' => true, 'message' => 'Stock updated successfully!']);
}

public function updateUserBlockStatus(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'block_status' => 'required'
    ]);


        $user = User::find($request->user_id);
        
        
        $user->is_block = $request->block_status == "N" ? "N" : "Y";
        $user->save();
        return response()->json(['success' => true]);
}


public function deleteuser($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    try {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete the user.');
    }
}

public function view_user($userid) {
    $user = User::findOrFail($userid);
    return view('admin.users.view', compact('user'));
}
public function edit_user(Request $request, $userid)
{
    $user = User::findOrFail($userid);

    // If GET request → show form
    if ($request->isMethod('get')) {
        return view('admin.users.edit', compact('user'));
    }


    // If POST request → validate and update
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'dob' => 'nullable|date',
        'address' => 'nullable|string',
        'phone' => 'nullable|string|max:15',
        'password' => 'nullable|string|min:6',
    ]);

    // Update user fields
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->dob = $validated['dob'] ?? null;
    $user->address = $validated['address'] ?? null;
    $user->phone = $validated['phone'] ?? null;
    // If password filled, hash and update
    if (!empty($validated['password'])) {
        $user->password =Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->back()->with('success', 'User updated successfully.');
}


public function logoutadmin(){
    Auth::logout();
    return redirect('/admin/login');
}

public function healing_request(Request $request) {
    return view('admin.healings.index');
}


public function getHealingRequests(Request $request)
{
    $query = HealingRequest::with('user')->latest();

    // Filter by status or 'today'
    if ($request->type) {
        if ($request->type === 'today') {
            $query->whereDate('date', Carbon::today());
        } else {
            $query->where('status', $request->type); // pending, assigned, cancelled
        }
    }

    // Filter by date range if provided
    if ($request->from_date && $request->to_date) {
        $query->whereBetween('date', [$request->from_date, $request->to_date]);
    }

    return DataTables::of($query)
        ->addColumn('user_name', function ($row) {
            return $row->user ? $row->user->name : 'N/A';
        })
        ->addColumn('status', function ($row) {
            $badgeClass = match($row->status) {
                'pending'   => 'badge bg-warning',
                'assigned'  => 'badge bg-success',
                'cancelled' => 'badge bg-danger',
                default     => 'badge bg-secondary',
            };
            return '<span class="' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
        })
        ->addColumn('date', function ($row) {
    return \Carbon\Carbon::parse($row->date)->format('d-m-Y');
})
->addColumn('time', function ($row) {
    return \Carbon\Carbon::parse($row->time)->format('h:i A');
})
        ->addColumn('actions', function ($row) {
            return '
                <div class="d-inline-flex gap-1">

                 <a href="' . url('/admin/healing-requests/view-bids/' . $row->id) . '" class="btn btn-danger btn-sm" title="Bids">
                        View Bids
                    </a>

                    
                    <button 
                class="btn btn-outline-info btn-sm view-request-btn" 
                data-id="' . $row->id . '"
                data-user="' . ($row->user ? $row->user->name : 'N/A') . '"
                data-requirement="' . e($row->healing_requirement) . '"
                 data-date="' . \Carbon\Carbon::parse($row->date)->format('d-m-Y') . '"
               data-time="' . \Carbon\Carbon::parse($row->time)->format('h:i A') . '"
                data-status="' . ucfirst($row->status) . '"
                data-bs-toggle="modal" 
                data-bs-target="#viewRequestModal"
                title="View">
                <i class="ri-eye-line"></i>
            </button>

                 <button 
                class="btn btn-outline-success btn-sm edit-request-btn"
                data-id="' . $row->id . '"
                data-user_id="' . $row->user_id . '"
                data-requirement="' . e($row->healing_requirement) . '"
                data-date="' . \Carbon\Carbon::parse($row->date)->format('Y-m-d') . '"
                data-time="' . $row->time . '"
                data-status="' . $row->status . '"
                data-bs-toggle="modal" 
                data-bs-target="#editRequestModal"
                title="Edit">
                <i class="ri-edit-box-line"></i>
            </button>

                    <a href="' . url('/admin/healing-requests/delete/' . $row->id) . '" class="btn btn-outline-danger btn-sm"
                       onclick="return confirm(\'Are you sure you want to delete this request?\');" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </a>
                </div>';
        })
        ->rawColumns(['actions', 'status'])
        ->make(true);
}


public function update_healing_records(Request $request){
     $request->validate([
        'id' => 'required|exists:healing_requests,id',
        'healing_requirement' => 'required|string',
        'date' => 'required|date',
        'time' => 'required',
        'status' => 'required|in:pending,assigned,cancelled',
        // 'user_id' => 'required|exists:users,id',
    ]);

    $requestData = $request->only(['healing_requirement', 'date', 'time', 'status']);

    HealingRequest::where('id', $request->id)->update($requestData);

    return redirect()->back()->with('success', 'Healing Request updated successfully.');
}

public function viewbids($id) {
    $healingRequest = HealingRequest::with('bids.healer')->findOrFail($id); // assuming 'bids' is a relation on HealingRequest

    return view('admin.healings.viewbids', compact('healingRequest'));
}

public function assignHealer(Request $request)
{
    $request->validate([
        'healing_request_id' => 'required|exists:healing_requests,id',
        'bid_id' => 'required|exists:healing_bids,id',
    ]);

    $healingRequest = HealingRequest::findOrFail($request->healing_request_id);
    $bid = HealingBid::findOrFail($request->bid_id);

    $healingRequest->assigned_healer_id = $bid->healer_id;
    $healingRequest->status = 'assigned'; // optional
    $healingRequest->save();

    //  $now = Carbon::now();
    // $wallet = MonthlyWallet::firstOrCreate(
    //     [
    //         'user_id' => $bid->healer_id,
    //         'month' => $now->month,
    //         'year' => $now->year,
    //     ],
    //     [
    //         'credit' => 0,
    //         'debit' => 0,
    //         'balance' => 0,
    //     ]
    // );

    // $wallet->increment('credit');
    // $wallet->increment('balance'); 
    
    return redirect()->back()->with('success', 'Healer assigned successfully!');
}

}